<template>
  <div>
    <basic-header></basic-header>

    <section class="work-stages">

      <div class="container-fluid ">
        <div class="row">
          <navigation></navigation>

          <div class="col-md-10">

            <div class="row col-10 fixed-part align-items-center shadow bg-white rounded">

              <div class="col-md-8">
                <h1 class="main-caption w-100">
                  График работ
                </h1>
              </div>

              <div class="col-md-2">
                  <template v-if="order.rooms">
                      <router-link :to="{ name: 'room-show', params: { id: order.id, room_id: order.rooms[0].id } }" >
                          <button type="button" class="primary-button w-100">
                              Редактировать
                          </button>
                      </router-link>
                  </template>
                  <template v-else>
                      <router-link :to="{ name: 'order-show', params: { id: order.id } }" >
                          <button type="button" class="primary-button w-100">
                              Редактировать
                          </button>
                      </router-link>
                  </template>
              </div>

              <div class="col-md-6 pt-3">
                <h2 class="main-subtitle px-15"> Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р</h2>
              </div>
            </div>


            <template v-for="(order_step, index) in order_steps">
                <div class="col-12 px-0 stages">
                  <div class="row align-items-center py-4 mb-3 mx-2 stages-border">
                        <div class="col-12 d-flex align-items-center justify-content-between mb-2">
                          <div class="col-md-6">

                              <template v-if="order_step.description">
                                  <div class="main-subtitle">
                                      {{ order_step.description }}
                                  </div>
                              </template>
                              <template v-else>
                                  <div class="main-subtitle">
                                      {{ order_step.name }}
                                  </div>
                              </template>

                          </div>
                          <div class="col-md-4 d-flex justify-content-end align-items-center pl-0">
                            <datepicker class="my-datepicker"
                                        :language="ru"
                                        placeholder="Начало"
                                        v-model="order_step.begin_at"
                                        >
                            </datepicker>

                            <datepicker class="my-datepicker ml-3"
                                        :language="ru"
                                        placeholder="Окончание"
                                        v-model="order_step.finish_at"
                                        >
                            </datepicker>
                          </div>
                        </div>



                    <div class="rooms_wrapper col-12 px-0">
                      <div class="col-12 d-flex align-items-center">
                          <h2 class="col-6 main-subtitle py-4 pl-3">
                            Комната 1
                          </h2>
                          <div class="col-6 d-flex justify-content-end align-items-center pt-3 pl-3">
                            <div class="projects__desc-item pr-3">S: 28 м<sup>2</sup></div>
                            <div class="projects__desc-item pr-3">H: 2,8 м м</div>
                            <div class="projects__desc-item pr-3">S стен: 80,1 м<sup>2</sup></div>
                            <div class="projects__desc-item">P: 29,8 м. п.</div>
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

                        <div class="col-12">
                          <table class="table drag-table">
                            <tbody>
                              <tr>
                                <th colspan="4" class="table__transparent-row">Стены</th>
                              </tr>
                              <tr>
                                  <draggable :list="list1" :options="{group:{ name: 'stuff'}}" @start="drag=true" @end="drag=false" :move="onMove">
                                    <div v-for="ele in list1" class="item d-flex justify-content-between">
                                      <th scope="row" class="col-6">
                                        <div class="form-check custom-control checkbox">
                                          <input type="checkbox" class="form-check-input check" id='1'>
                                          <label class="form-check-label d-block" for="1">{{ele.name}}</label>
                                        </div>
                                      </th>
                                      <div class="col-6 d-flex justify-content-end">
                                        <td>{{ele.per}}</td>
                                        <td>{{ele.price}}</td>
                                        <td>{{ele.summ}}</td>
                                      </div>
                                    </div>
                                  </draggable>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                        <div class="col-12">
                          <div class="col-12 d-flex align-items-center pl-0">
                            <div class="col-6 pl-0">
                                <button class="add-button add-button--remove d-flex align-items-center" title="Удалить этап" @click="removeStage(index)" >
                              <img src="/img/del.svg" alt="add-button" class="mr-2">
                              Удалить этап
                            </button>
                            </div>
                            <div class="stages__summ col-6 text-right">
                               Итого за этап: <span>10 000 Р</span>
                            </div>
                          </div>
                        </div>
                    </div>




          </div>
        </div>
        </template>




          <div class="row align-items-center py-4 mb-3 mx-2 stages-border" v-for="(form, index) in ListStages">
                <div class="col-12 d-flex align-items-center justify-content-between mb-2">
              <div class="col-md-6">
                <div class="main-subtitle">
                  Название этапа
                </div>
              </div>
              <div class="col-md-4 d-flex justify-content-end align-items-center pl-0">
                <datepicker class="my-datepicker" :language="ru"></datepicker>
                <datepicker class="my-datepicker ml-3" :language="ru"></datepicker>
              </div>
            </div>

                <div class="col-12 d-flex align-items-center">
              <h2 class="col-6 main-subtitle py-4 pl-3">
                Комната 1
              </h2>
              <div class="col-6 d-flex justify-content-end align-items-center pt-3 pl-3">

                <div class="projects__desc-item pr-3">S: 28 м<sup>2</sup></div>
                <div class="projects__desc-item pr-3">H: 2,8 м м</div>
                <div class="projects__desc-item pr-3">S стен: 80,1 м<sup>2</sup></div>
                <div class="projects__desc-item">P: 29,8 м. п.</div>
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

                <div class="col-12">
                  <table class="table drag-table">
                      <tr>
                        <th colspan="4" class="table__transparent-row">Стены</th>
                      </tr>
                      <tr>
                        <div>
                          <draggable :list="list1" :options="{group:{ name: 'stuff'}}" @start="drag=true" @end="drag=false" :move="onMove">
                            <div v-for="ele in list1" class="item d-flex justify-content-between">
                              <th scope="row" class="col-6">
                                <div class="form-check custom-control checkbox">
                                  <input type="checkbox" class="form-check-input check" id='1'>
                                  <label class="form-check-label d-block" for="1">{{ele.name}}</label>
                                </div>
                              </th>
                              <div class="col-6 d-flex justify-content-end">
                                <td>{{ele.per}}</td>
                                <td>{{ele.price}}</td>
                                <td>{{ele.summ}}</td>
                              </div>
                            </div>
                          </draggable>
                        </div>
                      </tr>
                    </tbody>
                  </table>
                </div>


                  <div class="col-12 d-flex align-items-center">
                    <h2 class="col-6 main-subtitle py-4 pl-3">
                      Комната 2
                    </h2>
                    <div class="col-6 d-flex justify-content-end align-items-center pt-3 pl-3">

                      <div class="projects__desc-item pr-3">S: 28 м<sup>2</sup></div>
                      <div class="projects__desc-item pr-3">H: 2,8 м м</div>
                      <div class="projects__desc-item pr-3">S стен: 80,1 м<sup>2</sup></div>
                      <div class="projects__desc-item">P: 29,8 м. п.</div>
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

                <div class="col-12">
                  <table class="table drag-table">
                    <tbody>
                      <tr>
                        <th colspan="4" class="table__transparent-row">Пол</th>
                      </tr>
                      <tr>
                        <div>
                          <draggable :list="list1" :options="{group:{ name: 'stuff'}}" @start="drag=true" @end="drag=false" :move="onMove">
                            <div v-for="ele in list1" class="item d-flex justify-content-between">
                              <th scope="row" class="col-6">
                                <div class="form-check custom-control checkbox">
                                  <input type="checkbox" class="form-check-input check" id='1'>
                                  <label class="form-check-label d-block" for="1">{{ele.name}}</label>
                                </div>
                              </th>
                              <div class="col-6 d-flex justify-content-end">
                                <td>{{ele.per}}</td>
                                <td>{{ele.price}}</td>
                                <td>{{ele.summ}}</td>
                              </div>
                            </div>
                          </draggable>
                        </div>
                      </tr>
                    </tbody>
                  </table>
                  <div class="col-12 d-flex align-items-center pl-0">
                    <div class="col-6 pl-0">
                        <button class="add-button add-button--remove d-flex align-items-center" title="Удалить этап" @click="removeStage(index)">
                      <img src="/img/del.svg" alt="add-button" class="mr-2">
                      Удалить этап
                    </button>
                    </div>
                    <div class="stages__summ col-6 text-right">
                       Итого за этап: <span>10 000 Р</span>
                    </div>
                  </div>
                </div>
              </div>

            <div class="row col-12">
              <button class="add-space-button py-2" @click="addSteps">+ Создать новый этап</button>
            </div>




            <template v-if="order.rooms">
                <template v-for="(room, index) in order.rooms">
                    <div class="col-12 px-0">

                      <div class="col-12 d-flex align-items-center">
                        <h2 class="col-6 main-subtitle py-4 pl-3">
                          <tempate v-if="room.description">
                              {{ room.description }}
                          </tempate>
                          <template v-else>
                              {{ room.room_type.type }} {{ index + parseInt(1) }}
                          </template>
                        </h2>

                        <div class="col-6 d-flex justify-content-end align-items-center pt-3 pl-3">
                            <div class="projects__desc-item pr-3">S: {{ room.area }} м<sup>2</sup></div>
                            <div class="projects__desc-item pr-3">H: {{ room.height }} м</div>
                            <div class="projects__desc-item pr-3">S стен: {{ room.wall_area }} м<sup>2</sup></div>
                            <div class="projects__desc-item">P: {{ room.perimeter }} м. п.</div>
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
                              <tbody>

                                  <template v-if="room.room_services">
                                      <template v-for="(room_services, service_type_id) in groupByServiceType(room.room_services)">
                                          <tr>
                                              <th colspan="4" class="table__transparent-row">
                                                  {{ getServiceTypeName(service_type_id) }}
                                              </th>
                                          </tr>
                                          <tr>
                                              <draggable :list="room_services" :options="{ group:{ name: 'room_services'} }" @start="drag=true" @end="drag=false" :move="onMove">
                                                <div v-for="room_service in room_services" class="item d-flex justify-content-between">

                                                  <th scope="row" class="w-75">
                                                    <div class="form-check custom-control checkbox">
                                                      <input type="checkbox"
                                                             class="form-check-input check"
                                                             :id="'room-' + room.id + '-service-' + room_service.service_id"
                                                             >
                                                      <label class="form-check-label d-block"
                                                             :for="'room-' + room.id + '-service-' + room_service.service_id"
                                                             >
                                                          {{ getServiceDetails(room_service.service_id, 'name') }}
                                                      </label>
                                                    </div>
                                                  </th>
                                                  <td>{{ parseFloat(room_service.quantity).toFixed(2) }} м<sup>2</sup></td>

                                                  <template v-if="order.discount">
                                                      <template v-if="getServiceDetails(room_service.service_id, 'can_be_discounted')">
                                                          <td>{{ getServiceDetails(room_service.service_id, 'price') * (1 - parseInt(order.discount)/100) }} Р/м<sup>2</sup></td>
                                                          <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price') * (1 - parseFloat(order.discount)/100)) }} Р</td>
                                                      </template>
                                                      <template v-else>
                                                          <td>{{ getServiceDetails(room_service.service_id, 'price') }} Р/м<sup>2</sup></td>
                                                          <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price')) }} Р</td>
                                                      </template>
                                                  </template>
                                                  <template v-if="order.markup">
                                                      <td>{{ getServiceDetails(room_service.service_id, 'price') * (1 + parseInt(order.markup)/100) }} Р/м<sup>2</sup></td>
                                                      <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price') * (1 + parseFloat(order.markup)/100)) }} Р</td>
                                                  </template>
                                                  <template v-if="order.discount === null && order.markup === null">
                                                      <td>{{ getServiceDetails(room_service.service_id, 'price') }} Р/м<sup>2</sup></td>
                                                      <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price')) }} Р</td>
                                                  </template>

                                                </div>
                                              </draggable>
                                          </tr>
                                      </template>
                                  </template>

                              </tbody>
                            </table>

                          </div>
                        </div>

                      </div>

                    </div>
                </template>
            </template>

            <div style="margin-bottom: 10em;"></div>

          </div>
        </div>

        <div class="fixed-footer d-flex align-items-center col-10">
          <div class="col-12 d-flex align-items-center justify-content-end">
            <div class="col-md-2">
                <template v-if="order_steps">
                    <select class="w-100 form-control">
                      <option v-for="(order_step, index) in order_steps" :value="order_step.id">
                          <template v-if="order_step.description">
                              {{ order_step.description }} {{ index + parseInt(1) }}
                          </template>
                          <template v-else>
                              {{ order_step.name }} {{ index + parseInt(1) }}
                          </template>
                      </option>
                    </select>
                </template>
            </div>
            <div class="col-md-2">
              <button type="button" class="primary-button w-100">Добавить</button>
            </div>
          </div>
        </div>


      </div>
    </section>
  </div>
