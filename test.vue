<template>
    <div class="create">
        <basic-header></basic-header>
        <div class="container-fluid px-0">
            <div class="row">
                <navigation></navigation>
                <template v-if="extra_room.room">

                    <div class="col-md-10 estimates__content px-0">

                    <div class="container-fluid">

                        <div class="create__fixed-top col-10 px-0 shadow-light align-items-center pl-3">
                            <div class="row align-items-center pb-3">
                                <template v-if="extra_order_act.description">
                                    <h1 class="ml-0 mb-0 col-5">
                                      {{ extra_order_act.description }}
                                    </h1>
                                </template>
                                <template v-else>
                                    <h1 class="ml-0 mb-0 col-5">
                                      {{ extra_order_act.name }}
                                    </h1>
                                </template>

                              <div class="col-md-5 pt-3">
                                  <template v-if="order.description">
                                      <div class="main-caption px-15">
                                          {{ order.description }}
                                      </div>
                                  </template>
                                  <template v-else>
                                      {{ order.order_name }}
                                  </template>
                              </div>
                            <div class="col-md-2 pl-0">
                                <button type="button" class="primary-button w-100">
                                    Экспорт
                                </button>
                            </div>
                    <div class="col-md-6 pt-2">
                        <h2 class="main-subtitle"> Итого акту: 2 120 000 Р</h2>
                    </div>
                </div>
            </div>

        </div>

                        <div class="container-fluid create__carousel-wrapper px-0">

                    <div class="row align-items-center px-15 pr-0">
                        <div class="col-8 owl-carousel-wrapper pl-2">

                            <div class="carousel-item active">

                                <template v-if="extra_order_act.extra_rooms">
                                    <carousel class="my-carousel carousel-arrows"
                                              :perPage="5" :navigationEnabled="true"
                                              :pagination-enabled="false"
                                              navigationPrevLabel="<i class='fa fa-angle-left'></i>"
                                              navigationNextLabel="<i class='fa fa-angle-right'></i>"
                                              >
                                                <slide v-for="(room, index) in extra_order_act.extra_rooms" :key="room.id">
                                                    <router-link @click.native="getExtraRoom()"
                                                                 :to="{ name: 'order-extra-services-rooms-show', params: { id: order.id, extra_order_act_id: extra_order_act.id, extra_room_id: room.id } }"
                                                                 class="create__features justify-content-center"
                                                                 >
                                                        <div class="create__features__name col-auto px-0 mx-2"
                                                             :class="{ 'active': path === '/orders/' + order.id + '/order_extra_services/' + extra_order_act.id + '/extra_rooms/' + room.id }"
                                                            >
                                                            {{ room.room.room_type.type }} {{ parseInt(index) + 1 }}
                                                        </div>
                                                    </router-link>
                                                </slide>
                                    </carousel>
                                </template>

                            </div>

                        </div>

                        <button class="col-auto add-button">
                            <div class="create__features">
                                <router-link :to="{ name: 'order-show', params: { id: order.id } }"
                                             class="col-1 add-button">
                                             <img src="/img/plus-circle.svg" alt="add-button">
                                </router-link>

                            </div>
                        </button>

                        <div class="col-2 text-right ml-auto pl-0">
                            <button type="button" @click="deleteRoom()" class="primary-button primary-button--outline w-100" >Удалить</button>
                        </div>
                    </div>

                        <div class="row align-items-center py-5 shadow-light px-15 mb-2">
                            <div class="col-6">
                                <select class="form-control match-content">
                                    <option>
                                        {{ extra_room.room.room_type.type }}
                                    </option>
                                </select>
                            </div>

                            <template v-if="extra_room.room.room_type_id === 1">
                                <div class="col-6 d-flex align-items-center justify-content-between px-0">

                                    <div class="placeholder-text ml-2" placeholder="Шир">
                                        <input type="number" disabled :value="extra_room.width" />
                                    </div>
                                    <div class="placeholder-text ml-2" placeholder="Дли">
                                        <input type="number" disabled :value="extra_room.length" />
                                    </div>
                                    <div class="placeholder-text ml-2" placeholder="Выс">
                                        <input type="number" disabled :value="extra_room.height" />
                                    </div>

                                    <div class="placeholder-text ml-2" placeholder="S">
                                        <input type="number" disabled :value="extra_room.area" />
                                    </div>

                                    <div class="placeholder-text ml-2" placeholder="Сте">
                                        <input type="number" disabled :value="extra_room.room.wall_area - windowArea" />
                                    </div>

                                    <div class="placeholder-text ml-2" placeholder="Пер">
                                        <input type="number" disabled :value="extra_room.room.perimeter" />
                                    </div>
                                </div>

                            </template>
                        </div>
                </div>


                        <div class="row">
                            <div class="col-md-12 px-5 pt-5 bg">

                                <div class="row align-items-center justify-content-between">
                                        <template v-if="extra_room.room.room_type_id != 4">
                                            <div class="col-6">
                                                <template v-if="extra_room.room.price">
                                                    <div class="create__sum" style="font-size: 16px;">
                                                        ИТОГО В ТЕКУЩЕЙ ВКЛАДКЕ: {{ new Intl.NumberFormat().format(parseInt(extra_room.room.price)) }} P
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="create__sum" style="font-size: 16px;">
                                                        ИТОГО В ТЕКУЩЕЙ ВКЛАДКЕ: 0 Р
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                </div>

                        <div class="container-fluid px-0">

                            <div class="row">
                                <div class="col-md-12 pt-4 pr-0">
                                        <template v-if="extra_room.extra_windows.length">
                                            <div class="row col-12 justify-content-between add-space-block align-items-center" v-for="(window, index) in extra_room.extra_windows" :key="window.id">

                                              <div class="col-3 px-0">
                                                  <button class="add-space-button pl-4 active">{{ index + parseInt(1) }}</button>
                                              </div>

                                              <div class="col-md-9">
                                                <div class="row col-12 form-group--margin d-flex align-items-center create-spaces">

                                                    <div class="form-group col-md-3">
                                                        <select class="form-control"
                                                                name="type"
                                                                >
                                                                <option name="type" :value="window.type">
                                                                    <template v-if="window.type === 'window'">
                                                                        Окно
                                                                    </template>

                                                                    <template v-else>
                                                                        Дверь
                                                                    </template>
                                                                </option>
                                                        </select>
                                                    </div>


                                                  <div class="form-group col-md-2">
                                                      <input type="number"
                                                             min="0"
                                                             class="form-control"
                                                             v-model="window.length"
                                                             @change="updateExtraWindow(window)"
                                                             required
                                                             >
                                                  </div>

                                                  <div class="form-group col-md-2">
                                                      <input type="number"
                                                             min="0"
                                                             class="form-control"
                                                             v-model="window.width"
                                                             @change="updateExtraWindow(window)"
                                                             required
                                                             >
                                                  </div>


                                                  <span>x</span>

                                                  <div class="form-group col-md-2">
                                                      <input type="number"
                                                             min="0"
                                                             class="form-control"
                                                             v-model="window.quantity"
                                                             @change="updateExtraWindow(window)"
                                                             required
                                                             >
                                                  </div>

                                                  <div class="form-group col-md-2">
                                                      <div class="form-group__calc form-group__parametres">
                                                          {{ parseFloat(window.length * window.width * window.quantity).toFixed(2) }} M<sup>2</sup>
                                                      </div>
                                                  </div>

                                                  <button @click="deleteExtraWindow(window)" class="add-button add-button--remove d-flex align-items-center ml-auto">
                                                      <img src="/img/del.svg" alt="add-button">
                                                  </button>

                                                </div>
                                            </div>
                                            </div>
                                        </template>


                                        <form  @submit.prevent="save()">
                                            <div class="row col-12 justify-content-between add-space-block align-items-center" v-for="(window, index) in newExtraWindows">

                                              <div class="col-3 px-0">
                                                <button class="add-space-button pl-4 active">Проем {{ index + parseInt(1) }}</button>
                                              </div>

                                              <div class="col-md-9 pr-0">
                                                <div class="row col-12 pr-0 form-group--margin d-flex align-items-center create-spaces">

                                                    <div class="form-group col-md-3">
                                                        <select class="form-control"
                                                                name="type"
                                                                v-model="window.type"
                                                                value="window"
                                                                >
                                                            <option name="type" value="window">
                                                                Окно
                                                            </option>

                                                            <option name="type" value="door">
                                                                Дверь
                                                            </option>
                                                        </select>
                                                    </div>


                                                    <div class="form-group w-85 pr-3">
                                                        <input type="text"
                                                               class="form-control"
                                                               placeholder="Ширина"
                                                               v-model="window.length"
                                                               required
                                                               >
                                                    </div>

                                                    <div class="form-group w-85 pr-3">
                                                        <input type="text"
                                                               class="form-control"
                                                               placeholder="Длина"
                                                               v-model="window.width"
                                                               required
                                                              >
                                                    </div>

                                                  <span class="">x</span>

                                                  <div class="form-group w-85 pl-3">
                                                      <input type="text"
                                                             class="form-control"
                                                             placeholder="Кол-во"
                                                             v-model="window.quantity"
                                                             required
                                                             >
                                                  </div>

                                                  <div class="form-group col-md-2">
                                                      <div class="form-group__calc ">
                                                          {{ window.length * window.width * window.quantity }} M<sup>2</sup>
                                                      </div>
                                                  </div>

                                                </div>
                                              </div>
                                            </div>

                                        </form>

                                        <div class="row col-12">
                                          <button class="add-space-button py-2" @click="addExtraWindow">+ Добавить проем </button>
                                        </div>
                                        <hr>
                                </div>
                            </div>
                        </div>


                        <div class="row align-items-center col-12 py-4 fixed-search">
                            <div class="col-2 pb-2">
                                    <select class="form-control" v-model="service_type_id">
                                          <option v-for="service_type in service_types" :value="service_type.id">
                                              {{ service_type.name }}
                                          </option>
                                    </select>
                            </div>
                            <div class="col-10 d-flex align-items-center pl-0 pb-2">
                                <div class="form-group col-12">
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Название вида работы"
                                           v-model="searchQuery"
                                           autofocus
                                           >
                                </div>
                            </div>


                                <form class="w-100" @submit.prevent="saveNewServices()">

                                    <div class="row" v-for="(newService, index) in newServices">
                                        <div class="col-2 py-1">
                                            <select class="form-control" v-model="newService.service_type_id">
                                                  <option v-for="service_type in service_types" :value="service_type.id">
                                                      {{ service_type.name }}
                                                  </option>
                                            </select>
                                        </div>

                                        <div class="col-5 py-1">
                                            <div class="form-group">
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="Название"
                                                       v-model="newService.name"
                                                       >
                                            </div>
                                        </div>

                                             <div class="d-flex align-items-center">
                                            <select class="form-control w-85" v-model="newService.unit_id">
                                                  <option v-for="unit in units" :value="unit.id">
                                                      {{ unit.name }}
                                                  </option>
                                            </select>
                                                <div class="form-group w-85 ml-4">
                                                <input type="number"
                                                min="0"
                                                class="form-control"
                                                placeholder="Цена за ед. изм."
                                                v-model="newService.price"
                                                >
                                            </div>

                                            <div class="py-1 pl-3">
                                                <div class="form-check custom-control checkbox">
                                                    <input type="checkbox"
                                                           class="form-check-input check"
                                                           :id="'service-' + index"
                                                           v-model="newService.can_be_discounted"
                                                           >
                                                    <label class="form-check-label d-block" :for="'service-' + index">
                                                        Скидка возможна
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" style="display:none;"></button>
                                </form>



                            <div class="col-12 py-3 pl-0">
                                <div class="col-12">
                                    <button class="add-space-button" @click="addNewService()">+ Добавить работу</button>
                                </div>
                            </div>

                            <!-- <template v-if="service_type_id !== 0">
                                <div class="col-12 pr-0" style="margin-bottom: 5em;">
                                  <div class="main-subtitle main-subtitle--fz pt-3 pb-2">
                                      {{ getServiceTypeName(service_type_id) }}
                                  </div>

                                  <div class="col-md-12 px-0 all-items" v-for="service in filteredServices" :key="service.id">

                                    <div class="row align-items-center">

                                      <label class="col-md-4 mb-0">
                                          <div class="form-check custom-control">
                                              <input class="form-check-input"
                                                     type="checkbox"
                                                     :id="'service-' + service.id"
                                                     :checked="room_service_ids.includes(service.id)"
                                                     @click="addToRoomServiceId(service.id)"
                                                     >

                                              <label class="form-check-label"
                                                     :for="'service-' + service.id"
                                                     >
                                                     {{ service.name }}
                                              </label>
                                          </div>
                                      </label>

                                    <div class="col-md-8 pr-0">
                                      <div class="form-group form-group--margin d-flex align-items-center">
                                        <input type="number"
                                               class="form-control w-85"
                                               placeholder="Кол-во"
                                               min="0"
                                               v-model="service_quantities[service.id]"
                                               @change="linkServicesToRoom()"
                                               >

                                        <div class="inputs-caption col-md-2">
                                            {{ service.unit.name }}
                                        </div>

                                        <input type="number"
                                               class="form-control w-85"
                                               min="0"
                                               v-model="service_prices[service.id]"
                                               @change="linkServicesToRoom()"
                                               >

                                        <div class="inputs-caption col-md-2">
                                            Р/{{ service.unit.name }}
                                        </div>

                                        <div class="form-group__calc w-85">
                                            {{ new Intl.NumberFormat().format(getServiceSummary(service.id)) }} P
                                        </div>

                                        <template v-if="service.can_be_deleted">
                                            <div class="col-md-2">
                                                <button @click="deleteService(service.id)" class="add-button add-button--remove d-flex align-items-center" title="Удалить материал">
                                                    <img src="/img/del.svg" alt="add-button">
                                                    <div class="remove-materials ml-1">
                                                      Удалить
                                                    </div>
                                                </button>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="col-md-2">
                                                &nbsp;
                                            </div>
                                        </template>

                                        <template v-if="room_service_ids.includes(service.id)">
                                            <div class="col-md-auto px-0 ml-auto">
                                                <template v-if="room.order">
                                                    <router-link :to="{ name: 'actual-material', params: { id: room.order.id, room_id: room.id, service_id: service.id }}">
                                                        <button class="add-button " title="Добавить материалы">
                                                            <img src="/img/add-materials.svg" alt="add-button">
                                                        </button>
                                                    </router-link>
                                                </template>

                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="col-md-auto px-0">
                                                &nbsp;
                                            </div>
                                        </template>
                                      </div>
                                    </div>


                                    <template v-if="room_service_ids.includes(service.id) && service.actual_materials">
                                            <div class="row col-12" v-for="material in service.actual_materials.filter(row => row.pivot.room_id === room.id)">
                                              <div class="col-4 pl-5 mb-3">
                                                <div class="subtitle-list">
                                                  <div class="subtitle-list__item">
                                                      {{ material.name }}
                                                  </div>
                                                </div>
                                              </div>
                                              <template v-if="material.pivot.rate">
                                                  <div class="col-8">
                                                    <div class="d-flex align-items-center">
                                                      <div class="col-4" style="margin-left:163px"></div>
                                                      <div class="form-group__calc col-md-2">
                                                          {{ getMaterialSummary(material.pivot.rate, material.quantity, material.price) }} Р
                                                      </div>
                                                    </div>
                                                  </div>
                                              </template>
                                            </div>
                                    </template>

                                  </div>
                                  </div>
                                </div>
                            </template> -->

                        </div>



                    </div>
                </div>
            </div>


                </template>
        </div>
      </div>
    </div>
