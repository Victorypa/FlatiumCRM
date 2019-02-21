<template>
    <div class="create">
        <basic-header></basic-header>
        <div class="container-fluid px-0">
            <div class="row">
                <navigation></navigation>
                <template v-if="extra_room.room">

                <div class="col-md-10 estimates__content px-0">

                    <ExtraOrderDetail :extra_order_act="extra_order_act" />

                    <div class="container-fluid create__carousel-wrapper px-0">

                        <div class="row align-items-center px-15 pr-0">
                            <div class="col-8 owl-carousel-wrapper pl-2">

                                <div class="carousel-item active">
                                    <carousel class="my-carousel carousel-arrows"
                                              v-if="extra_order_act.extra_rooms.length !== 0"
                                              :perPage="5" :navigationEnabled="true"
                                              :pagination-enabled="false"
                                              navigationPrevLabel="<i class='fa fa-angle-left'></i>"
                                              navigationNextLabel="<i class='fa fa-angle-right'></i>"
                                              >
                                                <slide v-for="(extra_room, index) in extra_order_act.extra_rooms" :key="extra_room.id">
                                                    <router-link @click.native="getExtraRoom()"
                                                                 :to="{ name: 'order-extra-services-rooms-show', params: { id: order.id, extra_act_id: extra_order_act.id, extra_room_id: extra_room.id } }"
                                                                 class="create__features justify-content-center"
                                                                 >
                                                        <div class="create__features__name col-auto px-0 mx-2"
                                                             :class="{ 'active': path === '/orders/' + order.id + '/order_extra_services/' + extra_order_act.id + '/extra_rooms/' + extra_room.id }"
                                                            >
                                                            <span>
                                                                {{ extra_room.room.description ? extra_room.room.description.substring(0, 13) : extra_room.room.room_type.type }}
                                                            </span>
                                                        </div>
                                                    </router-link>
                                                </slide>
                                    </carousel>
                                </div>

                            </div>

                        </div>

                            <div class="row align-items-center py-5 shadow-light px-15 mb-2">
                                <div class="col-3">
                                    <select class="form-control match-content">
                                        <option>
                                            {{ extra_room.room.description ? extra_room.room.description : extra_room.room.room_type.type }}
                                        </option>
                                    </select>
                                </div>
                                <template v-if="extra_room.room.room_type_id === 1">
                                    <div class="col-6 d-flex align-items-center justify-content-between px-0">

                                        <div class="placeholder-text ml-2" placeholder="Шир">
                                            <input type="number" disabled :value="extra_room.room.width" />
                                        </div>
                                        <div class="placeholder-text ml-2" placeholder="Дли">
                                            <input type="number" disabled :value="extra_room.room.length" />
                                        </div>
                                        <div class="placeholder-text ml-2" placeholder="Выс">
                                            <input type="number" disabled :value="extra_room.room.height" />
                                        </div>

                                        <div class="placeholder-text ml-2" placeholder="S">
                                            <input type="number" disabled :value="extra_room.room.area" />
                                        </div>

                                        <div class="placeholder-text ml-2" placeholder="Сте">
                                            <input type="number" disabled :value="extra_room.room.wall_area" />
                                        </div>

                                        <div class="placeholder-text ml-2" placeholder="Пер">
                                            <input type="number" disabled :value="extra_room.room.perimeter" />
                                        </div>
                                    </div>

                                </template>
                        </div>
                       </div>


                        <div class="row">
                            <div class="col-md-12 pl-5 pt-5 bg">

                                <div class="row align-items-center justify-content-between">
                                    <div class="col-6" v-if="extra_room.room.room_type_id != 4">
                                        <div class="create__sum" style="font-size: 16px;">
                                            ИТОГО В ТЕКУЩЕЙ ВКЛАДКЕ: {{ extra_room.price ? new Intl.NumberFormat().format(parseInt(extra_room.price)) : 0 }} P
                                        </div>
                                    </div>
                                </div>

                        <div class="container-fluid px-0">

                            <div class="row">
                                <div class="col-md-12 pt-4 pr-0">
                                    <ExtraRoomWindows />

                                    <AddExtraRoomWindow />


                                </div>
                            </div>
                        </div>


                        <!-- <template v-if="extra_room.room && order">
                            <services :extra_room="extra_room" :order="order" :key="'extra-room-' + extra_room.id" @price="getPrice"></services>
                        </template> -->

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
  import ExtraOrderDetail from './partials/ExtraOrderDetail'
  import ExtraRoomWindows from './Windows/ExtraRoomWindows'
  import AddExtraRoomWindow from './Windows/AddExtraRoomWindow'

  export default {
      components: {
          ExtraOrderDetail, ExtraRoomWindows, AddExtraRoomWindow
      },

      data () {
          return {
              order: [],
              extra_order_act: [],
              extra_room: [],

              newExtraWindows: [],
              extra_room_service_materials: [],

              show: false,

              path: this.$router.history.current.path
          }
      },

      mounted () {
          this.getExtraRoom()

      },

      methods: {
          getExtraRoom () {
              return axios.get(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_act_id}/extra_rooms/${this.$route.params.extra_room_id}`)
                          .then(response => {
                              this.extra_room = response.data
                              this.extra_order_act = response.data.extra_order_act
                              this.path = this.$router.history.current.path

                          })
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

          updateExtraOrderAct () {
              axios.patch(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/update`, {
                  'description': this.description
              }).then(response => {
                  this.show = false
              })
          },

          addExtraWindow () {
              this.newExtraWindows.push({
                  type: 'window',
                  length: null,
                  width: null,
                  quantity: null
              })
              console.log(this.newExtraWindows);
          },

          deleteNewExtraWindow(window) {
              this.newExtraWindows.splice(window, 1)
          },

          updateExtraWindow (currentWindow) {
               axios.patch(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_windows/${currentWindow.id}/update`, {
                  'quantity': currentWindow.quantity,
                  'length': currentWindow.length,
                  'width': currentWindow.width
              }).then(response => {
                  window.location.reload(true)
              })
          },

          deleteExtraWindow (currentWindow) {
                  if (confirm('Удалить ?')) {
                      axios.delete(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_windows/${currentWindow.id}/delete`)
                           .then(response => {
                               window.location.reload(true)
                           })
                  }
          },

          getMaterialSummary (rate, quantity, price) {
              return parseFloat(Math.ceil(rate/quantity) * price).toFixed(2)
          },

          getPrice (value) {
              this.extra_room_price = 0
              this.extra_room_price = parseInt(value)
              this.getExtraRoom()
          },
      },

      computed: {
          filteredServices () {
              let data = this.services

              if (this.newServices.length) {
                  this.newServices = []
              }

              data = data.filter(row => {
                  return row.service_type_id === this.service_type_id
              })

              data = data.filter(row => {
                return Object.keys(row).some(key => {
                  return (
                    String(row[key])
                      .toLowerCase()
                      .indexOf(this.searchQuery.toLowerCase()) > -1
                  )
                })
              })

              return data
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
    .carousel-wrapper {
      padding-top: 250px;
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
  }

  a:hover {
      text-decoration: none;
  }
   .w-85 {
      width:85px;
  }

  .main-caption img {
    width: 16px;
    cursor: pointer;
  }
</style>
