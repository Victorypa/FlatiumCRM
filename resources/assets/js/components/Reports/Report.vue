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
                  <tr>
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
                    <th>Тек.приб.раб</th>
                    <!-- 13 -->
                    <th>Тек.приб. Мат</th>
                    <!-- 14 -->
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
                    <th>Дата начала</th>
                    <!-- 21 -->
                    <th>Дата сдачи</th>
                    <!-- 22 -->
                  </tr>
                </thead>
                <tbody v-if="orders.length">

                  <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.address ? order.address : order.order_name }}</td>
                    <!-- 1 -->
                    <td></td>
                    <!-- 2 -->
                    <td>28.11.19</td>
                    <!-- 3 -->
                    <td>{{ order.contract ? order.contract : '' }}</td>
                    <!-- 4 -->
                    <td>{{ order.manager ? order.manager.name : '' }}</td>
                    <!-- 5 -->
                    <td>{{ order.discount ? order.discount : '' }}</td>
                    <!-- 6 -->
                    <td>{{ order.markup ? order.markup : '' }}</td>
                    <!-- 7 -->
                    <td>{{ order.price ? new Intl.NumberFormat('ru-Ru').format(parseInt(order.price) + parseInt(calculateMaterialsPrice(order))) : 0 }} Р</td>
                    <!-- 8 -->
                    <td>{{ order.price ? new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) : 0 }}</td>
                    <!-- 9 -->
                    <td>{{ calculateMaterialsPrice(order) }} Р</td>
                    <!-- 10 -->
                    <td>{{ getPlannedProfit(order) }}</td>
                    <!-- 11 -->
                    <td>121212Р</td>
                    <!-- 12 -->
                    <td>121212Р</td>
                    <!-- 13 -->
                    <td>121212Р</td>
                    <!-- 14 -->
                    <td>121212Р</td>
                    <!-- 15 -->
                    <td>{{ getServicesExpense(order) }}</td>
                    <!-- 16 -->
                    <td>{{ getTotalBalance(order) }} Р</td>
                    <!-- 17 -->
                    <td>121212Р</td>
                    <!-- 18 -->
                    <td>121212Р</td>
                    <!-- 19 -->
                    <td>121212Р</td>
                    <!-- 20 -->
                    <td>28.11.19</td>
                    <!-- 21 -->
                    <td>28.11.19</td>
                    <!-- 22 -->
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
export default {
    data () {
        return {
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

        getTotalBalance (order) {
          if (order.finances.length) {
            let incomes = 0
            let expenses = 0
            order.finances.forEach(item => {
              if (item.finance_type === 'income') {
                incomes += parseInt(item.price)
              }
              if (item.finance_type === 'expense') {
                expenses += parseInt(item.price)
              }
            })
            return new Intl.NumberFormat('ru-Ru').format(incomes - expenses)
          } else {
            return 0
          }
        },

        getServicesExpense (order) {
          
        },

        getPlannedProfit (order) {

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
        },

        removeEmptyElem(obj) {
            let newObj = {}

            Object.keys(obj).forEach((prop) => {
              if (obj[prop]) { newObj[prop] = obj[prop] }
            })

            return newObj
       },
    }
}
</script>

<style lang="scss">
.table {
  margin-top: 100px;
  min-width: 3100px;
  &__wrapper {
    overflow: auto;
  }

}
</style>
