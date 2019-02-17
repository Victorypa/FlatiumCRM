<template>
    <div class="create__fixed-top col-10 px-0 shadow-light align-items-center pl-3">
        <div class="row align-items-center pb-3">

                <div class="col-md-6 d-flex justify-content-between align-items-center">
                    <h1 class="main-caption col-12 pl-0">
                        {{ getOrderName }}
                    </h1>
                </div>

                <div class="col-md-6 d-flex px-0 align-items-center" v-if="room">
                    <div class="col-4 create__sum pl-0"
                         style="font-size: 16px;"
                         >
                        Итого: {{ getOrderPrice }} P
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


        </div>

        <div class="row align-items-center justify-content-between w-100">

            <div class="col-md-12 pl-30">
                <div class="form-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Адрес объекта"
                           v-model="order.address"
                           @change="orderAddressUpdate()"
                           >
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
  props: ["order", "room"],

  methods: {
    orderAddressUpdate () {
      if (this.order.address != null) {
        axios .patch(`/api/orders/${this.order.id}/update`, {
           address: this.order.address
         }).then(response => {
           this.$emit("order-saved");
         })

      }
  },


  copyOrder (id) {
      let option = prompt("Полностью (1) или Только Помещения (2)", "2")

      axios.get(`/api/orders/${id}/copy?option=${option}`)
           .then(response => {
               this.$router.push({ name: 'room-show', params: { id: response.data[0].id, room_id: response.data[1].id } })
           })
       }
  },

  computed: {
      getOrderName () {
          return this.order.address != null ? this.order.address : 'Создание сметы'
      },

      getOrderPrice () {
          return this.order.price ? new Intl.NumberFormat('ru-Ru').format(parseInt(this.order.price)) : 0
      }
  }
};
</script>
