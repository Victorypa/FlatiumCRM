<template>
    <section class="timetable">
        <basic-header></basic-header>
        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 estimates__content px-0">
                    <div class="container-fluid px-0">
                        <div class="create__fixed-top col-10 shadow bg-white rounded px-15 align-items-center">
                            <div class="row align-items-center ">

                                <div class="col-md-8">
                                    <h2 class="main-caption">
                                        <template v-if="order.order_name">
                                            {{ order.order_name.substring(0, 30) }}
                                        </template>
                                    </h2>
                                </div>

                                <div class="col-md-4 d-flex justify-content-end text-center pr-0">
                                    <router-link  class="primary-button col-6 d-inline-block" :to="{ name: 'room-graphic-show', params: { id: this.$route.params.id, room_id: this.$route.params.room_id } }">
                                        Смотреть график
                                    </router-link>
                                </div>

                            </div>
                        </div>

                        <div class="row align-items-center px-15 pt-4">
                            <div class="col-10 owl-carousel-wrapper">

                                <div class="carousel-item active">
                                        <carousel class="px-15" :perPage="5" :navigationEnabled="true" :pagination-enabled="false">
                                            <slide v-for="room in rooms" :key="room.id">
                                                <router-link @click.native="getRoomWorks()" :to="{ name: 'room-graphic', params: { id: order.id, room_id: room.id } }"
                                                             class="create__features">
                                                    <div class="create__features__name"
                                                            :class="{ 'active': path === '/orders/' + order.id + '/rooms/' + room.id + '/graphic' }">
                                                        {{ room.room_type.type }}
                                                    </div>
                                                </router-link>
                                            </slide>
                                        </carousel>
                                </div>

                            </div>


                            <form @submit.prevent="updateRoomWorks()" class="row col-5 py-30">

                                <div class="main-subtitle col-12 pt-3  mb-4">
                                  <div class="bb pb-3">
                                      План
                                  </div>
                                </div>

                                <div class="main-subtitle col-12 form-group" v-for="work in works" :key="work.id">
                                    <p>{{ work.name }}</p>

                                    <div class="row">
                                        <div class="col-6 px-0">
                                            <datepicker v-model="begin_ats[work.id]" :language="ru"></datepicker>
                                        </div>

                                        <div class="col-6 px-0 pl-2">
                                            <datepicker v-model="finish_ats[work.id]" :language="ru"></datepicker>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="primary-button col-3 ml-3">Сохранить</button>
                            </form>


                            <form @submit.prevent="updateRoomWorksInFact()" class="row col-5 py-30">

                                <div class="main-subtitle col-12 pt-3  mb-4">
                                  <div class="bb pb-3">
                                      Факт
                                  </div>
                                </div>

                                <div class="main-subtitle col-12 form-group" v-for="work in works" :key="work.id">
                                    <p>{{ work.name }}</p>

                                    <div class="row">
                                        <div class="col-6 px-0">
                                            <datepicker v-model="begin_ats_in_fact[work.id]" :language="ru"></datepicker>
                                        </div>

                                        <div class="col-6 px-0 pl-2">
                                            <datepicker v-model="finish_ats_in_fact[work.id]" :language="ru"></datepicker>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="primary-button col-3 ml-3">Сохранить</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>


    </section>
</template>


<script>
    import { Carousel, Slide } from 'vue-carousel'
    import Datepicker from 'vuejs-datepicker';
    import { ru } from 'vuejs-datepicker/dist/locale'

    export default {
        data () {
            return {
                begin_ats: [],
                finish_ats: [],
                begin_ats_in_fact: [],
                finish_ats_in_fact: [],

                dates: [],
                works: [],
                order: [],
                rooms: [],
                path: this.$router.history.current.path,
                room_id: null,

                ru: ru
            }
        },

        components: {
            Datepicker
        },

        mounted () {
            this.getRoomWorks()
        },

        methods: {
            getRoomWorks () {
                return axios.get(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/works`)
                            .then(response => {
                                this.works = response.data.works

                                this.begin_ats = response.data.begin_ats
                                this.finish_ats = response.data.finish_ats
                                this.begin_ats_in_fact = response.data.begin_ats_in_fact
                                this.finish_ats_in_fact = response.data.finish_ats_in_fact
                                this.order = response.data.order
                                this.rooms = this.order.rooms
                                this.path = this.$router.history.current.path
                            })
            },

            updateRoomWorks () {
                axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/works/update`, {
                    'begin_ats': this.begin_ats,
                    'finish_ats': this.finish_ats
                }).then(response => {
                    window.location.reload(true)
                })
            },

            updateRoomWorksInFact () {
                axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/works/update`, {
                    'begin_ats_in_fact': this.begin_ats_in_fact,
                    'finish_ats_in_fact': this.finish_ats_in_fact
                }).then(response => {
                    window.location.reload(true)
                })
            }
        }
    }
</script>

<style scoped lang="scss">

    hotel-date-picker:focus {
        border: none;
    }

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
        color: #fff;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #00A4D1;
        border-radius: .25rem;
        border: none;
        color: #fff;
        cursor: pointer;
    }

    .hidden-button {
        display: none;
    }

    .bb {
        border-bottom: 1px solid #ccc;
        font-size: 1.4rem;
    }
</style>
