<template lang="html">
  <div class="">
      <basic-header></basic-header>
      <div class="container-fluid ">
        <div class="row">
          <navigation></navigation>
          <div class="col-md-10">
            <div class="col-md-12 table__wrapper px-0">
              <table class="table table-hover">
                <thead>
                  <tr v-scroll="handleScroll">
                    <th>Название</th>
                    <!-- 1 -->
                    <th>Клиент</th>
                    <!-- 2 -->
                    <th>Дата подписания</th>
                    <!-- 3 -->
                    <th>Номер договора</th>
                    <!-- 4 -->
                    <th>Менеджер</th>
                    <!-- 5 -->
                    <th>Скидка</th>
                    <!-- 6 -->
                    <th>Наценка</th>
                    <!-- 7 -->
                    <th>Сумма договора</th>
                    <!-- 8 -->
                    <th>Работы</th>
                    <!-- 9 -->
                    <th>Материалы</th>
                    <!-- 10 -->
                    <th>Плановая прибыль</th>
                    <!-- 11 -->
                    <th>Баланс итого</th>
                    <!-- 12 -->
                    <th>Тек.приб</th>
                    <!-- 13 -->
                    <th>Пр работы</th>
                    <!-- 15 -->
                    <th>Рсхд работы</th>
                    <!-- 16 -->
                    <th>Баланс работы</th>
                    <!-- 17 -->
                    <th>Пр Мат</th>
                    <!-- 18 -->
                    <th>Рсхд Мат</th>
                    <!-- 19 -->
                    <th>Балланс Мат</th>
                    <!-- 20 -->
                  </tr>
                </thead>
                <tbody v-if="orders.length">

                  <tr v-for="order in orders" :key="order.id">
                    <td>
                      <router-link class="strong-black" :to="{ name: 'room-show', params: { id: order.id, room_id: order.rooms[0].id } }">
                        <strong>{{ order.address }}</strong>
                      </router-link>
                    </td>
                    <!-- 1 Название done -->
                    <td>{{ order.client_name ? order.client_name : '' }}</td>
                    <!-- 2 Клиент done -->
                    <td>{{ moment(new Date(order.created_at)).format('DD-MM-YYYY') }}</td>
                    <!-- 3 Дата подписания done -->
                    <td>{{ order.contract ? order.contract : '' }}</td>
                    <!-- 4 Номер договора done -->
                    <td>{{ order.manager ? order.manager.name : '' }}</td>
                    <!-- 5 Менеджер done -->
                    <td>{{ order.discount ? order.discount : 0 }} %</td>
                    <!-- 6 Скидка done -->
                    <td>{{ order.markup ? order.markup : 0 }} %</td>
                    <!-- 7 Наценка done -->
                    <td>{{ order.price ? new Intl.NumberFormat('ru-Ru').format(parseInt(order.price) + parseInt(calculateMaterialsPrice(order))) : 0 }} Р</td>
                    <!-- 8 Сумма договора done -->
                    <td>{{ order.price ? new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) : 0 }}</td>
                    <!-- 9 Работы done -->
                    <td>{{ calculateMaterialsPrice(order) }} Р</td>
                    <!-- 10 Материалы done -->
                    <td>{{ getPlannedProfit(order) }} Р</td>
                    <!-- 11 Плановая прибыль done -->
                    <td>{{ getTotalBalance(order, 'balance') }} Р</td>
                    <!-- 12 Баланс итого -->
                    <td>{{ getPresentProfit(order) }} Р</td>
                    <!-- 13 Тек.приб -->
                    <td>{{ getServicesIncome(order) }} Р</td>
                    <!-- 15 Пр работы -->
                    <td>{{ getTotalBalance(order, 'worker_expense') }} Р</td>
                    <!-- 16 Рсхд работы -->
                    <td>{{ getTotalBalance(order, 'service_balance') }} Р</td>
                    <!-- 17 -->
                    <td>{{ getMaterialsExpense(order, 'income') }} Р</td>
                    <!-- 18 -->
                    <td>{{ getMaterialsExpense(order, 'expense') }} Р</td>
                    <!-- 19 -->
                    <td>{{ getMaterialsExpense(order, 'balance') }} Р</td>
                    <!-- 20 -->
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  </div>

</template>

