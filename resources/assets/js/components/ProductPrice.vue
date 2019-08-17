<template>
    <div>
        <input type="text" class="form-control" @change="changePrice" v-model="price">
    </div>
</template>

<script>
    export default {
        props: ['productId', 'productPrice'],


        data: function () {
            return {
                price: this.productPrice
            }
        },

        methods: {
            changePrice() {
                axios.post('/products/' + this.productId, {price: this.price})
                    .then(response => {
                        toastr.success('Данные обновлены', 'Успех!');
                    })
                    .catch(errors => {
                        toastr.error(errors.message, 'Ошибка!');
                    });
            }
        },
        watch: {
            price(after) {
                this.price = after;
            }
        },
    }
</script>
