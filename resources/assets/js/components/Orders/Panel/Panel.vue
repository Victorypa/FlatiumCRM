<template>
    <section class="create">

        <basic-header></basic-header>

        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 estimates__content px-0 mt-5">

                    <div class="container-fluid px-0 mt-5 ml-5">
                        <div class="row ml-5">
                            <router-link v-if="orderPath" :class="panelClass"
                                         :to="orderPath"
                                         >
                                        <div class="card-body">
                                          <h5 class="card-title">Смета</h5>
                                        </div>
                            </router-link>


                            <router-link v-if="finishedActsPath" :class="panelClass"
                                         :to="finishedActsPath"
                                         >
                                        <div class="card-body">
                                          <h5 class="card-title">
                                              Акты выполненных работ
                                          </h5>
                                        </div>
                            </router-link>

                            <router-link v-if="ExtraActsPath" :class="panelClass"
                                         :to="ExtraActsPath"
                                         >
                                        <div class="card-body">
                                          <h5 class="card-title">
                                              Акты дополнительных работ
                                          </h5>
                                        </div>
                            </router-link>

                            <router-link v-if="financePath" :class="panelClass"
                                         :to="financePath"
                                         >
                                        <div class="card-body">
                                          <h5 class="card-title">Баланс</h5>
                                        </div>
                            </router-link>

                            <router-link v-if="orderGraphicPath" :class="panelClass"
                                         :to="orderGraphicPath"
                                         >
                                        <div class="card-body">
                                          <h5 class="card-title">График работ</h5>
                                        </div>
                            </router-link>

                            <router-link v-if="uploadPath" :class="panelClass"
                                         :to="uploadPath"
                                         >
                                        <div class="card-body">
                                          <h5 class="card-title">Загрузить файлы</h5>
                                        </div>
                            </router-link>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
    export default {
        data () {
            return {
                order: []
            }
        },

        created () {
            this.getOrder()
        },

        methods: {
            getOrder () {
                return axios.get(`/api/orders/${this.$route.params.id}`)
                            .then(response => {
                                this.order = response.data
                            })
            },
        },

        computed: {
            panelClass () {
                return 'card col-3 mt-5 ml-5 clickable'
            },

            getFirstRoomId () {
                return this.order.rooms.length != 0 ? this.order.rooms[this.order.rooms.length - 1].id : null
            },

            orderPath () {
                if (this.order.length !== 0) {
                    let data = this.order
                    if (this.order.rooms.length !== 0) {
                        return {
                            name: 'room-show',
                            params: { id: this.$route.params.id, room_id: this.getFirstRoomId }
                        }
                    } else {
                        return {
                            name: 'order-show',
                            params: { id: this.$route.params.id }
                        }
                    }
                }
            },

            orderGraphicPath () {
                return {
                    name: 'order-steps',
                    params: { id: this.$route.params.id }
                }
            },

            financePath () {
                return {
                    name: 'order-finance',
                    params: { id: this.$route.params.id }
                }
            },

            uploadPath () {
                return {
                    name: 'order-upload',
                    params: { id: this.$route.params.id }
                }
            },

            finishedActsPath () {
                return {
                    name: 'order-finished-acts',
                    params: { id: this.$route.params.id }
                }
            },

            ExtraActsPath () {
                return {
                    name: 'order-extra-acts',
                    params: { id: this.$route.params.id }
                }
            }
        }
    }
</script>

<style scoped>
    .clickable {
        height: 6em;
        cursor: pointer;
    }
</style>
