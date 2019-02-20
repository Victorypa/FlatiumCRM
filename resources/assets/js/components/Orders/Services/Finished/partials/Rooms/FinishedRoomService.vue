<template>
    <tr>
      <th scope="row" class="w-50 pl-1">
        <div class="form-check custom-control checkbox">
          <input class="form-check-input check"
                 :id="'room-' + room_service.room_id + 'service-' + room_service.service_id"
                 type="checkbox"
                 @click="addFinishService()"
                 >
                 <!-- :checked="finished_room_service_ids.includes(room_service.service_id)" -->
                 <!-- @click="addToSelectedServiceId(room_service.service_id)" -->
          <label class="form-check-label d-block"
                 :for="'room-' + room_service.room_id + 'service-' + room_service.service_id"
                 >
              {{ room_service.service.name }}
          </label>
        </div>
      </th>
      <td class="py-1 pl-1">
          <div class="d-flex align-items-center">
              <input type="number"
                     class="form-control w-85"
                     :id="'room-' + room_service.room_id + 'service-' + room_service.service_id"
                     min="0"
                     v-model="room_service.quantity"
                     @change="updateFinishServiceQuantity()"
                     >
              <div class="col-auto pl-2">
                  {{ room_service.unit.name }}
              </div>
          </div>
      </td>

      <td>{{ filteredServicePrice }} Р/{{ room_service.unit.name }}</td>
      <td>{{ priceCount(room_service.quantity, filteredServicePrice) }} Р</td>
    </tr>
</template>

<script>
    export default {
        props: ['room_service', 'room'],

        created () {
            this.getFinishedRoomServices()
        },

        methods: {
            getFinishedRoomServices () {
                
            },

            addFinishService () {
                axios.post(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/services/store`, {
                    'finished_room_id': this.finished_room_id,
                    'service_id': this.room_service.service_id,
                    'quantity': this.room_service.quantity,
                    'price': this.room_service.quantity * this.filteredServicePrice,
                }).then(response => {
                    // this.$emit('price', parseFloat(response.data).toFixed(2))
                })
            },

            updateFinishServiceQuantity () {
                axios.patch(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/services/update`, {
                    'finished_room_id': this.finished_room_id,
                    'service_id': this.room_service.service_id,
                    'quantity': this.room_service.quantity,
                    'price': this.room_service.quantity * this.filteredServicePrice,
                }).then(response => {

                })
            },

            priceCount (quantity, price) {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(quantity * price))
            },
        },

        computed: {
            finished_room_id () {
                return this.room.finished_room.filter(row => {
                    return row.finished_order_act_id == this.$route.params.finished_act_id
                })[0].id
            },

            filteredServicePrice () {
                if (this.room.order.discount) {
                    if (this.room_service.service.can_be_discounted) {
                        return parseInt(this.room_service.service.price * (1 - parseInt(this.room.order.discount)/100))
                    } else {
                        return parseInt(this.room_service.service.price)
                    }
                }

                if (this.room.order.markup) {
                    return parseInt(this.room_service.service.price * (1 + parseInt(this.room.order.markup)/100))
                }

                if (this.room.order.markup === null && this.room.order.discount === null) {
                    if (this.room_service.markup) {
                        return parseInt(this.room_service.service.price * (1 + parseInt(this.room_service.markup)/100))
                    } else {
                        return parseInt(room_service.service.price)
                    }
                }
            }
        }
    }
</script>