</template>

<script>
  import draggable from "vuedraggable"
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
          order_steps: [],
          show_input: false,
          newSteps: [],

        ListStages: [],
        future_index: "START",
        list4: [{
            name: "Name 1",
            per: "28м2",
            price: "100 Р/М2",
            summ: "2800 Р",
            service_type_id: "2"
          },
          {
            name: "Name 2",
            per: "28м2",
            price: "100 Р/М2",
            summ: "2800 Р",
            service_type_id: "2"
          },
        ],
        list3: [{
            name: "Name 3",
            per: "28м2",
            price: "100 Р/М2",
            summ: "2800 Р",
            service_type_id: "3"
          },

          {
            name: "Name 4",
            per: "28м2",
            price: "100 Р/М2",
            summ: "2800 Р",
            service_type_id: "3"
          },
        ],
        list2: [{
            name: "Name 5",
            per: "28м2",
            price: "100 Р/М2",
            summ: "2800 Р",
            service_type_id: "1"
          },

          {
            name: "Name 6",
            per: "28м2",
            price: "100 Р/М2",
            summ: "2800 Р",
            service_type_id: "1"
          },
        ],
            list1: [{
            name: "Name 7",
            per: "28м2",
            price: "100 Р/М2",
            summ: "2800 Р",
            service_type_id: "7",
            },
        ]
      };
    },

    components: {
      draggable,
      Datepicker
    },

    mounted () {
        this.getOrder()
    },

    methods: {
        getOrder () {
            return axios.get(`/api/orders/${this.$route.params.id}/order_steps`)
                        .then(response => {
                            this.order = response.data
                            this.order_steps = this.order.order_steps

                            // this.order.rooms.forEach(room => {
                            //     console.log(room);
                            // })
                        })
        },



      onMove: function(event, oEvent) {
        this.future_index += ", " + event.draggedContext.futureIndex;
      },

      addSteps() {
        this.ListStages.push({
            'name': 'Спринт',
            'description': null,
            'begin_at': null,
            'finish_at': null
        })
      },
      removeStage(i) {
        // console.log(i);
        // console.log(this.ListStages.indexOf(i));
        // let index = this.ListStages.indexOf(i)
        // this.ListStages.splice(index, 1)
        // Vue.delete(this.ListStages, i);
      },
    }
  };
