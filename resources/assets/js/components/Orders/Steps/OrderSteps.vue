<template>
  <div>
    <basic-header></basic-header>

    <section class="work-stages">

      <div class="container-fluid px-0">
        <div class="row">
          <navigation></navigation>

          <div class="col-md-10 px-0">

              <OrderDetail :order="order" />

            <div class="stages__pt"></div>

            <template v-for="(order_step, index) in order_steps">
                <div class="px-0 mx-4 mt-5 stages shadow-light" :style="{ border: `3px solid ${order_step.color}` }" :key="index">
                    <div class="row w-100 align-items-center py-4 mb-3 stages-border">
                        <div class="col-12 d-flex align-items-center justify-content-between mb-2">
                          <div class="col-md-6">

                              <template v-if="order_step_descriptions[order_step.id]">
                                  <template v-if="!show_input">
                                      <div class="main-subtitle" @click="showInput()">
                                          {{ order_step_descriptions[order_step.id] }}
                                      </div>
                                  </template>
                                  <template v-else>
                                      <input class="form-control" v-model="order_step_descriptions[order_step.id]" @mouseleave="updateOrderStepDescription(order_step.id, order_step_descriptions[order_step.id])" />
                                  </template>
                              </template>
                              <template v-else>
                                  <template v-if="!show_input">
                                      <div class="main-subtitle" @click="showInput()">
                                          {{ order_step.name }}
                                          <img src="/img/edit.svg" alt="add-button" title="Редактировать">
                                      </div>
                                  </template>
                                  <template v-else>
                                      <input class="form-control" v-model="order_step_descriptions[order_step.id]" @mouseleave="updateOrderStepDescription(order_step.id, order_step_descriptions[order_step.id])" />
                                  </template>
                              </template>

                          </div>
                          <div class="col-md-6 d-flex justify-content-end align-items-center pl-0">
                            <datepicker class="my-datepicker"
                                        calendar-class="my-datepicker_calendar"
                                        :language="ru"
                                        orientation="top"
                                        placeholder="Начало"
                                        v-model="order_step_begin_ats[order_step.id]"
                                        @input="updateOrderStepBeginAt(order_step.id, order_step_begin_ats[order_step.id])"
                                        >
                            </datepicker>

                            <datepicker class="my-datepicker ml-3"
                                        calendar-class="my-datepicker_calendar"
                                        :language="ru"
                                        placeholder="Окончание"
                                        v-model="order_step_finish_ats[order_step.id]"
                                        @input="updateOrderStepFinishAt(order_step.id, order_step_finish_ats[order_step.id])"
                                        >
                            </datepicker>
                          </div>
                        </div>

                    <div class="rooms_wrapper col-12 px-0">

                        <template v-if="order_step.room_steps">
                            <template v-for="(room_step, index) in order_step.room_steps">
                                <template v-if="room_step.services.length">

                                    <div class="col-12 d-flex align-items-center">
                                        <h2 class="col-6 main-subtitle main-subtitle--font py-4 pl-3">
                                            <template v-if="room_step.room.description">
                                                {{ room_step.room.description }}
                                            </template>
                                            <template v-else>
                                                {{ room_step.room.room_type.type }}
                                            </template>
                                            {{ index + parseInt(1) }}
                                        </h2>
                                        <template v-if="room_step.room.room_type_id === 1">
                                            <div class="col-6 d-flex justify-content-end align-items-center pt-3">
                                              <div class="projects__desc-item pr-3">S: {{ parseFloat(room_step.room.area).toFixed(2) }} м<sup>2</sup></div>
                                              <div class="projects__desc-item pr-3">H: {{ parseFloat(room_step.room.height).toFixed(2) }} м</div>
                                              <div class="projects__desc-item pr-3">S стен: {{ parseFloat(room_step.room.wall_area).toFixed(2) }} м<sup>2</sup></div>
                                              <div class="projects__desc-item">P: {{ parseFloat(room_step.room.perimeter).toFixed(2) }} м. п.</div>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="col-12 d-flex align-items-center">
                                        <div class="col-6 table-subtitle table-subtitle__items px-3">Наименование
                                        </div>
                                        <div class="col-6 d-flex justify-content-end table-subtitle__items">
                                          <div class="table-subtitle">Кол-во</div>
                                          <div class="table-subtitle">Цена</div>
                                          <div class="table-subtitle">Стоимость</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                      <table class="table drag-table">
                                        <tbody>
                                            <template v-if="room_step.services">
                                                <template v-for="(room_step_services, service_type_id) in groupByServiceType(room_step.services)">
                                                    <tr>
                                                      <th colspan="4" class="table__transparent-row">
                                                          {{ getServiceTypeName(service_type_id) }}
                                                      </th>
                                                    </tr>

                                                    <template v-for="room_step_service in room_step_services">
                                                        <tr>
                                                            <div :style="{ 'background-color': order_step.opacity_color }" class="d-flex justify-content-between">
                                                              <th scope="row" class="col-6">
                                                                <div class="form-check custom-control checkbox">
                                                                  <input type="checkbox"
                                                                         class="form-check-input check"
                                                                         :id="'room-step-' + room_step.id + '-room-step-service-' + room_step_service.id"
                                                                         :checked="true"
                                                                         @click="detachSelectedService(room_step.id, room_step_service.id)"
                                                                         >

                                                                  <label class="form-check-label d-block"
                                                                         :for="'room-step-' + room_step.id + '-room-step-service-' + room_step_service.id"
                                                                        >
                                                                        {{ room_step_service.name }}
                                                                  </label>
                                                                </div>
                                                              </th>

                                                              <div class="col-6 d-flex justify-content-end">
                                                                  <td>{{ parseFloat(room_step_service.pivot.quantity).toFixed(2) }} м<sup>2</sup></td>
                                                                  <td>{{ new Intl.NumberFormat('ru-Ru').format(parseInt(room_step_service.price)) }} Р/ м<sup>2</sup></td>
                                                                  <td>{{ priceCount(room_step_service.pivot.quantity, room_step_service.price) }} Р</td>
                                                              </div>
                                                            </div>
                                                        </tr>
                                                    </template>

                                                </template>
                                            </template>
                                        </tbody>
                                      </table>
                                    </div>
                                </template>


                            </template>

                            <div class="col-12">
                              <div class="col-12 d-flex align-items-center pl-0">
                                <div class="col-6 pl-0">
                                    <button class="add-button add-button--remove d-flex align-items-center"
                                            title="Удалить этап"
                                            @click="deleteOrderStep(order_step.id)"
                                            >
                                            <img src="/img/del.svg" alt="add-button" class="mr-2">
                                            Удалить этап
                                    </button>
                                </div>

                                <div class="stages__summ col-6 text-right">
                                   Итого за этап: <span>{{ new Intl.NumberFormat('ru-Ru').format(order_step.price) }} Р</span>
                                </div>
                              </div>
                            </div>
                        </template>


                    </div>
                </div>
            </div>
        </template>

        <div class="row col-12">
          <button class="add-space-button py-2" @click="createNewOrderStep()">
              + Создать новый этап
          </button>
        </div>


        <div class="col-12 px-0"
             v-if="order.rooms"
             v-for="(room, index) in order.rooms"
             >

          <div class="col-12 d-flex align-items-center">
            <h2 class="col-6 main-subtitle py-4 pl-3">
              {{ room.description ? room.description : room.room_type.type }}
            </h2>

            <div class="col-6 d-flex justify-content-end align-items-center pt-3 pl-3">
                <div class="projects__desc-item pr-3">S: {{ parseFloat(room.area).toFixed(2) }} м<sup>2</sup></div>
                <div class="projects__desc-item pr-3">H: {{ parseFloat(room.height).toFixed(2) }} м</div>
                <div class="projects__desc-item pr-3">S стен: {{ parseFloat(room.wall_area).toFixed(2) }} м<sup>2</sup></div>
                <div class="projects__desc-item">P: {{ parseFloat(room.perimeter).toFixed(2) }} м. п.</div>
            </div>
          </div>

          <div class="col-12 d-flex align-items-center">
              <div class="col-6 table-subtitle table-subtitle__items px-3">Наименование
              </div>
              <div class="col-6 d-flex justify-content-end px-0 table-subtitle__items">
                <div class="table-subtitle">Кол-во</div>
                <div class="table-subtitle">Цена</div>
                <div class="table-subtitle">Стоимость</div>
              </div>
          </div>

          <div class="material-info">

            <div class="row mx-3">
              <div class="col-12 px-0">
                <table class="table drag-table">
                  <tbody v-if="room.room_services">
                      <template v-for="(room_services, service_type_id) in groupByServiceType(room.room_services)">
                          <tr>
                              <th colspan="4" class="table__transparent-row">
                                  <template v-if="service_types">
                                      {{ getServiceTypeName(service_type_id) }}
                                  </template>
                              </th>
                          </tr>
                          <tr>
                              <div v-for="room_service in room_services" class="item d-flex justify-content-between">

                                  <th scope="row" class="col-6">
                                    <div class="form-check custom-control checkbox">
                                      <input type="checkbox"
                                             class="form-check-input check"
                                             :id="'room-' + room.id + '-service-' + room_service.service_id"
                                             @click="addSelectedServiceIds(
                                                 room.id, room_service.service_id,
                                                 room_service.quantity
                                                 )"
                                             >
                                      <label class="form-check-label d-block"
                                             :for="'room-' + room.id + '-service-' + room_service.service_id"
                                             >
                                          {{ getServiceDetails(room_service.service_id, 'name') }}
                                      </label>
                                    </div>
                                  </th>
                                  <div class="col-6 d-flex justify-content-end px-0">
                                      <td>{{ parseFloat(room_service.quantity).toFixed(2) }} {{ room_service.unit.name }}</td>

                                      <template v-if="order.discount">
                                          <template v-if="getServiceDetails(room_service.service_id, 'can_be_discounted')">
                                              <td>{{ parseInt(getServiceDetails(room_service.service_id, 'price') * (1 - parseInt(order.discount)/100)) }} Р/{{ room_service.unit.name }}</td>
                                              <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price') * (1 - parseFloat(order.discount)/100)) }} Р</td>
                                          </template>
                                          <template v-else>
                                              <td>{{ parseInt(getServiceDetails(room_service.service_id, 'price')) }} Р/{{ room_service.unit.name }}</td>
                                              <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price')) }} Р</td>
                                          </template>
                                      </template>
                                      <template v-if="order.markup">
                                          <td>{{ parseInt(getServiceDetails(room_service.service_id, 'price') * (1 + parseInt(order.markup)/100)) }} Р/{{ room_service.unit.name }}</td>
                                          <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price') * (1 + parseFloat(order.markup)/100)) }} Р</td>
                                      </template>
                                      <template v-if="order.discount === null && order.markup === null">
                                          <td>{{ parseInt(getServiceDetails(room_service.service_id, 'price')) }} Р/{{ room_service.unit.name }}</td>
                                          <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price')) }} Р</td>
                                      </template>
                                  </div>
                                </div>
                          </tr>
                      </template>
                  </tbody>
                </table>

              </div>
            </div>

          </div>

        </div>

            <div style="margin-bottom: 10em;"></div>

          </div>
        </div>

        <div class="fixed-footer d-flex align-items-center col-10" v-if="selected_service_ids.length">
          <div class="col-12 d-flex align-items-center justify-content-end pr-0">
            <div class="col-md-2" v-if="order_steps">
                <select class="w-100 form-control" v-model="selected_order_step_id">
                    <option value="">Выберите</option>
                    <option v-for="(order_step, index) in order_steps" :value="order_step.id">
                        {{ order_step.description ? order_step.description : order_step.name }}
                    </option>
                </select>
            </div>
            <div class="col-md-2">
              <button type="button" class="primary-button w-100" @click="linkSelectedServicesToRoomStepServices()">Добавить</button>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
