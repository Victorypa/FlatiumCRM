<template>
    <div class="row col-10 fixed-part shadow bg-white rounded align-items-center">
        <div class="col-md-8">
          <h1 class="main-caption w-100">
            {{ finished_order_act.description ? finished_order_act.description : 'Акт выполненных работ' }}
          </h1>
        </div>

        <router-link class="col-md-2 ml-auto" v-if="order.length !== 0" :to="{ name: 'order-finished-services-export-show', params: { id: order.id, finished_act_id: finished_order_act.id } }" target="_blank">
            <button type="button" class="primary-button w-100">Экспорт</button>
        </router-link>


        <div class="col-md-6 pt-3 d-flex align-items-center">
            <h2 class="main-subtitle">Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р</h2>
            <div class="d-flex pl-3">
              <span class="small-case">
                  {{ filteredInteger(order.original_price) }} Р
              </span>
              <span class="small-case" v-if="order.discount">
                  (скидка: -{{ parseInt(order.discount) }}%)
              </span>
              <span class="small-case" v-if="order.markup">
                  (наценка: +{{ parseInt(order.markup) }}%)
              </span>
            </div>
        </div>

        <div class="col-md-6 pt-3 d-flex justify-content-end px-0">
          <div class="col-12 text-right">
            <h2 class="main-subtitle px-15" v-if="finished_order_act.price">
                {{ filteredInteger(finished_order_act.price) }} Р
            </h2>
          </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '@/bus'
    export default {
        props: ['finished_order_act', 'order'],

        mounted () {
            EventBus.$on('fetched-price', (value) => {
                console.log(value);
            })
        },

        methods: {
            filteredInteger (data) {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(data))
            }
        }
    }
</script>
