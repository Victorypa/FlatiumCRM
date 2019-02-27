<template>
    <div class="row col-10 fixed-part shadow bg-white rounded pl-3 align-items-center">
      <div class="col-md-8">
        <h1 class="main-caption">
          {{ order.order_name }} ({{ order.address }})
        </h1>
      </div>

      <div class="col-md-2 ml-auto">
          <router-link :to="{ name: 'order-panel', params: { id: order.id } }">
              <button type="button" class="primary-button w-100">Редактировать</button>
          </router-link>
      </div>

      <div class="col-12 pt-3 d-flex">
          <div class="main-subtitle px-15 col-auto pl-0"> Итого: {{ servicePrice }} Р <span>(работы)</span></div>
          <div class="main-subtitle px-15 col-auto"> {{ materialPrice }} Р<span>(материалы)</span></div>
          <div class="main-subtitle px-15 col-auto"> Приход: {{ income }} Р</div>
          <div class="main-subtitle px-15 col-auto"> Прибыль: {{ filteredProfit }} Р</div>
      </div>

    </div>
</template>

<script>
    export default {
        props: ['order', 'service_price', 'material_price', 'income_amount', 'profit'],

        computed: {
            servicePrice () {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(this.service_price))
            },

            materialPrice () {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(this.material_price))
            },

            income () {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(this.income_amount))
            },

            filteredProfit () {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(this.profit))
            }
        }
    }
</script>
