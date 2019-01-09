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
                    <th>Клиент</th>
                    <th>Дата подписания</th>
                    <th>Номер договора</th>
                    <th>Менеджер</th>
                    <th>Скидка</th>
                    <th>Наценка</th>
                    <th>Сумма договора</th>
                    <th>Дизайн</th>
                    <th>Работы</th>
                    <th>Материалы</th>
                    <th>Мебель</th>
                    <th>Плановая прибыль</th>
                    <th>Баланс итого</th>
                    <th>Тек.приб.раб</th>
                    <th>Тек.приб. Мат</th>
                    <th>Пр работы</th>
                    <th>Рсхд работы</th>
                    <th>Баланс работы</th>
                    <th>Пр Мат</th>
                    <th>Рсхд Мат</th>
                    <th>Балланс Мат</th>
                    <th>Бонусы</th>
                    <th>Дата начала</th>
                    <th>Дата сдачи</th>
                    <th>Статус</th>
                  </tr>
                </thead>
                <tbody>

                  <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.address ? order.address : order.order_name }}</td>
                    <td></td>
                    <td>28.11.19</td>
                    <td>{{ order.contract ? order.contract : '' }}</td>
                    <td>{{ order.manager ? order.manager.name : '' }}</td>
                    <td>{{ order.discount ? order.discount : '' }}</td>
                    <td>{{ order.markup ? order.markup : '' }}</td>
                    <td>{{ order.price ? new Intl.NumberFormat('ru-Ru').format(parseInt(order.price) + parseInt(calculateMaterialsPrice(order))) : 0 }} Р</td>
                    <td>Х</td>
                    <!-- Дизайн -->
                    <td>{{ order.price ? new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) : 0 }}</td>
                    <!-- Работы -->
                    <td>{{ calculateMaterialsPrice(order) }} Р</td>
                    <!-- Материалы -->
                    <td>0</td>
                    <!-- мебель -->
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>121212Р</td>
                    <td>28.11.19</td>
                    <td>28.11.19</td>
                    <td>Статус</td>
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
              this.orders = response.data
            })
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
    overflow-x: scroll;
  }
}
</style>