</template>

<script>
  import { Carousel, Slide } from 'vue-carousel'

  export default {
      data () {
          return {
              order: [],
              extra_order_act: [],
              extra_room: [],

              newExtraWindows: [],

              service_types: [],
              service_type_id: 0,
              newServices: [],

              units: [],

              searchQuery: '',


              path: this.$router.history.current.path
          }
      },

      mounted () {
          this.getExtraRoom()
          this.getServiceTypes()
          this.getServiceUnits()
      },

      methods: {
          getExtraRoom () {
              return axios.get(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}`)
                          .then(response => {
                              this.extra_room = response.data
                              this.extra_order_act = response.data.extra_order_act
                              this.order = response.data.extra_order_act.order

                              this.path = this.$router.history.current.path
                          })
          },

          getServices () {
              return axios.get('/api/services').then(response => {
                  this.services = response.data
              })
          },

          saveNewServices () {
              this.newServices.forEach(item => {
                  axios.post(`/api/services/store`, {
                      'service_type_id': item.service_type_id,
                      'name': item.name,
                      'unit_id': item.unit_id,
                      'price': item.price,
                      'can_be_discounted': item.can_be_discounted
                  }).then(response => {
                      this.getServices()
                      this.newServices = []
                  })
              })

          },

          addNewService () {
                  this.newServices.push({
                      unit_id: 1,
                      service_type_id: 1,
                      name: null,
                      price: null,
                      can_be_discounted: false
                  })
          },

          getServiceTypes () {
                  return axios.get(`/api/service_types`).then(response => {
                          switch (parseInt(this.extra_room.room.room_type_id)) {
                              case parseInt(1):
                                  this.service_types = response.data.slice(0, 3)
                                  this.service_type_id = this.service_types[0].id
                                  break;
                              case parseInt(2):
                                  this.service_types = response.data.slice(4, 5)
                                  this.service_type_id = this.service_types[0].id
                                  break;
                              case parseInt(3):
                                  this.service_types = response.data.slice(3, 4)
                                  this.service_type_id = this.service_types[0].id
                                  break;
                              default:
                                  this.service_type_id = 1
                                  this.service_types = response.data
                          }
                  })

          },

          getServiceUnits () {
              if (localStorage.getItem('units')) {
                  this.units = JSON.parse(localStorage.getItem('units'))
              } else {
                  return axios.get(`/api/units`)
                              .then(response => {
                                  this.units = response.data
                                  localStorage.setItem('units', JSON.stringify(this.units))
                              })
              }
          },

          save () {
              this.newExtraWindows.forEach((item, index) => {
                  return axios.post(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_windows/store`, {
                          'type': item.type,
                          'length': item.length,
                          'width': item.width,
                          'quantity': item.quantity
                      }).then(response => {
                          window.location.reload(true)
                      })
              })
          },

          addExtraWindow () {
              this.newExtraWindows.push({
                  type: 'window',
                  length: null,
                  width: null,
                  quantity: null
              })
          },

          updateExtraWindow (currentWindow) {
               axios.patch(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_windows/${currentWindow.id}/update`, {
                  'quantity': currentWindow.quantity,
                  'length': currentWindow.length,
                  'width': currentWindow.width
              }).then(response => {

              })
          },

          deleteExtraWindow (currentWindow) {
                  if (confirm('Удалить ?')) {
                      axios.delete(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_windows/${currentWindow.id}/delete`)
                           .then(response => {
                               window.location.reload(true)
                           })
                  } else {
                      window.location.reload(true)
                  }
          }
      },

      computed: {
          windowArea () {
              let window_area = 0

              this.extra_room.extra_windows.forEach(window => {
                  window_area += parseFloat(window.length) * parseFloat(window.width) * window.quantity
              })

              return parseFloat(window_area).toFixed(2)
          }
      }
  }
