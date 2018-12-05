<template>
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


            <form class="w-100" @submit.prevent="saveNewService()">

                <div class="row" v-for="(newService, index) in newServices">
                    <div class="col-2 py-1">
                        &nbsp;
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
                <button class="add-space-button" @click="addService()">+ Добавить работу</button>
            </div>
        </div>

        <template v-if="service_type_id !== 0">
            <div class="col-12 pr-0" style="margin-bottom: 5em;" :key="'extra_room' + extra_room.id">
              <div class="main-subtitle main-subtitle--fz pt-3 pb-2">
                  {{ getServiceTypeName(service_type_id) }}
              </div>

              <div class="col-md-12 px-0 all-items" v-for="service in filteredServices">

                <div class="row align-items-center">

                  <label class="col-md-4 mb-0">
                      <div class="form-check custom-control d-flex edit-show">
                          <input class="form-check-input"
                                 type="checkbox"
                                 :id="'service-' + service.id"
                                 :checked="extra_room_service_ids.includes(service.id)"
                                 @click="addToExtraRoomServiceId(service.id)"
                                 >

                          <label class="form-check-label"
                                 :for="'service-' + service.id"
                                 >
                                 {{ service.name }}
                          </label>

                          <router-link class="ml-auto edit" :to="{ name: 'service-material', params: { service_id: service.id } }">
                                  Ред.
                          </router-link>
                      </div>
                  </label>

                <div class="col-md-8 pr-0">
                  <div class="form-group form-group--margin d-flex align-items-center">
                    <input type="number"
                           class="form-control w-85"
                           placeholder="Кол-во"
                           min="0"
                           v-model="service_quantities[service.id]"
                           @change="linkExtraServicesToExtraRoom()"
                           >

                    <div class="inputs-caption col-md-2">
                        {{ service.unit.name }}
                    </div>

                    <input type="number"
                           class="form-control w-85"
                           :value="service_prices[service.id]"
                           disabled
                           >

                    <div class="inputs-caption col-md-2">
                        Р/{{ service.unit.name }}
                    </div>

                    <div class="form-group__calc w-85">
                        {{ new Intl.NumberFormat('ru-Ru').format(getServiceSummary(service.id)) }} P
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

                    <template v-if="extra_room_service_ids.includes(service.id)">
                        <router-link :to="{ name: 'order-extra-services-materials', params: { id: extra_room.extra_order_act.order.id, extra_order_act_id: extra_room.extra_order_act.id, extra_room_id: extra_room.id, service_id: service.id }}">
                            <div class="col-md-auto px-0 ml-auto">
                                <button class="add-button " title="Добавить материалы">
                                    <img src="/img/plus-circle.svg" alt="add-button">
                                </button>
                            </div>
                        </router-link>
                    </template>
                    <template v-else>
                        <div class="col-md-auto px-0">
                            &nbsp;
                        </div>
                    </template>
                  </div>
                </div>


                <template v-if="extra_room_service_ids.includes(service.id) && extra_room.extra_room_services.filter(extra_room_service => extra_room_service.service_id === service.id)[0].materials">
                        <div class="row col-12" v-for="material in extra_room.extra_room_services.filter(extra_room_service => extra_room_service.service_id === service.id)[0].materials">
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
        </template>

    </div>
</template>

<script>
    import ServiceCollection from '../../../../../mixins/ServiceCollection'

    export default {
        props: ['extra_room', 'order'],

        mixins: [ServiceCollection],

        data () {
            return {
                services: [],
                service_types: [],
                service_type_id: 0,
                newServices: [],

                extra_room_service_ids: [],
                service_quantities: [],
                service_prices: [],

                units: [],

                searchQuery: '',
            }
        },

        mounted () {
            this.getServiceTypes()
            this.getExtraRoomServices()
            this.getServices()
        },

        methods: {
            getExtraRoomServices () {
                this.extra_room.extra_room_services.forEach(extra_room_service => {
                    this.extra_room_service_ids.push(extra_room_service.service_id)

                    if (extra_room_service.quantity != null) {
                        this.service_quantities[extra_room_service.service_id] = extra_room_service.quantity
                    } else {
                        this.service_quantities[extra_room_service.service_id] = 1
                    }
                })
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
                        if (!this.extra_room_service_ids.includes(item.id)) {
                            switch (item.unit_id) {
                                case 1:
                                    if (item.service_type_id === 1) {
                                        this.service_quantities[item.id] = this.extra_room.area
                                    }
                                    if (item.service_type_id === 2) {
                                        this.service_quantities[item.id] = this.extra_room.wall_area
                                    }

                                    if (item.service_type_id === 3) {
                                        this.service_quantities[item.id] = this.extra_room.area
                                    }
                                    break;
                                case 2:
                                    this.service_quantities[item.id] = this.extra_room.perimeter
                                    break;
                                default:
                                    this.service_quantities[item.id] = 1
                            }
                        }

                    })


                })
            },

            addToExtraRoomServiceId (id) {
                if (!this.extra_room_service_ids.includes(id)) {
                  this.extra_room_service_ids.push(id)
                } else {
                  let index = this.extra_room_service_ids.indexOf(id);
                  if (index > -1) {
                    this.extra_room_service_ids.splice(index, 1);
                  }
                }
                this.linkExtraServicesToExtraRoom()
            },

            linkExtraServicesToExtraRoom () {
                axios.post(`/api/orders/${this.$route.params.id}/extra_order_act/${this.$route.params.extra_order_act_id}/extra_rooms/${this.$route.params.extra_room_id}/extra_services/store`, {
                    'room_service_ids': this.extra_room_service_ids,
                    'service_quantities': this.removeEmptyElem(this.service_quantities),
                    'service_prices': this.removeEmptyElem(this.service_prices)
                }).then(response => {
                    this.extra_order_act_price = null
                    this.extra_room_price = response.data.extra_room.price
                    this.extra_order_act_price = response.data.extra_order_act.price
                    this.$emit('price', parseInt(response.data.extra_room.price))
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
$main-color: #00A4D1;

.w-85 {
  width: 85px;
}

.edit-show:hover {
  .edit {
    transition: 0.5s;
    opacity:1;
  }
}
.edit {
    opacity: 0;
          color: $main-color;
    &:hover {
      cursor: pointer;
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
</style>
