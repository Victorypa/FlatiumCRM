<template>

    <div class="projects">
        <basic-header></basic-header>
        <template v-if="order">
            <div class="container-fluid px-0">
              <div class="row">
                <navigation></navigation>

                <div class="col-md-10 px-0">

                    <OrderDetail v-if="order.length !== 0"
                                 :order="order"
                                 :service_price="service_price"
                                 :material_price="material_price"
                                 :income_amount="income_amount"
                                 :profit="profit"
                                 />

                  <div class="col-12">

                    <div class="main-content">

                      <form @submit.prevent="saveIncome()" class="row align-items-center">
                        <div class="main-subtitle profit col-1 mr-4">
                          Приход:
                        </div>
                        <div class="col-2">
                          <input type="number"
                                 class="form-control"
                                 min="0"
                                 placeholder="Сумма"
                                 v-model="income"
                                 required
                                 >
                        </div>
                        <div class="col-2">
                          <select class="form-control" v-model="income_reason">
                            <option selected disabled value="null">Причина</option>

                            <option v-if="order.finished_order_acts"
                                    v-for="(finished_order_act, index) in order.finished_order_acts"
                                    :value="finished_order_act.description"
                                    >
                                {{ finished_order_act.description ? finished_order_act.description : finished_order_act.name }} ({{ parseInt(index) + 1 }})
                            </option>

                            <option v-if="order.extra_order_acts"
                                    v-for="(extra_order_act, index) in order.extra_order_acts"
                                    :value="extra_order_act.description"
                                    >
                                {{ extra_order_act.description ? extra_order_act.description : extra_order_act.name }} ({{ parseInt(index) + 1 }})
                            </option>

                            <option value="Оплата материалов от клиента">Оплата материалов от клиента</option>
                            <option value="Аванс">Аванс</option>
                        </select>
                        </div>
                        <div class="col-2">
                          <datepicker class="my-datepicker"
                                      :language="ru"
                                      placeholder="Дата"
                                      v-model="income_date"
                                      >
                          </datepicker>
                        </div>
                        <button type="submit" style="display: none;"></button>
                    </form>

                      <form @submit.prevent="saveExpense()" class="row align-items-center py-4" enctype="multipart/form-data">
                            <div class="main-subtitle profit col-1 mr-4">
                              Расход:
                            </div>
                            <div class="col-2">
                              <input type="text"
                                     class="form-control"
                                     min="0"
                                     placeholder="Сумма"
                                     v-model="expense"
                                     >
                            </div>
                            <div class="col-2">
                              <select class="form-control" v-model="expense_reason">
                                  <option selected disabled value="null">Причина</option>
                                  <option value="Оплата материалов">Оплата материалов</option>
                                  <option value="Оплата рабочим">Оплата рабочим</option>

                                  <option v-if="order.finished_order_acts"
                                          v-for="(finished_order_act, index) in order.finished_order_acts"
                                          :value="finished_order_act.description"
                                          >
                                      {{ finished_order_act.description ? finished_order_act.description : finished_order_act.name }} ({{ parseInt(index) + 1 }})
                                  </option>

                                  <option v-if="order.extra_order_acts"
                                          v-for="(extra_order_act, index) in order.extra_order_acts"
                                          :value="extra_order_act.description"
                                          >
                                      {{ extra_order_act.description ? extra_order_act.description : extra_order_act.name }} ({{ parseInt(index) + 1 }})
                                  </option>
                              </select>
                            </div>

                            <div class="col-2">
                              <datepicker class="my-datepicker"
                                          :language="ru"
                                          placeholder="Дата"
                                          v-model="expense_date"
                              >
                              </datepicker>
                            </div>

                            <div class="col-2 ml-5" v-if="expense_reason === 'Оплата материалов'">
                                <vue-dropzone
                                              ref="MyDropzone"
                                              id="dropzone"
                                              :options="dropzoneOptions"
                                              class="mp-10"
                                              >
                                </vue-dropzone>
                            </div>

                            <button type="submit" style="display:none;"></button>
                      </form>

                    </div>

                  </div>

                  <div class="col-12 px-0 bg mt-3">
                    <table class="table table-hover">
                          <tbody>
                              <Finance v-for="finance in filteredFinances"
                                       :finance="finance"
                                       :key="finance.id"
                                       />
                          </tbody>
                    </table>
                  </div>



                </div>
              </div>
            </div>
        </template>

    </div>
</template>


<script>
import OrderDetail from './partials/OrderDetail'
import Finance from './partials/Finance'

