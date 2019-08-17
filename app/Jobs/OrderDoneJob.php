<?php

namespace App\Jobs;

use App\Mail\OrderDoneMail;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class OrderDoneJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $email = '')
    {
        $this->order = $order;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new OrderDoneMail($this->order);
        Mail::to($this->email)->send($email);
    }
}