</template>

<script>
  import OrderDetail from './partials/OrderDetail'
  import Datepicker from "vuejs-datepicker"
  import { ru } from "vuejs-datepicker/dist/locale"
  import OrderExportCollection from '../../../mixins/OrderExportCollection'
  import ServiceCollection from '../../../mixins/ServiceCollection'

  export default {
    mixins: [OrderExportCollection, ServiceCollection],

    data() {
      return {
          ru,
          order: [],

          order_step_descriptions: [],
          order_step_begin_ats: [],
          order_step_finish_ats: [],

          selected_order_step_id: '',
          selected_service_ids: [],

          order_steps: [],
          show_input: false,
          newSteps: [],
      }
    },

    components: {
      Datepicker, OrderDetail
    },

    created () {
        this.getOrder()
    },

    methods: {
        getOrder () {
            return axios.get(`/api/orders/${this.$route.params.id}/order_steps`)
                        .then(response => {
                            this.order = response.data
                            this.order_steps = _.sortBy(this.order.order_steps, ['id'])
                            this.order.order_steps.forEach(order_step => {
                                this.order_step_descriptions[order_step.id] = order_step.description
                                this.order_step_begin_ats[order_step.id] = order_step.begin_at
                                this.order_step_finish_ats[order_step.id] = order_step.finish_at
                            })
                        })
        },

        addSelectedServiceIds (room_id, service_id, quantity) {
            this.selected_service_ids.push({
                'room_id': room_id,
                'service_id': service_id,
                'quantity': quantity
            })
        },

        detachSelectedService (room_step_id, service_id) {
            axios.post(`/api/orders/${this.$route.params.id}/room_steps/${room_step_id}/services/${service_id}/detach`)
                 .then(response => {
                     this.getOrder()
                 })
        },

        linkSelectedServicesToRoomStepServices () {
            if (this.selected_order_step_id !== '') {
                axios.post(`/api/orders/${this.$route.params.id}/order_steps/${this.selected_order_step_id}/services/store`, {
                    'selected_service_ids': _.groupBy(this.selected_service_ids, 'room_id')
                }).then(response => {
                  window.location.reload(true)
                    // this.getOrder()
                })
            } else {
                alert('Выберите спринт')
            }
        },


        getServiceTypeName (service_type_id) {
            if (this.service_types && service_type_id) {
                return this.service_types.filter(row => {
                    return row.id === parseInt(service_type_id)
                })[0].name
            }
        },

        createNewOrderStep () {
            axios.post(`/api/orders/${this.$route.params.id}/order_step/store`)
                 .then(response => {
                     this.getOrder()
                 })
        },

        deleteOrderStep (order_step_id) {
            axios.delete(`/api/orders/${this.$route.params.id}/order_step/${order_step_id}/destroy`)
                 .then(response => {
                     this.getOrder()
                 })
        },

        showInput () {
            this.show_input = !this.show_input
        },

        updateOrderStepDescription (order_step_id, description) {
            axios.patch(`/api/orders/${this.$route.params.id}/order_step/${order_step_id}/update`, {
                'description': description
            }).then(response => {
                this.showInput()
                this.getOrder()
            })
        },

        updateOrderStepBeginAt (order_step_id, begin_at) {
            axios.patch(`/api/orders/${this.$route.params.id}/order_step/${order_step_id}/update`, {
                'begin_at': begin_at
            })
        },

        updateOrderStepFinishAt (order_step_id, finish_at) {
            axios.patch(`/api/orders/${this.$route.params.id}/order_step/${order_step_id}/update`, {
                'finish_at': finish_at
            })
        },

        priceCount (quantity, price) {
            return new Intl.NumberFormat('ru-Ru').format(parseInt(quantity * price))
        }
    }
  };
