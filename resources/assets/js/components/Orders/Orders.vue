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
                <form>

                  <div class="input-group">
                    <input class="form-control py-2"
                           type="search" placeholder="Введите адрес"
                           v-model="quickSearchQuery"
                           >
                    <i class="fa fa-search"></i>
                  </div>
                </form>
              </div>

              <div class="row pt-4 justify-content-end">

                <div class="px-30">

                    <a class="estimates__dropdown-img" href="." data-toggle="dropdown" data-html="true"
                      title="Действия">
                      <img src="/img/dropdown-toggle.svg" alt="export">
                    </a>


                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Экспорт</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>
                      <div class="form-check custom-control checkbox">
                        <input class="form-check-input check" id="checkAll" type="checkbox">
                        <label class="form-check-label" for="checkAll">
                          Выбрать все
                        </label>
                      </div>
                    </th>

                    <th class="d-flex justify-content-end" @click="sortByDateStart()">
                      <span class="arrow-sort">
                          Сортировка по дате
                          <img class="arrow-icon" src="/img/arrow_down.svg" alt="up">
                      </span>
                    </th>
                  </tr>
                </thead>

                <tbody v-if="orders.length">
                    <template v-for="order in filteredOrders">
                        <tr>
                          <td>
                            <div class="form-check custom-control checkbox">
                              <input class="form-check-input check"
                                     :id="'order-' + order.id"
                                     type="checkbox">
                              <label class="form-check-label" :for="'order-' + order.id">

                                  <template v-if="order.rooms.length">
                                      <router-link :to="{ name: 'room-show', params: { id: order.id, room_id: order.rooms[order.rooms.length - 1].id } }">
                                          {{ filteredOrderName(order) }}
                                      </router-link>
                                  </template>

                                  <template v-else>
                                      <router-link :to="{ name: 'order-show', params: { id: order.id } }">
                                          {{ filteredOrderName(order) }}
                                      </router-link>
                                  </template>
                              </label>
                            </div>
                          </td>

                          <td class="d-flex justify-content-end">
                              <div class="pr-4">
                                   {{ dateFormatter(order.created_at) }}
                              </div>

                              <div class="pl-30">
                                  <a class="estimates__dropdown-img estimates__dropdown-img--rotate" href="." data-toggle="dropdown" data-html="true"
                                    title="Действия">
                                    <img src="/img/dropdown-toggle.svg" alt="export">
                                  </a>


                              <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item text-color"
                                    @click="createFinishedOrderAct(order.id)">
                                    Создать акт
                                </a>
                                  <a class="dropdown-item text-color"
                                     @click="createExtraOrderAct(order.id)">
                                      Создать доп.ведомость
                                  </a>

                                  <router-link class="dropdown-item text-color" :to="{ name: 'order-finance', params: { id: order.id} }">
                                      Баланс
                                  </router-link>

                                  <router-link class="dropdown-item text-color" :to="{ name: 'order-step', params: { id: order.id} }">
                                      График работ
                                  </router-link>
                              </div>
                            </div>
                          </td>
                        </tr>

                        <template v-if="order.finished_order_acts.length" v-for="(finished_order_act, index) in order.finished_order_acts">
                                <tr class="small-case">
                                    <td>
                                        <router-link :to="{ name: 'order-finished-services-export-show', params: { id: order.id, finished_act_id: finished_order_act.id } }">
                                            <div class="d-flex">
                                                <div class="col-9">
                                                    <template v-if="finished_order_act.description">
                                                        {{ finished_order_act.description }}({{ index + parseInt(1) }})
                                                    </template>
                                                    <template v-else>
                                                        {{ finished_order_act.name }}({{ index + parseInt(1) }})
                                                    </template>
                                                </div>
                                            </div>
                                        </router-link>
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <div class="col-auto">
                                            {{ dateFormatter(finished_order_act.created_at) }}
                                        </div>

                                        <template v-if="checkIfLastElement(finished_order_act, order.finished_order_acts)">
                                            <div class="d-flex align-items-center pl-30 show-button">
                                                <router-link :to="{ name: 'order-finished-services', params: { id: order.id, finished_act_id: finished_order_act.id }}">
                                                    <button class="add-button add-button--remove d-flex align-items-center">
                                                        <img src="/img/edit.svg" alt="add-button">
                                                    </button>
                                                </router-link>

                                                <button class="add-button add-button--remove d-flex align-items-center" @click="deleteFinishedOrderAct(order.id, finished_order_act.id)">
                                                    <img src="/img/del.svg" alt="add-button">
                                                </button>
                                            </div>
                                        </template>

                                    </td>
                                </tr>
                        </template>


                        <template v-if="order.extra_order_acts.length" v-for="(extra_order_act, index) in order.extra_order_acts">
                                <tr class="small-case">
                                    <td>
                                        <router-link :to="{ name: 'order-extra-services-export-show', params: { id: order.id, extra_order_act_id: extra_order_act.id } }">
                                            <div class="d-flex">
                                                <div class="col-9">
                                                    <template v-if="extra_order_act.description">
                                                        {{ extra_order_act.description }}({{ index + parseInt(1) }})
                                                    </template>
                                                    <template v-else>
                                                        {{ extra_order_act.name }}({{ index + parseInt(1) }})
                                                    </template>
                                                </div>
                                            </div>
                                        </router-link>
                                    </td>

                                    <td class="d-flex justify-content-end">
                                        <div class="col-auto">
                                            {{ dateFormatter(extra_order_act.created_at) }}
                                        </div>

                                        <template v-if="checkIfLastElement(extra_order_act, order.extra_order_acts)">
                                            <div class="d-flex align-items-center pl-30 show-button">
                                                <router-link :to="{ name: 'order-extra-services-rooms-show', params: { id: order.id, extra_order_act_id: extra_order_act.id, extra_room_id: extra_order_act.extra_rooms[0].id }}">
                                                    <button class="add-button add-button--remove d-flex align-items-center" title="Редактировать">
                                                        <img src="/img/edit.svg" alt="add-button">
                                                    </button>
                                                </router-link>

                                                <button class="add-button add-button--remove d-flex align-items-center" @click="deleteExtraOrderAct(order.id, extra_order_act.id)">
                                                    <img src="/img/del.svg" alt="add-button">
                                                </button>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                        </template>
                    </template>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </section>
