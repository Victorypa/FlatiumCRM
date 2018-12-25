<template>
    <div class="create__fixed-top col-10 px-0 shadow-light align-items-center pl-3">
        <div class="row align-items-center pb-3">

            <template v-if="room && room.id">
                <div class="col-md-6 d-flex justify-content-between align-items-center">
                    <h1 class="main-caption col-12 pl-0">
                        <template v-if="order.address != null">
                            {{ order.address }}
                        </template>
                        <template v-else>
                            Создание сметы
                        </template>
                    </h1>
                </div>

                <div class="col-md-6 d-flex px-0 align-items-center">
                    <div class="col-4 create__sum pl-0" style="font-size: 16px;">
                        <template v-if="order.price">
                            Итого: {{ new Intl.NumberFormat('ru-Ru').format(parseInt(order.price)) }} P
                        </template>
                        <template v-else>
                            Итого: 0 P
                        </template>
                    </div>

                    <div class="col-4 pl-0">
                        <router-link :to="{ name: 'order-export-show', params: { id: order.id } }" >
                            <button type="button" class="primary-button w-100">
                                Экспорт
                            </button>
                        </router-link>
                    </div>

                    <div class="col-4 pl-0">
                        <button type="button" @click="copyOrder(order.id)" class="primary-button w-100">
                            Копировать
                        </button>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="col-md-6 d-flex justify-content-between align-items-center pl-3">
                    <h1 class="main-caption col-12 pl-0">
                        <template v-if="order.address != null">
                            {{ order.address }}
                        </template>
                        <template v-else>
                            Создание сметы
                        </template>
                    </h1>
                </div>

                <div class="col-md-6 d-flex px-0 align-items-center">
                    <template v-if="order.price != null">
                        <div class="col-4 create__sum pl-0" style="font-size: 16px;">
                            Итого: {{ new Intl.NumberFormat('ru-Ru').format(order.price) }}P
                        </div>
                    </template>
                    <template v-else>
                        Итого: 0
                    </template>
                </div>
            </template>


        </div>

        <div class="row align-items-center justify-content-between w-100">

            <div class="col-md-12 pl-30">
                <div class="form-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Адрес объекта"
                           v-model="address"
                           @change="orderSave()"
                           >
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
  props: ["order", "room"],

  data() {
    return {
      address: null
    };
  },

  mounted() {
    this.orderInit()
  },

  methods: {
    orderInit() {
      this.address = this.order.address
    },

    orderSave() {
      if (this.address != null) {
        axios
          .patch(`/api/orders/${this.order.id}/update`, {
            address: this.address
          })
          .then(response => {
            this.$emit("order-saved");
          })
          .catch(function(error) {
            console.log(error);
          });
      }
  },


  copyOrder (id) {
      let option = prompt("Полностью (1) или Только Помещения (2)", "2")

      axios.get(`/api/orders/${id}/copy?option=${option}`)
           .then(response => {
               this.$router.push({ name: 'room-show', params: { id: response.data[0].id, room_id: response.data[1].id } })
           })
       }
  }
};
</script>
