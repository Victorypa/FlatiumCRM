<template>
    <section class="create">

        <basic-header></basic-header>

        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 estimates__content px-0">

                    <div class="container-fluid px-0">

                            <template v-if="order.length != 0 && room.length != 0">
                                <order-detail :order="order" :room="room"></order-detail>
                            </template>

                            <div class="container-fluid create__carousel-wrapper px-0 pl-3">

                                <div class="row align-items-center px-15 pr-0">
                                    <div class="col-8 owl-carousel-wrapper pl-2">

                                        <div class="carousel-item active">

                                            <template v-if="room_types.length">
                                                <carousel class="my-carousel carousel-arrows"
                                                          :perPage="5" :navigationEnabled="true"
                                                          :pagination-enabled="false"
                                                          navigationPrevLabel="<i class='fa fa-angle-left'></i>"
                                                          navigationNextLabel="<i class='fa fa-angle-right'></i>"
                                                          >
                                                            <slide v-for="(room, index) in rooms" :key="room.id" >
                                                                <router-link @click.native="getRoom()"
                                                                             :to="{ name: 'room-show', params: { id: order.id, room_id: room.id } }"
                                                                             class="create__features justify-content-center"
                                                                             >
                                                                    <div class="create__features__name col-auto px-0 mx-2"
                                                                            :class="{ 'active': path === '/orders/' + order.id + '/rooms/' + room.id }"
                                                                            >
                                                                            {{ room_types[room.room_type_id] }} {{ parseInt(index) + 1 }}
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


                                <div class="row align-items-center py-5 bg-white rounded px-15">
                                    <div class="col-4 pl-0">
                                        <select class="form-control match-content">
                                            <option>
                                                {{ room_type }}
                                            </option>
                                        </select>
                                    </div>

                                    <template v-if="room_type_id === 1">
                                        <div class="col-8 d-flex align-items-center justify-content-between px-0">

                                            <div class="placeholder-text ml-2" placeholder="Шир">
                                                <input type="number"
                                                       min="0"
                                                       v-model="width"
                                                       @change="updateRoom()"
                                                    />
                                            </div>

                                            <div class="placeholder-text ml-2" placeholder="Дли">
                                                <input type="number"
                                                       min="0"
                                                       v-model="length"
                                                       @change="updateRoom()"
                                                    />
                                            </div>

                                            <div class="placeholder-text ml-2" placeholder="Выс">
                                                <input type="number"
                                                       min="0"
                                                       v-model="height"
                                                       @change="updateRoom()"
                                                    />
                                            </div>

                                            <div class="placeholder-text ml-2" placeholder="S">
                                                <input type="number"
                                                       min="0"
                                                       v-model="area"
                                                       @change="updateRoom()"
                                                    />
                                            </div>

                                            <div class="placeholder-text ml-2" placeholder="Сте">
                                                <input type="number"
                                                       min="0"
                                                       v-model="wall_area"
                                                       @change="updateRoom()"
                                                    />
                                            </div>

                                            <div class="placeholder-text ml-2" placeholder="Пер">
                                                <input type="number"
                                                       min="0"
                                                       v-model="perimeter"
                                                       @change="updateRoom()"
                                                     />
                                            </div>
                                        </div>

                                    </template>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 px-5 bg pt-5">

                                    <div class="row align-items-center justify-content-between">

                                        <template v-if="room_type_id != 4">
                                            <div class="col-6">
                                                <template v-if="room_price">
                                                    <div class="create__sum" style="font-size: 16px;">
                                                        ИТОГО В ТЕКУЩЕЙ ВКЛАДКЕ: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(room_price)) }} P
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="create__sum" style="font-size: 16px;">
                                                        ИТОГО В ТЕКУЩЕЙ ВКЛАДКЕ: 0 Р
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        <template v-else>
                                            &nbsp;
                                        </template>

                                    </div>

                                    <template v-if="room.windows && room_type_id === 1">
                                        <room-window :room.sync="room" :key="'room-window-' + room.id"></room-window>
                                    </template>
                                </div>
                            </div>

                            <template v-if="room.room_type_id">
                                <services :room="room" :order="order" :key="'room' + room.id" @price="getPrice"></services>
                            </template>


                        </div>
                    </div>
                </div>
            </div>
        </section>

