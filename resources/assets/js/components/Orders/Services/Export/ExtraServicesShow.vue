<template>
    <section class="projects">

        <basic-header></basic-header>

        <template>
            <div class="container-fluid ">
                <div class="row">
                    <navigation></navigation>

                    <div class="col-md-10">

                        <div class=" row col-10 main-caption-wrapper shadow-light px-15 align-items-center">
                            <div class="col-md-8">
                                <h1 class="main-caption">
                                    <template v-if="extra_order.order">
                                        {{ extra_order.name }}
                                    </template>
                                </h1>
                            </div>

                            <div class="col-md-2">
                            </div>

                            <div class="col-md-2">
                                <template v-if="extra_order.extra_rooms">
                                    <router-link :to="{ name: 'order-extra-services-rooms-show', params: { id: extra_order.order.id, extra_order_act_id: extra_order.id, extra_room_id: extra_order.extra_rooms[0].id } }" >
                                        <button type="button" class="primary-button w-100">
                                            Редактировать
                                        </button>
                                    </router-link>
                                </template>
                            </div>

                            <template v-if="extra_order.order">
                                <div class="col-md-12 px-0 pt-4">
                                    <h2 class="main-subtitle px-15">
                                        <template v-if="square">
                                            <span>Общая S:</span> {{ parseFloat(square).toFixed(2) }} м<sup>2</sup>
                                        </template>


                                        <template v-if="extra_order.order.discount">
                                            <span>Итого:</span> {{ new Intl.NumberFormat('ru-Ru').format(extra_order.order.price) }} Р
                                            <span class="small-case">{{ new Intl.NumberFormat('ru-Ru').format(extra_order.order.original_price) }} Р</span>
                                            <span class="small-case">(скидка: -{{ extra_order.order.discount }}%)</span>
                                        </template>

                                        <template v-else-if="extra_order.order.markup">
                                            <span>Итого:</span> {{ new Intl.NumberFormat('ru-Ru').format(extra_order.order.price) }} Р
                                            <span class="small-case">{{ new Intl.NumberFormat('ru-Ru').format(extra_order.order.original_price) }} Р</span>
                                            <span class="small-case">(наценка: +{{ extra_order.order.markup }}%)</span>
                                        </template>

                                        <template v-else>
                                            <span>Итого:</span> {{ new Intl.NumberFormat('ru-Ru').format(extra_order.order.price) }} Р
                                        </template>
                                    </h2>
                                </div>
                            </template>


                        </div>

                            <div class="col-12 px-0">

                                <div class="projects__content px-15">

                                    <div class="row align-items-center pt-5">
                                        <div class="col-10">
                                            <div class="form-group d-flex align-items-center">

                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="Имя клиента"
                                                       v-model="client_name"
                                                       @change="orderUpdate()"
                                                       >

                                                <div class="col-3">
                                                    <select class="form-control"
                                                            style="height: 46px;"
                                                            v-model="manager_id"
                                                            @change="orderUpdate()"
                                                            >
                                                        <option v-for="manager in managers"
                                                                :value="manager.id"
                                                                >
                                                            {{ manager.name }}
                                                        </option>
                                                    </select>
                                                </div>

                                                    <input type="text"
                                                           class="form-control"
                                                           placeholder="Телефон менеджера"
                                                           v-model="manager_phones[manager_id]"
                                                           disabled
                                                           >


                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="№ Договора"
                                                       v-model="contract"
                                                       @change="orderUpdate()"
                                                       >

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" @click.prevent="exportFile()" class="primary-button w-100">
                                                Экспорт
                                            </button>
                                        </div>
                                    </div>


                                    <div class="col-12 px-0 pt-3">
                                      <div class="form-check custom-control checkbox">
                                        <input class="form-check-input check"
                                               id="exportmaterials"
                                               type="checkbox"
                                               v-model="withMaterials"
                                               >

                                        <label class="form-check-label" for="exportmaterials">
                                          Экспортировать с материалами
                                        </label>
                                      </div>
                                    </div>
                                </div>


                                <template v-if="extra_order.extra_rooms">
                                    <template v-for="(extra_room, index) in extra_order.extra_rooms">
                                        <div class="projects__information">
                                            <div class="px-15 pb-3">
                                                <template v-if="extra_room.room.description">
                                                    <h2 class="main-subtitle main-subtitle--room">
                                                        {{ extra_room.room.description }}
                                                    </h2>
                                                </template>
                                                <template v-else>
                                                    <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName()">
                                                        {{ extra_room.room.room_type.type }}
                                                    </h2>
                                                </template>


                                                <template v-if="extra_room.room.room_type_id === 1">
                                                    <div class="projects__desc col-8 d-flex justify-content-between px-0 align-items-center pt-3">
                                                        <div class="projects__desc-item">Общая площадь: {{ extra_room.area }} м<sup>2</sup></div>
                                                        <div class="projects__desc-item">Высота потолка: {{ extra_room.height }} м</div>
                                                        <div class="projects__desc-item">Площадь стен: {{ extra_room.wall_area }} м<sup>2</sup></div>
                                                        <div class="projects__desc-item">Периметр: {{ extra_room.perimeter }}</div>
                                                    </div>
                                                </template>

                                            </div>

                                            <template v-for="(extra_room_services, service_type_id) in groupByServiceType(extra_room.extra_room_services)">
                                                <div class="row bg px-15">

                                                    <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                        {{ getServiceTypeName(service_type_id) }}
                                                    </div>

                                                    <div class="col-12 px-0">
                                                        <table class="table table-hover">
                                                            <tbody>
                                                                <tr v-for="extra_room_service in extra_room_services">
                                                                    <th scope="row" class="w-50">
                                                                        {{ extra_room_service.service.name }}
                                                                    </th>
                                                                    <td>{{ extra_room_service.quantity }} м<sup>2</sup></td>

                                                                    <template v-if="extra_order.order.discount">
                                                                        <template v-if="extra_room_service.service.can_be_discounted">
                                                                            <td>{{ extra_room_service.service.price * (1 - parseInt(extra_order.order.discount)/100) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(extra_room_service.quantity, extra_room_service.service.price * (1 - parseInt(extra_order.order.discount)/100)) }} Р</td>
                                                                        </template>
                                                                        <template v-else>
                                                                            <td>{{ extra_room_service.service.price }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(extra_room_service.quantity, extra_room_service.service.price) }} Р</td>
                                                                        </template>
                                                                    </template>

                                                                    <template v-if="extra_order.order.markup">
                                                                        <td>{{ extra_room_service.service.price * (1 + parseInt(extra_order.order.markup)/100) }} Р/м<sup>2</sup></td>
                                                                        <td>{{ priceCount(extra_room_service.quantity, extra_room_service.service.price * (1 + parseInt(extra_order.order.markup)/100)) }} Р</td>
                                                                    </template>

                                                                    <template v-if="extra_order.order.discount === null && extra_order.order.markup === null">
                                                                        <td>{{ extra_room_service.service.price }} Р/м<sup>2</sup></td>
                                                                        <td>{{ priceCount(extra_room_service.quantity, extra_room_service.service.price) }} Р</td>
                                                                    </template>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </template>

                                        </div>
                                    </template>
                                </template>

                                <div style="padding-bottom: 5em;"></div>
                            </div>

                    </div>
                </div>
            </div>
        </template>

    </section>
