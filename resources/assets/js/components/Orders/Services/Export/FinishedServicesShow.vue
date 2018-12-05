<template>
  <div>

    <basic-header></basic-header>

    <div class="projects">

      <div class="container-fluid ">
        <div class="row">
          <navigation></navigation>

          <div class="col-md-10">

            <div class="row col-10 fixed-part shadow bg-white rounded pl-3 align-items-center">

                <template v-if="finished_order">
                    <template v-if="finished_order.description">
                        <div class="col-md-8">
                          <h1 class="main-caption">
                            {{ finished_order.description }}
                          </h1>
                        </div>
                    </template>

                    <template v-else>
                        <div class="col-md-8">
                          <h1 class="main-caption">
                            {{ finished_order.name }}
                          </h1>
                        </div>
                    </template>
                </template>

                <template v-if="finished_order && finished_order.order">
                      <div class="col-md-2 ml-auto">
                          <router-link :to="{ name: 'order-finished-services', params: { id: finished_order.order.id, finished_act_id: finished_order.id } }">
                              <button type="button" class="primary-button w-100">Редактировать</button>
                          </router-link>
                      </div>


                      <div class="col-md-6 pt-3">
                        <h2 class="main-subtitle"> Итого по акту: {{ new Intl.NumberFormat('ru-Ru').format(finished_order.price) }} Р</h2>
                      </div>
                  </template>

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
                          @click.prevent="exportFile(0)">
                            Экспорт
                  </button>
                </div>
              </div>
            </div>

            <template v-if="finished_order && finished_order.finished_rooms">
                <div class="col-12 px-0" v-for="finished_room in finished_order.finished_rooms">

                  <div class="px-15">
                      <template v-if="finished_room.room.description">
                          <h2 class="main-subtitle main-subtitle--room pl-3">
                              {{ finished_room.room.description }}
                          </h2>
                      </template>
                      <template v-else>
                          <h2 class="main-subtitle main-subtitle--room">
                              {{ finished_room.room.room_type.type }}
                          </h2>
                      </template>
                      <template v-if="finished_room.room.room_type_id === 1">
                            <div class="projects__desc col-8 d-flex justify-content-between align-items-center py-3 pl-0">
                                <div class="projects__desc-item">Общая площадь: {{ finished_room.room.area }} м<sup>2</sup></div>
                                <div class="projects__desc-item">Высота потолка: {{ finished_room.room.heigth }} м</div>
                                <div class="projects__desc-item">Площадь стен: {{ finished_room.room.wall_area }} м<sup>2</sup></div>
                                <div class="projects__desc-item">Периметр: {{ finished_room.room.perimeter }}</div>
                            </div>
                        </template>
                  </div>

                  <template v-if="finished_room.finished_services">
                      <template v-for="(finished_services, service_type_id) in groupByServiceType(finished_room.finished_services)">
                          <div class="projects__information ">
                              <div class="row bg px-3">

                                <div class="main-subtitle main-subtitle--fz col-12 pt-4 pl-3">
                                  {{ getServiceTypeName(service_type_id) }}
                                </div>

                                <div class="col-12 px-0">

                                  <table class="table table-hover">

                                    <tbody>
                                      <tr v-for="finished_service in finished_services">
                                        <th scope="row" class="w-50">{{ finished_service.name }}</th>
                                        <td>{{ finished_service.pivot.quantity }}м<sup>2</sup></td>

                                        <template v-if="finished_order.order.discount">
                                            <template v-if="finished_service.can_be_discounted">
                                                <td>{{ finished_service.price * (1 - parseInt(finished_order.order.discount)/100) }} Р</td>
                                                <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price * (1 - parseInt(finished_order.order.discount)/100)) }} Р</td>
                                            </template>
                                            <template v-else>
                                                <td>{{ finished_service.price }} Р</td>
                                                <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price) }}</td>
                                            </template>
                                        </template>
                                        <template v-if="finished_order.order.markup">
                                            <td>{{ finished_service.price * (1 + parseInt(finished_order.order.markup)/100) }} Р</td>
                                            <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price * (1 + parseInt(finished_order.order.markup)/100)) }} Р</td>
                                        </template>
                                        <template v-if="finished_order.order.discount === null && finished_order.order.markup === null">
                                            <td>{{ finished_service.price }} Р</td>
                                            <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price) }}</td>
                                        </template>
                                      </tr>

                                    </tbody>
                                  </table>

                                </div>
                              </div>
                          </div>
                      </template>
                  </template>

                </div>

            </template>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
let moment = require("moment")
import Datepicker from 'vuejs-datepicker';
import { ru } from 'vuejs-datepicker/dist/locale'
import OrderExportCollection from '../../../../mixins/OrderExportCollection'
import ServiceCollection from '../../../../mixins/ServiceCollection'

export default {
    mixins: [OrderExportCollection, ServiceCollection],

    data () {
        return {
            finished_order: [],
            description: null,
            price: null,

            state: {
                begin_at: moment(new Date()).format("DD-MMM-YYYY"),
                finish_at: moment(new Date()).format("DD-MMM-YYYY")
            },

            ru,
            moment
        }
    },

    components: {
        Datepicker
    },

    mounted () {
        this.getFinishedOrderAct()
    },

    methods: {
        getFinishedOrderAct () {
            return axios.get(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/show`)
                        .then(response => {
                            this.finished_order = response.data
                            this.description = response.data.description
                            this.price = response.data.price
                            this.state.begin_at = response.data.begin_at
                            this.state.finish_at = response.data.finish_at
                        })
        },

        getServiceTypeName (service_type_id) {
            if (this.service_types && service_type_id) {
                return this.service_types.filter(row => {
                    return row.id === parseInt(service_type_id)
                })[0].name
            }
        },

        updateFinishedOrderAct () {
            axios.patch(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/update`, {
                'state': this.state
            })
        },

        exportFile () {
            axios.get(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/export/pdf`)
                 .then(response => {
                     window.open(`${response.data.url}/storage/${response.data.data}`)
                 })
        },
    }
};
</script>

<style lang="scss" scoped>
$white: #fff;
$text-color: #777777;
$ccc: #CCCCCC;
$main-color: #00A4D1;
$button-hover:#03B8E9;

.fixed-part {
  position: fixed;
  background-color: $white;
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