</script>

<style lang="scss" scoped>
    $white: #fff;
    $text-color: #777777;
    $ccc: #CCCCCC;
    $main-color: #00A4D1;
    $button-hover:#03B8E9;

    input:required:valid {
        border-color: #495057 !important;
    }

  .fixed-part {
    position: fixed;
    padding-bottom: 35px;
    padding-top: 85px;
    z-index: 999;
  }

  .create {
      &__features {
          display: flex;
          align-items: center;

          &__name {
             font-weight: bold;
             font-size: 20px;
             display: inline-block;
             color: $ccc;
             border: none;
         cursor: pointer;
         &:hover,
         &.active {
             color: $main-color;
             border-bottom: 3px solid $main-color;
             transition-duration: 0.3s;
         }
      }
  }
    .form-check {
      &-input:checked~ {
        label {
          font-weight: bold;
          color: #000;
        }
      }
    }

    .form-control {
    border-radius: 0;
    &::placeholder {
        opacity: 0.3;
    }
    &:focus,
    &:hover {
        box-shadow: none;
        border-color: #000;
    }
}
    .form-group {
      margin-bottom: 0;
      span {
        color: $main-color;
      }
      .form-control {
        margin-left: 10px;
        &:first-of-type {
          margin-left: 0;
        }
      }
      &__calc {
        font-size: 0.75rem;
        color: $main-color;
      }
      &--margin {
        margin-bottom: 10px;
      }
    }
    &-spaces {
      input {
        padding: 10px;
      }
    }
    &__features {
      display: flex;
      align-items: center;
      margin-right: 20px;
      &-name {
        font-weight: bold;
        font-size: 18px;
        color: $ccc;
        border: none;
        cursor: pointer;
        &:hover {
          color: $main-color;
        }
        &.active {
          display: inline-block;
          color: $main-color;
          border-bottom: 3px solid $main-color;
        }
      }
    }
    &__sum {
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .custom-radio {
      font-size: 0.875rem;
      padding-right: 20px;
      color: $text-color;
      .custom-control {
        &-input:checked~.custom-control-label::before {
          background-color: $main-color;
        }
      }
      label {
        display: block;
        font-size: 13px;
        &:hover {
          color: #000;
          cursor: pointer;
        }
      }
      &:last-child {
        padding-right: 0px;
      }
    }
    .create__carousel-wrapper {
      padding-top: 170px;
    }
    .subtitle-list {
      &__item {
        font-size: 0.85rem;
      }
    }
    .owl-carousel {
      .owl-next,
      .owl-prev {
        position: absolute;
        bottom: -30%;
        cursor: pointer;
      }
      .owl-prev {
        left: -1%;
      }
      .owl-next {
        right: -1%;
      }
      .owl-nav {
        button {
          background-color: #fff;
          font-size: 30px;
          &:hover {
            background-color: #fff;
          }
          &:focus {
            outline: none;
          }
        }
        span {
          color: #666;
          &:active {
            background-color: #fff;
          }
          &:hover {
            color: $main-color;
          }
        }
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
        color: #ccc;
        &:hover {
          color: $main-color;
        }
        img {
          width: 15px;
        }
      }
    }
    .sidebar {
      min-height: 100vh;
    }
    .main-caption {
      font-size: 1.4rem;
    }
  }

  a:hover {
      text-decoration: none;
  }

  .w-85 {
      width:85px;
  }
</style>
