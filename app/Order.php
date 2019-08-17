<?php

namespace App;

use App\Jobs\OrderDoneJob;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NEW = 0;
    const STATUS_SUBMITTED = 10;
    const STATUS_DONE = 20;

    protected $guarded = [];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getOrderProductsPriceAmount()
    {
        return $this->orderProducts()->sum('price');
    }

    public function getOrderProductsQuantityAmount()
    {
        return $this->orderProducts()->sum('quantity');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return 'новый';
            case 10:
                return 'подтвержден';
            case 20:
                return 'завершен';
            default:
                return 'неизвестен';
        }
    }

    public function updateOrder(array $data)
    {
        $this->update([
            'client_email' => $data['client_email'],
            'status' => $data['status'],
        ]);
        $this->partner()->update(['name' => $data['name']]);

        if ($data['status'] == self::STATUS_DONE) {

            dispatch(new OrderDoneJob($this, $this->partner->email))->onQueue('email');

            foreach ($this->orderProducts as $orderProduct) {
                dispatch(new OrderDoneJob($this, $orderProduct->product->vendor->email))->onQueue('email');
            }
        }
    }

    public static function getAll()
    {
        return static::paginate(15);
    }

    public static function getExpired()
    {
        return static::where([
            ['delivery_dt', '<', now()],
            'status' => self::STATUS_SUBMITTED,
        ])
            ->oldest('delivery_dt')
            ->paginate(50);
    }

    public static function getCurrent()
    {
        return static::where('status', self::STATUS_SUBMITTED)
            ->whereBetween('delivery_dt', [now(), now()->addDay(1)])
            ->latest('delivery_dt')
            ->paginate(50);
    }

    public static function getNew()
    {
        return static::where([
            ['delivery_dt', '>', now()],
            'status' => self::STATUS_NEW,
        ])
            ->latest('delivery_dt')
            ->paginate(50);
    }

    public static function getDone()
    {
        return static::where([
            ['delivery_dt', '<=', now()],
            'status' => self::STATUS_DONE,
        ])
            ->oldest('delivery_dt')
            ->paginate(50);
    }

    public function isExpired()
    {
        return ($this->delivery_dt < now() && $this->status == self::STATUS_SUBMITTED) ? true : false;
    }

    public function isCurrent()
    {
        return ($this->delivery_dt > now() && $this->delivery_dt < now()->addDay(1) && $this->status == self::STATUS_SUBMITTED) ? true : false;
    }

    public function isNew()
    {
        return ($this->delivery_dt > now() && $this->status == self::STATUS_NEW) ? true : false;
    }

    public function isDone()
    {
        return ($this->delivery_dt <= now() && $this->status == self::STATUS_DONE) ? true : false;
    }

    public function getActiveTabRoute()
    {
        if ($this->isExpired()) {
            return 'ordersExpired';
        }
        if ($this->isCurrent()) {
            return 'ordersCurrent';
        }
        if ($this->isNew()) {
            return 'ordersNew';
        }
        if ($this->isDone()) {
            return 'ordersDone';
        }
    }
}
