<template>
    <section class="projects">

        <basic-header></basic-header>

        <div class="container-fluid ">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10">

                    <div class=" row col-10 main-caption-wrapper shadow-light px-15 align-items-center">
                        <div class="col-md-8">
                            <h1 class="main-caption">
                                <template v-if="order.address">
                                    {{ order.address }}
                                </template>
                                <template v-else>
                                    {{ order.order_name }}
                                </template>
                            </h1>
                        </div>

                        <div class="col-md-2">
                        </div>

                        <div class="col-md-2">
                            <template v-if="order.rooms">
                                <router-link :to="{ name: 'room-show', params: { id: order.id, room_id: order.rooms[0].id } }" >
                                    <button type="button" class="primary-button w-100">
                                        Редактировать
                                    </button>
                                </router-link>
                            </template>
                            <template v-else>
                                <router-link :to="{ name: 'order-show', params: { id: order.id } }" >
                                    <button type="button" class="primary-button w-100">
                                        Редактировать
                                    </button>
                                </router-link>
                            </template>
                        </div>

                        <div class="col-md-12 px-0 pt-4">
                            <h2 class="main-subtitle px-15">
                                <template v-if="order.rooms">
                                    <span>Общая S:</span> {{ square }} м<sup>2</sup>
                                </template>


                                <template v-if="order.discount">
                                    <span>Итого:</span> {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р
                                    <span class="small-case">{{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.original_price)) }} Р</span>
                                    <span class="small-case">(скидка: -{{ order.discount }}%)</span>
                                </template>

                                <template v-else-if="order.markup">
                                    <span>Итого:</span> {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р
                                    <span class="small-case">{{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.original_price)) }} Р</span>
                                    <span class="small-case">(наценка: +{{ order.markup }}%)</span>
                                </template>

                                <template v-else>
                                    <span>Итого:</span> {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} Р
                                </template>
                            </h2>
                        </div>

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


                            <RoomServices v-if="rooms.length !== 0"
                                         :rooms="rooms"
                                         />

                            <div class="row bg py-4">
                                <div class="col-12 d-flex align-items-center justify-content-end">
                                     <div class="col-2">
                                        <select class="form-control"
                                                v-model="selected_id"
                                                @change="percentage = null"
                                                >
                                                <option value=null>Выберите</option>
                                                <option value=1>Скидка</option>
                                                <option value=2>Наценка</option>
                                        </select>
                                    </div>
                                    <div class="col-1">
                                        <input type="number"
                                               class="form-control"
                                               placeholder="%"
                                               min="0"
                                               v-model="percentage"
                                               @change="updateOrderDiscountOrMarkup()"
                                               >
                                    </div>

                                    <h2 class="main-subtitle px-15">
                                        Итого: {{ new Intl.NumberFormat('ru-Ru').format(order.price) }} Р
                                    </h2>

                                </div>
                            </div>

                            <div class="row ml-3 my-4">
                                <textarea class="col-6"
                                          placeholder="Добавить комментарий к смете"
                                          v-model="description"
                                          @change="orderUpdate()"
                                          >
                                </textarea>
                            </div>

                        </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import RoomServices from './Partials/RoomServices'
    import OrderExportCollection from '../../../mixins/OrderExportCollection'
    import ServiceCollection from '../../../mixins/ServiceCollection'

    export default {
        mixins: [OrderExportCollection, ServiceCollection],

        components: {
            RoomServices
        },

        data () {
            return {
                order: [],
                square: 0,
                contract: null,
                client_name: null,
                description: '',
                percentage: null,

                withMaterials: false,

                show: false,
                descriptions: [],

                selected_id: null,

                room_service_ids: [],
                room_service_booleans: [],
                rooms: []

            }
        },

        mounted () {
            this.getOrder()
        },

        methods: {
            getOrder () {
                return axios.get(`/api/orders/${this.$route.params.id}`)
                            .then(response => {
                                this.order = response.data
                                this.rooms = this.order.rooms
                                this.contract = this.order.contract
                                this.manager_id = this.order.manager_id
                                this.client_name = this.order.client_name
                                this.description = this.order.description

                                if (this.order.discount) {
                                    this.selected_id = "1"
                                    this.percentage = this.order.discount
                                }
                                if (this.order.markup) {
                                    this.selected_id = "2"
                                    this.percentage = this.order.markup
                                }

                                this.square = 0
                                this.order.rooms.forEach(room => {

                                    room.room_services.forEach(room_service => {
                                        this.room_service_booleans.push(
                                            {
                                                'room_id': room_service.room_id,
                                                'service_id': room_service.service_id,
                                                'show': false
                                            }
                                        )
                                    })

                                    this.square += parseInt(room.area)
                                    let data = _.groupBy(room.room_services, 'room_id')
                                    this.room_service_ids.push(Object.entries(data)[0])
                                })
                            })
            },

            orderUpdate () {
                axios.patch(`/api/orders/${this.order.id}/update`, {
                    'manager_id': this.manager_id,
                    'contract': this.contract,
                    'client_name': this.client_name,
                    'description': this.description,
                    'discount': this.discount
               })
           },

           updateOrderDiscountOrMarkup () {
               if (this.selected_id === "1") {
                   axios.patch(`/api/orders/${this.order.id}/discount_or_markup/update`, {
                       'discount': this.percentage,
                       'markup': null
                   }).then(response => {
                       window.location.reload(true)
                   })
               }

               if (this.selected_id === "2") {
                   axios.patch(`/api/orders/${this.order.id}/discount_or_markup/update`, {
                       'discount': null,
                       'markup': this.percentage
                   }).then(response => {
                       window.location.reload(true)
                   })
               }

           },

           move (room_service, type) {
               axios.patch(`/api/orders/${this.$route.params.id}/rooms/${room_service.room_id}/services/update_created_at`, {
                   'room_service': room_service
               })
           },

           checkElement (element, data, type) {
               if (type === 'last') {
                   return element === data[data.length - 1]
               }

               if (type === 'first') {
                   return element === data[0]
               }
           },

           changeRoomName (id) {
               this.show = !this.show
           },

           updateDescription (id) {
               axios.patch(`/api/orders/${this.$route.params.id}/rooms/${id}/update_description`, {
                  'description': this.descriptions[id]
              }).then(response => {
                  window.location.reload(true)
              })
           },

           exportFile () {
               let answer = prompt("PDF (1) или Excel (2)", "1")

               if (answer.toLowerCase() === '1') {
                   if (this.withMaterials) {
                       axios.get(`/api/orders/${this.order.id}/export/pdf/materials`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                            })
                   } else {
                       axios.get(`/api/orders/${this.order.id}/export/pdf`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                            })
                   }
               }
               if (answer.toLowerCase() === '2') {
                   if (this.withMaterials) {
                       axios.get(`/api/orders/${this.order.id}/export/excel/materials`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                            })
                   } else {
                       axios.get(`/api/orders/${this.order.id}/export/excel`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                            })
                   }
               }
           }

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
    .fa-arrow-down, .fa-arrow-up {
        opacity: 0;
        cursor: pointer;
        &:hover {
            color: $main-color;
        }
    }

    tr {
        &:hover {
            .fa-arrow-down, .fa-arrow-up {
                opacity: 1;
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

  .main-subtitle img {
    width: 13px;
    cursor: pointer;
  }
</style>