</script>

<style lang="scss" scoped>
    $white: #fff;
    $main-color: #00A4D1;
    $ccc: #CCCCCC;
    $button-hover:#03B8E9;
    $text-color: #777777;
  .fixed {
    &-part {
      position: fixed;
      background-color: $white;
      padding-bottom: 35px;
      padding-top: 85px;
      z-index: 999;
    }
    &-footer {
      position: fixed;
      left: 16.7%;
      right: 0;
      bottom: 0;
      height: 60px;
      background-color: #fff;
      border-top: 1px solid $main-color;
    }
  }

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
    label {
      cursor: pointer;
      display: inline;
      vertical-align: top;
      position: relative;
      padding-left: 5px;
      &::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 3px;
        left: 0px;
        margin-left: -1.25rem;
        border-radius: 0;
        background-color: #fff;
        transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
      }
    }
  }

  .stages {
    margin-top: 245px;
    &__summ {
      font-size: 14px;
      color: #666;
      font-weight: 700;
      span {
        margin-left: 10px;
        font-size: 35px;
        color: #000;
      }
    }
    // &-border {
    //   border: 3px solid #fbf547;
    //   .item {
    //     background-color: #fcffe2;
    //   }
    //   &:first-of-type {
    //     border: 3px solid #55fb3b;
    //       .item {
    //           background-color: #e6ffe2;
    //         }
    //   }
    // }
  }

  table {
    color: $text-color;
    tr {
      cursor: pointer;
    }
    th {
      font-weight: normal;
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
  }


  .table {
    &-subtitle {
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
      border-top: 0;
    }
  }

  .main-subtitle {
    margin-bottom: 0;
  }

</style>
