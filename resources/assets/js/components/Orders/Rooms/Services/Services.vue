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
                       <i class="fa fa-search"></i>
                    </div>
        </div>


            <template v-for="(newService, index) in newServices">

                <form class="row w-100" @submit.prevent="saveNewService()">
                    <div class="col-2 py-1">
                        &nbsp;
                    </div>

                    <div class="col-5 py-1">
                        <div class="form-group d-flex align-items-center">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Название"
                                   v-model="newService.name"
                                   >
                                   <i class="fa fa-search"></i>
                        </div>
                    </div>

                    <div class="col-auto d-flex align-items-center">
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

                        <div class="col-auto py-1">
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
                    <button type="submit" style="display:none;"></button>
                </form>
            </template>



        <div class="col-12 py-3 pl-0">
            <div class="col-12">
                <button class="add-space-button" @click="addService()">+ Добавить работу</button>
            </div>
        </div>

        <template v-if="service_type_id !== 0">
            <div class="col-12 pr-0" style="margin-bottom: 5em;">
              <div class="main-subtitle main-subtitle--fz pt-3 pb-2">
                  {{ getServiceTypeName(service_type_id) }}
              </div>

              <div class="col-md-12 px-0 all-items" v-for="room_service_id in room_service_ids" :key="room_service_id">

                <template v-if="room_service_types[room_service_id] === service_type_id">
                  <div class="row align-items-center">
                      <label class="col-md-4 mb-0">
                          <div class="form-check custom-control d-flex edit-show">
                              <input class="form-check-input"
                                     type="checkbox"
                                     :id="'service-' + room_service_id"
                                     :checked="true"
                                     @click="addToRoomServiceId(room_service_id)"
                                     >

                              <label class="form-check-label"
                                     :for="'service-' + room_service_id"
                                     >
                                     {{ service_names[room_service_id] }}
                              </label>

                              <router-link class="ml-auto edit" :to="{ name: 'service-material', params: { service_id: room_service_id } }">
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
                                   v-model="service_quantities[room_service_id]"
                                   @change="linkServicesToRoom()"
                                   >

                            <div class="inputs-caption col-md-2">
                                {{ service_units[room_service_id] }}
                            </div>

                            <input type="number"
                            class="form-control w-85"
                            min="0"
                            disabled
                            :value="service_prices[room_service_id]"
                            >

                            <div class="inputs-caption col-md-2">
                                Р/{{ service_units[room_service_id] }}
                            </div>

                            <div class="form-group__calc w-85">
                                {{ getServiceSummary(room_service_id) }} P
                            </div>

                            <template v-if="service_can_be_deleted[room_service_id]">
                                <div class="col-md-2">
                                    <button @click="deleteService(room_service_id)" class="add-button add-button--remove d-flex align-items-center" title="Удалить материал">
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

                            <div class="col-md-auto px-0 ml-auto">
                                <template v-if="room.order">
                                    <router-link :to="{ name: 'actual-material', params: { id: room.order.id, room_id: room.id, service_id: room_service_id }}">
                                        <button class="add-button " title="Добавить материалы">
                                            <img src="/img/plus-circle.svg" alt="add-button">
                                        </button>
                                    </router-link>
                                </template>
                            </div>

                        </div>
                    </div>

                    <div class="row col-12" v-for="(material) in room_service_materials[room_service_id]">
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
                                  {{ getMaterialSummary(material.pivot.rate, material.quantity, material.price, service_quantities[room_service_id]) }} Р
                              </div>
                            </div>
                          </div>
                      </template>
                    </div>
                  </div>
                </template>


            </div>

              <div class="col-md-12 px-0 all-items" v-for="service in filteredServices" v-if="!room_service_ids.includes(service.id)" :key="service.id">

                <div class="row align-items-center">

                  <label class="col-md-4 mb-0">
                      <div class="form-check custom-control d-flex edit-show">
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
                           @change="linkServicesToRoom()"
                           >

                    <div class="inputs-caption col-md-2">
                        {{ service.unit.name }}
                    </div>

                    <input type="number"
                           class="form-control w-85"
                           min="0"
                           disabled
                           :value="service_prices[service.id]"
                           >

                    <div class="inputs-caption col-md-2">
                        Р/{{ service.unit.name }}
                    </div>

                    <div class="form-group__calc w-85">
                        {{ getServiceSummary(service.id) }} P
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
        </template>

    </div>

</template>

<script>
    import ServiceCollection from '../../../../mixins/ServiceCollection'

    export default {
        props: ['room', 'order'],

        mixins: [ServiceCollection],

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

                service_names: [],
                service_units: [],
                service_can_be_deleted: [],
                service_quantities: [],
                service_prices: [],

            }
        },

        mounted () {
            this.getServices()
            this.getRoomServices()
        },

        methods: {
            getRoomServices() {
                return axios.get(`/api/orders/${this.$route.params.id}/rooms/${this.$route.params.room_id}`)
                            .then(response => {
                                response.data.room_services.forEach(item => {
                                    this.room_service_ids.push(item.service_id)
                                    this.room_service_materials[item.service_id] = item.materials

                                    this.room_services.push({
                                        service_id: item.service_id,
                                        service_type_id: item.service_type_id
                                    })

                                    if (item.quantity != null) {
                                        this.service_quantities[item.service_id] = item.quantity
                                    } else {
                                        this.service_quantities[item.service_id] = 1
                                    }
                                })
                            })
            },

            getServiceTypes () {
                    return axios.get(`/api/service_types`).then(response => {
                        this.service_types = response.data
                        this.service_type_id = this.service_types[0].id
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

            getMaterialSummary (rate, quantity, price, room_service_quantity) {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(Math.ceil((rate * room_service_quantity)/quantity) * price))
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

.fa-search::before {
  right: 25px;
}
</style>
