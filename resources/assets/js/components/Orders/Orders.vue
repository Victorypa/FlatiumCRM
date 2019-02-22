<template>
<section class="estimates">

    <basic-header></basic-header>

      <div class="container-fluid ">
        <div class="row">
          <navigation></navigation>

          <div class="col-md-10 px-0">

            <div class="create__fixed-top col-10 shadow-light">
              <div class="row align-items-center px-15">
                <div class="col-md-10">
                  <h1 class="main-caption">
                    Все сметы
                  </h1>
                </div>
              </div>

              <div class="col-md-12 pt-4">
                  <div class="input-group">
                    <input class="form-control py-2"
                           type="search" placeholder="Введите адрес"
                           v-model="quickSearchQuery"
                           >
                    <i class="fa fa-search"></i>
                  </div>
              </div>

              <div class="row pt-4 justify-content-end">
                <div class="px-30">
                    <label>
                        <input type="checkbox"
                               :checked="sortByStatus"
                               v-model="sortByStatus"
                               >
                               <span>в работе</span>
                    </label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                      <th>
                          <label>
                              В Работе
                          </label>
                      </th>
                    <th>
                      <div class="form-check custom-control">
                        <label>
                            Название
                        </label>
                      </div>
                    </th>

                    <th @click="sortByPrice = !sortByPrice">
                        <span class="arrow-sort">
                            Стоимость
                        </span>
                    </th>

                    <th class="d-flex justify-content-end" @click="sortByDate = !sortByDate">
                      <span class="arrow-sort">
                          Сортировка по дате
                          <i class="fa" :class="filteredDateArrow"></i>
                      </span>
                    </th>
                  </tr>
                </thead>

                <tbody v-if="orders.length">
                    <Order v-if="filteredOrders.length"
                           v-for="order in filteredOrders"
                           :order="order"
                           :key="order.id"
                           @deleted-copy="getOrders()"
                           />
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </section>
</template>

<script>
import Order from './Partials/Order'

export default {
  data() {
    return {
      orders: [],
      sortByDate: false,
      sortByPrice: false,
      quickSearchQuery: "",
      sortByStatus: false
    };
  },

  components: {
      Order
  },

  created () {
    this.getOrders();
  },

  methods: {
    getOrders() {
        return axios.get(`/api/orders`).then(response => {
          this.orders = response.data
        })
    },

    deleteFinishedOrderAct (order_id, finished_order_act_id) {
        if (confirm('Удалить?')) {
            axios.delete(`/api/orders/${order_id}/finished_order_act/${finished_order_act_id}/destroy`)
                 .then(response => {
                     this.getOrders()
                 })
        }
    },

    deleteExtraOrderAct (order_id, extra_order_act_id) {
        if (confirm('Удалить?')) {
            axios.delete(`/api/orders/${order_id}/extra_order_act/${extra_order_act_id}/destroy`)
                 .then(response => {
                     this.getOrders()
                 })
        }
    }
  },

  computed: {
      filteredDateArrow () {
          return this.sortByDate ? 'fa-arrow-up' : 'fa-arrow-down'
      },

    filteredOrders() {
      let data = this.orders;

      data = data.filter(row => {
        return Object.keys(row).some(key => {
          return (
            String(row[key])
              .toLowerCase()
              .indexOf(this.quickSearchQuery.toLowerCase()) > -1
          );
        });
      });

      if (!this.sortByDate) {
          data = _.orderBy(data, ['created_at'], ['desc'])
      } else {
          data = _.orderBy(data, ['created_at'], ['asc'])
      }

      if (this.sortByPrice) {
          data = data.filter(order => {
              return order.price
          })

          data = _.sortBy(data, 'price')
      }

      if (this.sortByStatus) {
          data = data.filter(row => row.processing)
      }

      return data;
    }
  }
};
</script>
