<template>
    <section class="create">

        <basic-header></basic-header>

        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 estimates__content px-0">

                    <div class="container-fluid px-0">

                        <order-detail :order="order"
                                      @order-saved="show = true"
                                      >
                        </order-detail>

                        <template v-if="show">
                            <div class="container-fluid create__carousel-wrapper px-0">
                                <div class="row align-items-center py-30 shadow-light px-15">
                                    <div class="col-6 pr-2">
                                        <select class="form-control"
                                                name="room_type_id"
                                                v-model="room_type_id"
                                                @change="paramSave()"
                                                >
                                            <option v-for="room_type in room_types"
                                                    name="room_type_id"
                                                    :value="room_type.id"
                                                    >
                                                    {{ room_type.type }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-6 d-flex align-items-center px-0" v-if="room_type_id === 1">
                                        <div class="placeholder-text col-4 pl-2" placeholder="Шир">
                                            <input type="number"
                                                   v-model="width"
                                                   min="0"
                                                   autofocus
                                                   @change="paramSave()" />
                                        </div>

                                        <div class="placeholder-text col-4 pl-2" placeholder="Дли">
                                            <input type="number"
                                                   v-model="length"
                                                   min="0"
                                                   @change="paramSave()" />
                                        </div>

                                        <div class="placeholder-text col-4 pl-2" placeholder="Выс">
                                            <input type="number"
                                                   v-model="height"
                                                   min="0"
                                                   @change="paramSave()" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </template>

                    </div>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
    import { Carousel, Slide } from 'vue-carousel'
    import OrderDetail from './Partials/OrderDetail'

    export default {
        data () {
            return {
                order: [],
                room_types: [],
                show: false,

                room_type_id: 1,
                width: null,
                length: null,
                height: null
            }
        },


        components: {
            OrderDetail
        },

        created () {
            this.getOrder()
            this.getRoomTypes()
        },

        methods: {
            getOrder () {
                return axios.get(`/api/orders/${this.$route.params.id}`)
                            .then(response => {
                                this.order = response.data
                                this.address = this.order.address

                                if (this.address !== null) {
                                    this.show = true
                                }
                            })
            },

            getRoomTypes () {
                if (localStorage.getItem('room_types')) {
                    this.room_types = JSON.parse(localStorage.getItem('room_types'))
                } else {
                    return axios.get(`/api/room_types`).then(response => {
                        localStorage.setItem('room_types', JSON.stringify(response.data))
                        this.room_types = response.data
                    })
                }
            },


            paramSave () {
                    if (this.width != null && this.height != null && this.length != null) {
                        axios.post('/api/orders/' + this.order.id + '/rooms/create', {
                            'room_type_id': this.room_type_id,
                            'width': this.width,
                            'length': this.length,
                            'height': this.height
                        }).then((response) => {
                            this.$router.push({ name: 'room-show', params: { id: this.order.id, room_id: response.data.id } })
                        })
                    }

                    if (this.room_type_id != 1) {
                        axios.post('/api/orders/' + this.order.id + '/rooms/create', {
                            'room_type_id': this.room_type_id
                        }).then(response => {
                            this.$router.push({ name: 'room-show', params: { id: this.order.id, room_id: response.data.id } })
                        })
                    }
            }
        }
    }
</script>

<style scoped lang="scss">
    .placeholder-text {
      &::after {
        left: 20px;
      }
    }
</style>