</template>

<script>
    import Services from './Services/Services'
    import RoomWindow from './Windows/RoomWindow'
    import { Carousel, Slide } from 'vue-carousel'
    import OrderDetail from './../Partials/OrderDetail'

    export default {
        components: {
            OrderDetail,
            Services,
            RoomWindow
        },

        data () {
            return {
                room: [],
                room_id: null,
                order: [],
                room_type: null,
                address: null,
                room_types: [],
                rooms: [],
                room_type_id: null,
                room_price: 0,

                width: null,
                length: null,
                height: null,
                area: null,
                wall_area: null,
                room_type_id: null,
                errors: [],
                room_type: null,

                perimeter: null,

                order_price: 0,
                room_price: 0,

                room_windows: [],
                room_window_area: 0,


                units: [],

                path: this.$router.history.current.path
            }
        },

        mounted () {
            this.getRoomTypes()
            this.getRoom()
            this.getUnits()
        },

        methods: {
            getRoom () {
                return axios.get(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}`)
                            .then(response => {
                                this.room = response.data
                                this.room_price = this.room.price
                                this.order = this.room.order
                                this.order_price = this.order.price

                                this.width = parseFloat(this.room.width).toFixed(2)
                                this.height = parseFloat(this.room.height).toFixed(2)
                                this.length = parseFloat(this.room.length).toFixed(2)
                                this.perimeter = parseFloat(this.room.perimeter).toFixed(2)
                                this.area = parseFloat(this.room.area).toFixed(2)
                                this.wall_area = parseFloat(this.room.wall_area).toFixed(2)

                                this.room_type = this.room.room_type.type

                                this.rooms = this.room.order.rooms
                                this.room_type_id = this.room.room_type_id
                                this.room_windows = this.room.windows
                                this.path = this.$router.history.current.path

                            })
            },

            getUnits () {
                if (localStorage.getItem('units')) {
                    this.units = JSON.parse(localStorage.getItem('units'))
                } else {
                    return axios.get(`/api/units`).then(response => {
                        this.units = response.data
                        localStorage.setItem('units', JSON.stringify(this.units))
                    })
                }
            },

            getRoomTypes () {
                return axios.get(`/api/room_types`).then(response => {
                    response.data.forEach(item => {
                        this.room_types[item.id] = item.type
                    })
                })
            },

             updateRoom () {
                 axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.room.id}/update`, {
                    'width': this.width,
                    'length': this.length,
                    'height': this.height,
                    'area': this.area,
                    'wall_area': this.wall_area,
                    'perimeter': this.perimeter
                }).then(response => {
                    this.getRoom()
                })

            },

            deleteRoom () {
                if (confirm('Удалить?')) {
                    axios.delete(`/api/orders/${this.$route.params.id}/rooms/${this.room.id}/destroy`)
                         .then(response => {
                             if (response.data.id) {
                                 this.$router.push({ name: 'room-show', params: { id: this.$route.params.id, room_id: response.data.id } })
                             } else {
                                 this.$router.push({ name: 'order-show', params: { id: this.$route.params.id } })
                             }
                         })
                } else {
                    window.location.reload(true)
                }

            },

            getPrice (value) {
                this.room_price = 0
                this.room_price = parseInt(value)
                this.getRoom()
            },


        },

        watch: {
            '$route' (to, from) {
                if (to.params.room_id !== from.params.room_id) {
                    this.getRoom()
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    $main-color: #00A4D1;
    $ccc: #CCCCCC;

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
    }

    a:hover {
        text-decoration: none;
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

    .fixed-search {
      &-active {
        position: fixed;
        z-index: 1000;
        top: 145px;
      }


}
</style>
