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

      <!-- <div class="col-12 pt-3 d-flex">
        <div class="main-subtitle px-15 col-auto pl-0"> Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(service_price)) }} Р <span>(работы)</span></div>
        <div class="main-subtitle px-15 col-auto"> {{ new Intl.NumberFormat('ru-Ru').format(parseInt(material_price)) }} Р<span>(материалы)</span></div>
        <div class="main-subtitle px-15 col-auto"> Приход: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(income_amount)) }} Р</div>
        <div class="main-subtitle px-15 col-auto"> Прибыль: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(profit)) }} Р</div>
      </div> -->

    </div>
</template>

<script>
    export default {
        props: ['order']
    }
</script>