import Datepicker from "vuejs-datepicker"
import { ru } from "vuejs-datepicker/dist/locale"
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    data () {
        return {
            order: [],

            expense: null,
            expense_amount: 0,
            expense_date: null,
            expense_reason: null,

            income: null,
            income_date: null,
            income_amount: 0,
            income_reason: null,

            service_price: 0,
            material_price: 0,

            finances: [],

            file: null,

            ru,
            moment,

            dropzoneOptions: {
                url: `/api/orders/${this.$route.params.id}/finance/store`,
                paramName: 'file_path',
                autoProcessQueue: false,
                thumbnailWidth: 100,
                addRemoveLinks: true,
                maxFilesize: 10.0,
                dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> Документы или Фотки",
            },

            path: window.location.hostname
        }
    },

    components: {
        Datepicker, OrderDetail, Finance,
        vueDropzone: vue2Dropzone,
    },

    mounted () {
        this.getOrder()
    },

    methods: {
        getOrder () {
            return axios.get(`/api/orders/${this.$route.params.id}`)
                        .then(response => {
                            this.order = response.data

                            this.service_price = this.order.price === null ? 0 : this.order.price

                            this.income = null
                            this.income_amount = 0
                            this.income_date = null
                            this.income_reason = null
                            this.expense = null
                            this.expense_amount = 0
                            this.expense_date = null
                            this.expense_reason = null
                            this.material_price = 0

                            this.finances = this.order.finances

                            this.finances.forEach(finance => {
                                if (finance.finance_type === 'income') {
                                    this.income_amount += parseInt(finance.price)
                                }
                                if (finance.finance_type === 'expense') {
                                    this.expense_amount += parseInt(finance.price)
                                }
                            })

                            if (this.order.rooms) {
                                this.order.rooms.forEach(room => {
                                  if (room.room_services) {
                                    room.room_services.forEach(service => {
                                      if (service.materials) {
                                        service.materials.forEach(material => {
                                          this.material_price += Math.ceil(parseFloat(material.pivot.rate).toFixed(2) * parseFloat(service.quantity).toFixed(2) / parseFloat(material.quantity).toFixed(2)) * parseFloat(material.price).toFixed(2)
                                        })
                                      }
                                    })
                                  }
                                })
                            }


                        })
        },

        saveIncome () {
            if (this.income_reason !== null && this.income_date !== null) {
                axios.post(`/api/orders/${this.$route.params.id}/finance/store`, {
                    'type': 'income',
                    'income': this.income,
                    'income_date': this.income_date,
                    'income_reason': this.income_reason
                }).then(response => {
                    this.getOrder()
                })
            } else {
                alert('Вводи причину или дату')
            }

        },

        saveExpense (e) {
            if (this.expense_reason !== null && this.expense_date !== null) {
                if (this.expense_reason === 'Оплата материалов') {
                    axios.post(`/api/orders/${this.$route.params.id}/finance/store`, {
                        'type': 'expense',
                        'income': this.expense,
                        'income_date': this.expense_date,
                        'income_reason': this.expense_reason,
                    }).then(() => {
                        this.$refs.MyDropzone.processQueue()
                        setTimeout(() => {
                            window.location.reload(true)
                        }, 3000)
                    })
                } else {
                    axios.post(`/api/orders/${this.$route.params.id}/finance/store`, {
                        'type': 'expense',
                        'income': this.expense,
                        'income_date': this.expense_date,
                        'income_reason': this.expense_reason
                    }).then(response => {
                        this.getOrder()
                    })
                }

            } else {
                alert('Вводи причину или дату')
            }

        },


    },

    computed: {
        filteredFinances () {
            if (this.finances) {
                let data = this.finances

                data = _.orderBy(data, ['inputed_at'], ['desc'])

                return data
            }
        },

        profit () {
            return parseInt(this.income_amount) - parseInt(this.expense_amount)
        }
    }
};
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
  background-color: $white;
  padding-bottom: 35px;
  padding-top: 85px;
  z-index: 999;
}

.sidebar {
  min-height: 100vh;
}

.main-content {
  padding-top: 275px;
}

.main-subtitle {
  font-size: 1.3rem;
   span {
  font-size: 1rem;
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

.remove-materials {
  font-size: 0.75rem;
}

.bg {
  padding-bottom: 400px;
}

.my-datepicker {
  line-height: 15px;
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

.inputfile {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
}



.inputfile + label {
	cursor: pointer; /* "hand" cursor */
}

</style>
