<template>
    <div class="row col-12 fixed-part align-items-center shadow-light">

      <div class="col-md-10">
        <h1 class="main-caption w-100">
          Этапы работ
        </h1>
      </div>

      <div class="col-md-2">
          <router-link :to="{ name: 'order-step-graphic', params: { id: order.id } }">
              <button type="button" class="primary-button w-100" onClick="window.location.reload(true)">
                  Смотреть график
              </button>
          </router-link>
      </div>

      <div class="col-md-6 pt-3">
        <h2 class="main-subtitle"> Итого по смете: {{ orderPrice }} Р</h2>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['order'],

        computed: {
            orderPrice () {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(this.order.price))
            }
        }
    }
</script>