</template>

<script>
    import OrderExportCollection from '../../../../mixins/OrderExportCollection'

    export default {
        mixins: [OrderExportCollection],

        data () {
            return {
                extra_order: [],
                order: [],
                square: 0,

                contract: null,
                client_name: null,
                percentage: null,

                manager_id: 1,
                withMaterials: false,
                service_types: [],

                selected_id: null,

                extra_room_service_ids: [],
                extra_rooms: [],
            }
        },

        mounted () {
            this.getExtraOrder()
            this.getServiceTypes()
        },

        methods: {
            getExtraOrder () {
                return axios.get(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}`)
                            .then(response => {
                                this.extra_order = response.data
                                this.square = 0

                                this.extra_order.extra_rooms.forEach(item => {
                                    this.square += parseFloat(item.area)
                                })

                                this.contract = this.extra_order.order.contract
                                this.client_name = this.extra_order.order.client_name
                                this.manager_id = this.extra_order.order.manager_id
                            })
            },

            getServiceTypes () {
                if (localStorage.getItem('service_types')) {
                    this.service_types = JSON.parse(localStorage.getItem('service_types'))
                } else {
                    return axios.get(`/api/service_types`).then(response => {
                        this.service_types = response.data
                        localStorage.setItem('service_types', JSON.stringify(this.service_types))
                    })
                }
            },

            getServicesByServiceType(services, service_type_id) {
                return services.filter(row => {
                    return row.service_type_id === parseInt(service_type_id)
                })
            },

            orderUpdate () {
                axios.patch(`/api/orders/${this.extra_order.order.id}/update`, {
                    'manager_id': this.manager_id,
                    'contract': this.contract,
                    'client_name': this.client_name,
                    'discount': this.discount
               })
           },

           priceCount (area, price) {
               return new Intl.NumberFormat().format(area * price)
           },

           changeRoomName (id) {
               this.show = !this.show
           },


           exportFile () {
               if (this.withMaterials) {
                   axios.get(`/api/orders/${this.extra_order.order.id}/extra_order_act/${this.extra_order.id}/export/pdf/materials`)
                        .then(response => {
                            window.open(`${response.data.url}/storage/${response.data.data}`)
                        })
               } else {
                   axios.get(`/api/orders/${this.extra_order.order.id}/extra_order_act/${this.extra_order.id}/export/pdf`)
                        .then(response => {
                            window.open(`${response.data.url}/storage/${response.data.data}`)
                        })
               }

           },

        },


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

    .btn-primary {
        background-color: #00A4D1;
        border-radius: .25rem;
        border: none;
        color: #fff;
        cursor: pointer;
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
    .form-control {
        border-radius: 0;
        font-size: 0.875rem;
        &:focus {
            border-color: #000;
            box-shadow: none;
        }
    }
}
textarea {
     resize: none;
     height:175px;
}

.small-case {
    font-size: 1rem;
}

.main-subtitle--room {
  padding-top: 75px;
}
</style>
