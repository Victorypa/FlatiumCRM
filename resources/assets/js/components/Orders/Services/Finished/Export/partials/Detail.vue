<template>
    <div>
        <div class="row col-10 fixed-part shadow bg-white rounded pl-3 align-items-center">
            <div class="col-md-8">
              <h1 class="main-caption">
                {{ finished_order_act.description ? finished_order_act.description : finished_order_act.name }}
              </h1>
            </div>

            <div class="col-md-2 ml-auto">
                <router-link :to="{ name: 'order-finished-act-show', params: { id: finished_order_act.order.id, finished_act_id: finished_order_act.id } }">
                    <button type="button" class="primary-button w-100">Редактировать</button>
                </router-link>
            </div>

            <div class="col-md-6 pt-3">
              <h2 class="main-subtitle"> Итого по акту: {{ filteredPrice }} Р</h2>
            </div>

        </div>

        <div class="row projects__content col-12 mt-3">
          <div class="form-group d-flex align-items-center col-6">
            <datepicker class="my-datepicker"
                        placeholder="Начало"
                        :language="ru"
                        v-model="state.begin_at"
                        @selected="updateFinishedOrderAct()"
                        >
            </datepicker>

            <datepicker class="my-datepicker pl-3"
                        placeholder="Окончание"
                        :language="ru"
                        v-model="state.finish_at"
                        @selected="updateFinishedOrderAct()"
                        >
            </datepicker>
            <div class="col-md-3">
              <button type="button"
                      class="primary-button w-100"
                      @click.prevent="exportFile()">
                        Экспорт
              </button>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import { ru } from 'vuejs-datepicker/dist/locale'

    export default {
        props: ['finished_order_act'],

        components: {
            Datepicker
        },

        data () {
            return {
                ru,

                state: {
                    begin_at: this.finished_order_act.begin_at,
                    finish_at: this.finished_order_act.finish_at
                }
            }
        },

        methods: {
            exportFile () {
                axios.get(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/export/pdf`)
                     .then(response => {
                         window.open(`${response.data.url}/storage/${response.data.data}`)
                     })
            },

            updateFinishedOrderAct () {
                axios.patch(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/update`, {
                    'state': this.state
                })
            }
        },

        computed: {
            filteredPrice () {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(this.finished_order_act.price))
            }
        }
    }
</script>

<style scoped lang="scss">
$white: #fff;
$text-color: #777777;
$ccc: #CCCCCC;
$main-color: #00A4D1;
$button-hover:#03B8E9;

    .fixed-part {
      position: fixed;
      background-color: #fff;
      padding-bottom: 35px;
      padding-top: 85px;
      z-index: 999;
    }


    .projects {
      &__content {
        padding-top: 250px;
        padding-bottom: 20px;
        .form-group {
          margin-bottom: 0;
          input {
            &:first-child {
              margin-left: 0;
            }
            margin-left: 10px;
          }
        }
        .form-control {
          color: 666;
          height: 45px;
        }
      }
      &__desc {
        font-weight: bold;
        color: $text-color;
      }
      &__information {
        .table {
          color: $text-color;
          td {
            width: 13%;
          }
          th {
            font-weight: normal;
          }
        }
      }
    }

    .my-datepicker {
      line-height: 21px;
    }
    .main-subtitle--room {
      padding-top: 75px;
    }


</style>