</script>

<style lang="scss" scoped>
    $white: #fff;
    $main-color: #00A4D1;
    $ccc: #CCCCCC;
    $button-hover:#03B8E9;
    $text-color: #777777;


  .form-check {
    &-label {
      padding-top: 1px;
      cursor: pointer;
      &:before {
        border: 1px solid $ccc;
        border-radius: 0;
      }
      &::after {
        position: absolute;
        left: -18px;
        top: 5px;
        padding-left: 3px;
        font-size: 11px;
        color: $main-color;
      }
      &:hover {
        color: $button-hover;
      }
    }
    input[type="checkbox"]:checked+label::after,
    .abc-checkbox input[type="radio"]:checked+label::after {
      font-family: "FontAwesome";
      content: "\f00c";
    }

  }

  .add-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    &:focus {
      outline: none;
    }
    img {
      width: 35px;
      border-radius: 50%;
      &:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      }
    }
    &--remove {
      color: $main-color;
      img {
        width: 15px;
      }
    }
  }

  .add-space {
    &-button {
      padding-left: 25px;
      color: $main-color;
      background-color: transparent;
      border: none;
      cursor: pointer;
      transition: 1s;
      &:focus {
        outline: none;
      }
    }
  }
  .my-datepicker {
    border: none;
    border-bottom: 1px solid #ccc;
    &:not(:first-child) {
        margin-right: 45px;
    }
  }


  .table {
    &-subtitle {
         width: 25%;
      &__items {
      background-color: #f2f4f5;
      }
      font-weight: bold;
      color: #000;
      background-color: #f2f4f5;
      padding: 0.75rem;
    }
    &__transparent-row {
      background-color: #fff;
    }
    tr {
      background-color: #eff8ff;
    }
    th, td {
        width: 25%;
      border-top: 0;
    }
  }

  .main {
    &-subtitle {
      margin-bottom: 0;
      &--font {
        font-size: 20px;
      }
      img {
        width: 14px;
        cursor: pointer;
      }
    }
}

</style>