</template>

<script>
import moment from 'moment'

export default {
  data() {
    return {
      moment,

      orders: [],
      sortByDate: false,
      quickSearchQuery: "",
    };
  },

  mounted() {
    this.getOrders();
  },

  methods: {
    getOrders() {
        return axios.get(`/api/orders`).then(response => {
          this.orders = response.data
        })
    },

    createFinishedOrderAct (id) {
        axios.post(`/api/orders/${id}/finished_order_act/store`, {
            'order_id': id,
            'name': `Акт выполненных работ`
        }).then(response => {
            this.$router.push({ name: 'order-finished-services', params: { id: id, finished_act_id: response.data.id }})
        })
    },

    createExtraOrderAct (id) {
        axios.post(`/api/orders/${id}/extra_order_act/store`, {
            'order_id': id,
            'name': `Акт дополнительных работ`
        }).then(response => {
            this.$router.push({ name: 'order-extra-services-rooms-show', params: { id: id, extra_order_act_id: response.data.id, extra_room_id: response.data.extra_rooms[0].id }})
        })
    },

    sortByDateStart() {
      this.sortByDate = !this.sortByDate;
    },

    dateFormatter(dateString) {
      return this.moment(new Date(dateString)).format("DD-MM-YYYY");
    },

    filteredOrderName(order) {
          if (order.address != null) {
            return order.address;
          } else {
            return order.order_name.substring(0, 25);
          }
    },

    checkIfLastElement (element, data) {
        return element === data[data.length - 1]
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

      return data;
    }
  }
};
</script>

<style scoped lang="scss">
a {
  color: #666666;
  &:hover {
    text-decoration: none;
    color: #00a4d1;
  }
}

table {
  th{
    border-top: none;
  }
  tr:hover {
  .estimates__dropdown-img--rotate {
      opacity: 1;
  }
   .show-button {
     opacity:1;
   }
  }
}
 .estimates__dropdown-img--rotate {
   opacity: 0;
   img {
       transform: none;
   }
 }

 .show-button {
   opacity:0;

 }

 .add-button img {
   width: 11px;
   cursor: pointer;
 }

 .small-case {
  font-size: 0.9rem;
  td {
    &:first-child {
      padding-left: 35px;
    }
  }
  &__date {
    margin-right: 75px;
  }
}
.text-color {
  color: #666 !important;
  &:hover {
    color: #00a4d1 !important;
  }
  cursor: pointer;
  &:active {
      background-color: transparent;
  }
}

</style>
