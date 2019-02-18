<template>
        <div class="row align-items-center col-12 py-4 pl-5  fixed-search bg">
            <div class="col-2 pb-2">
                    <select class="form-control" v-model="service_type_id">
                          <option v-for="service_type in service_types" :value="service_type.id">
                              {{ service_type.name }}
                          </option>
                    </select>
            </div>
            <div class="col-10 d-flex align-items-center pl-0 pb-2">
                <div class="form-group col-12 d-flex align-items-center">
                    <input type="text"
                           class="form-control"
                           placeholder="Название вида работы"
                           v-model="searchQuery"
                           autofocus
                           >
                </div>
            </div>


            <div class="col-12">
                <AddService :service_type_id="service_type_id"
                            @created-service="getServices()"
                            />
            </div>

            <template v-if="service_type_id !== 0">
                <div class="col-12 pr-0" style="margin-bottom: 5em;">
                  <div class="main-subtitle main-subtitle--fz pt-3 pb-2">
                      {{ getServiceTypeName(service_type_id) }}
                  </div>

                  <div class="col-md-12 px-0 all-items"
                       v-if="room.room_services.length !== 0"
                       v-for="room_service in filteredRoomServices"
                       :key="room_service.service_id"
                       >
                          <RoomService :room_service="room_service" />
                  </div>

                  <div class="col-md-12 px-0 all-items"
                       v-for="service in filteredServices"
                       :key="service.id"
                       >
                       <Service :service="service" :room="room" />
                  </div>
                </div>

            </template>
        </div>
</template>

<script>
    import ServiceCollection from '@/components/Services/mixins/ServiceCollection'
    import AddService from '@/components/Services/partials/AddService'
    import RoomService from './partials/RoomService'
    import Service from './partials/Service'

    export default {
        props: ['room', 'order'],

        mixins: [ServiceCollection],

        components: {
            AddService,
            RoomService,
            Service
        },

        data () {
            return {
                service_types: [],
                service_type_id: 0,

                searchQuery: "",

                units: [],
                services: [],

                room_services: [],

                room_service_ids: [],
                room_service_types: [],
                room_service_materials: [],
                room_service_markups: [],

                service_names: [],
                service_units: [],
                service_can_be_deleted: [],
                service_quantities: [],
                service_prices: [],

            }
        },

        mounted () {
            this.getServices()
        },

        methods: {
            getServiceTypes () {
                    return axios.get(`/api/service_types`).then(response => {
                        switch (parseInt(this.room.room_type_id)) {
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

            getServiceTypeName (service_type_id) {
                if (this.service_types.length) {
                    return this.service_types.filter(row => {
                        return row.id === this.service_type_id
                    })[0].name
                }
            },

            getServices () {
                return axios.get('/api/services').then(response => {
                    this.services = response.data

                    if (this.order.discount) {
                        response.data.forEach(item => {
                            if (item.can_be_discounted) {
                                this.service_prices[item.id] = item.price * (1 - parseFloat(this.order.discount)/100)
                            }
                            if (!item.can_be_discounted) {
                                this.service_prices[item.id] = item.price
                            }
                        })
                    }

                    if (this.order.markup) {
                        response.data.forEach(item => {
                            this.service_prices[item.id] = item.price * (1 + parseFloat(this.order.markup)/100)
                        })
                    }

                    if (this.order.discount === null && this.order.markup === null) {
                        response.data.forEach(item => {
                            this.service_prices[item.id] = item.price
                        })
                    }

                    response.data.forEach(item => {
                        this.service_names[item.id] = item.name
                        this.service_units[item.id] = item.unit.name
                        this.service_can_be_deleted[item.id] = item.can_be_deleted
                        this.room_service_types[item.id] = item.service_type_id

                        if (!this.room_service_ids.includes(item.id)) {
                            if (this.service_quantities[item.id] !== null) {
                                switch (item.unit.id) {
                                    case 1:
                                        if (item.service_type_id === 1) {
                                            this.service_quantities[item.id] = this.room.area
                                        }
                                        if (item.service_type_id === 2) {
                                            this.service_quantities[item.id] = this.room.wall_area
                                        }

                                        if (item.service_type_id === 3) {
                                            this.service_quantities[item.id] = this.room.area
                                        }
                                        break;
                                    case 2:
                                        this.service_quantities[item.id] = this.room.perimeter
                                        break;
                                    default:
                                        this.service_quantities[item.id] = 1
                                }
                            }
                        }

                    })
                })
            },

            addToRoomServiceId (id) {
                if (!this.room_service_ids.includes(id)) {
                  this.room_service_ids.push(id);
                } else {
                  let index = this.room_service_ids.indexOf(id);
                  if (index > -1) {
                    this.room_service_ids.splice(index, 1);
                  }
                }
                this.linkServicesToRoom()
            },

            linkServicesToRoom () {
                axios.post(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/store`, {
                    'room_service_ids': this.removeEmptyElem(this.room_service_ids),
                    'service_quantities': this.removeEmptyElem(this.service_quantities),
                    'service_prices': this.service_prices
                }).then(response => {
                    this.$emit('price', parseInt(response.data.room.price))
                })
            },

            updateRoomServiceMarkup () {
                axios.patch(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}/services/update`, {
                    'room_service_markups': this.removeEmptyElem(this.room_service_markups)
                })
                .then(response => {
                    this.$emit('price', parseInt(response.data.room.price))
                })
            },

            getServiceSummary (id) {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(this.service_prices[id] * this.service_quantities[id]))
            },

            getMaterialSummary (rate, quantity, price, room_service_quantity) {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(Math.ceil((rate * room_service_quantity)/quantity) * price))
            },
        },

        computed: {
            filteredServices () {
                if (this.services.length !== 0) {
                    let data = this.services

                    let room_service_ids = []

                    this.room.room_services.forEach(room_service => {
                        room_service_ids.push(room_service.service_id)
                    })

                    data = data.filter(row => {
                        return room_service_ids.indexOf(row.id) < 0
                    })

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
            },

            filteredRoomServices () {
                let data = this.room.room_services

                data = data.filter(row => {
                    return row.service_type_id === this.service_type_id
                })

                return data
            },
        }
    }
</script>

<style lang="scss" scoped>
$main-color: #00A4D1;
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
.w-85 {
    width: 85px;
}

.fa-search::before {
  right: 25px;
}
</style>
