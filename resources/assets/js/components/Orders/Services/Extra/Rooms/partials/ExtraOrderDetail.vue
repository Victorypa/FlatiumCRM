<template>
    <div class="container-fluid px-0">

        <div class="create__fixed-top col-10 px-0 shadow-light align-items-center pl-3 pb-3">
            <div class="row align-items-center pb-3">
            <div class="col-10 d-flex">

                <h1 class="main-caption mb-0 col-auto pl-0">
                  {{ extra_order_act.description ? extra_order_act.description : 'Акт дополнительных работ' }}
                </h1>

                  <div class="col-md-7 pt-3 pl-0">
                      <div class="main-caption px-15">
                          {{ extra_order_act.order.address ? extra_order_act.order.address : extra_order_act.order.order_name }}
                      </div>
                  </div>

              </div>
               <!-- <div class="col-md-2 pl-0">
                   <router-link :to="{ name: 'order-extra-services-export-show', params: { id: order.id, extra_order_act_id: extra_order_act.id } }">
                       <button type="button" class="primary-button w-100">
                           Экспорт
                       </button>
                   </router-link>
                </div> -->

                <h2 class="main-subtitle px-15"> Итого по акту: {{ filteredExtraActPrice }} Р</h2>
        </div>

      </div>

    </div>
</template>

<script>
    export default {
        props: ['extra_order_act'],

        computed: {
            filteredExtraActPrice () {
                return new Intl.NumberFormat('ru-Ru').format(this.extra_order_act.price)
            }
        }
    }
</script>