<script>
import moment from 'moment'
export default {
    data () {
        return {
            moment,
            orders: []
        }
    },

    created () {
        this.getOrders()
    },

    methods: {
        getOrders() {
            return axios.get(`/api/reports`).then(response => {
              this.orders = response.data.filter(order => order.rooms.length !== 0)
            })
        },

        getTotalBalance (order, type) {
          if (order.finances.length) {
            let incomes = 0
            let expenses = 0
            let worker_expenses = 0
            let service_income = 0
            let service_expense = 0

            order.finances.forEach(item => {
              if (item.finance_type === 'income') {
                incomes += parseInt(item.price)
                if (item.reason === 'Акт выполненных работ' || item.reason === 'Акт дополнительных работ') {
                  service_income += parseInt(item.price)
                }
              }
              if (item.finance_type === 'expense') {
                expenses += parseInt(item.price)
                if (item.reason === 'Оплата рабочим') {
                  worker_expenses += parseInt(item.price)
                }
                if (item.reason === 'Акт выполненных работ' || item.reason === 'Акт дополнительных работ') {
                  service_expense += parseInt(item.price)
                }
              }
            })
            switch (type) {
              case 'balance':
                return new Intl.NumberFormat('ru-Ru').format(parseInt(incomes - expenses))
                break;

              case 'income':
                return new Intl.NumberFormat('ru-Ru').format(incomes)
                break;

              case 'expense':
                return new Intl.NumberFormat('ru-Ru').format(expenses)
                break;
              case 'worker_expense':
                return new Intl.NumberFormat('ru-Ru').format(worker_expenses)
                break;

              case 'service_balance':
                return new Intl.NumberFormat('ru-Ru').format(parseInt(service_income - service_expense))
                break;
              default:
                return 0
            }
          } else {
            return 0
          }
        },

        getServicesIncome (order) {
          let finished_act_incomes = 0
          let extra_act_incomes = 0

          if (order.finished_order_acts.length) {
            order.finished_order_acts.forEach(act => {
              finished_act_incomes += parseInt(act.price)
            })
          } else {
            return 0
          }

          if (order.extra_order_acts.length) {
            order.extra_order_acts.forEach(act => {
              extra_act_incomes += parseInt(act.price)
            })
          } else {
            return 0
          }
          return new Intl.NumberFormat('ru-Ru').format(parseInt(finished_act_incomes + extra_act_incomes))
        },

        getPresentProfit (order) {
          if (order.discount !== 0 && order.discount !== null) {
            let result = parseInt(this.getTotalBalance(order, 'income')) * 0.45 * (1 - parseInt(order.discount) / 100)
            return new Intl.NumberFormat('ru-Ru').format(parseInt(result))
          }
          else {
            let result = parseInt(this.getTotalBalance(order, 'income')) * 0.45
            return new Intl.NumberFormat('ru-Ru').format(parseInt(result))
          }
        },

        getMaterialsExpense (order, type) {
          if (order.finances.length) {
              let material_incomes = 0
              let material_expenses = 0

              order.finances.forEach(finance => {
                if (finance.reason === "Оплата материалов от клиента") {
                  material_incomes += parseInt(finance.price)
                }
                if (finance.reason === "Оплата материалов") {
                  material_expenses += parseInt(finance.price)
                }
              })
              switch (type) {
                case 'balance':
                  return new Intl.NumberFormat('ru-Ru').format(material_incomes - material_expenses)
                  break;
                case 'income':
                  return new Intl.NumberFormat('ru-Ru').format(material_incomes)
                  break;
                case 'expense':
                  return new Intl.NumberFormat('ru-Ru').format(material_expenses)
                  break;
                default:
                  return 0
              }
          } else {
            return 0
          }
        },

        getPlannedProfit (order) {
          if (order.discount !== 0 && order.discount !== null) {
            let result = parseInt(order.original_price) * 0.45 * (1 - parseInt(order.discount) / 100)
            return new Intl.NumberFormat('ru-Ru').format(parseInt(result))
          }
          else {
            let result = parseInt(order.price) * 0.45
            return new Intl.NumberFormat('ru-Ru').format(parseInt(result))
          }
        },

        calculateMaterialsPrice (order) {
            let materialPrice = 0

            if (order.rooms) {
                order.rooms.forEach(room => {
                    if (room.room_services) {
                        room.room_services.forEach(room_service => {
                            if (room_service.materials) {
                                room_service.materials.forEach(material => {
                                    materialPrice += parseInt(material.price) * parseFloat(material.pivot.rate)
                                })
                            }
                        })
                    }
                })
            }
            return materialPrice ? new Intl.NumberFormat('ru-Ru').format(materialPrice) : 0
        }
    }
}
</script>

<style lang="scss">
.table {
  margin-top: 100px;
  min-width: 3100px;
  &__wrapper {
    overflow: auto;
    height: 100vh;
  }
}

.strong-black {
  color: black;
}
</style>
