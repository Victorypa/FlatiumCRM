<template>
    <tr>
      <th scope="row" class="w-50 pl-1">
        <div class="form-check custom-control checkbox">
          <input class="form-check-input check"
                 :id="'room-' + room_service.room_id + 'service-' + room_service.service_id"
                 type="checkbox"

                 >
                 <!-- :checked="finished_room_service_ids.includes(room_service.service_id)" -->
                 <!-- @click="addToSelectedServiceId(room_service.service_id)" -->
          <label class="form-check-label d-block" :for="'room-' + room_service.room_id + 'service-' + room_service.service_id">
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
                     >
                     <!-- @change="linkSelectedServicesToFinishedRoom()" -->
              <div class="col-auto pl-2">
                  {{ room_service.unit.name }}
              </div>
          </div>
      </td>

      <template v-if="room.order.discount">
          <template v-if="room_service.service.can_be_discounted">
              <td>{{ parseInt(room_service.service.price * (1 - parseInt(room.order.discount)/100)) }} Р/{{ room_service.unit.name }}</td>
              <td>{{ priceCount(room_service.quantity, parseInt(room_service.service.price * (1 - parseInt(room.order.discount)/100))) }} Р</td>
          </template>
          <template v-else>
              <td>{{ parseInt(getServiceDetails(room_service.service_id, 'price')) }} Р/{{ getServiceDetails(room_service.service_id, 'unit') }}</td>
              <td>{{ priceCount(room_service.quantity, parseInt(room_service.service.price)) }} Р</td>
          </template>
      </template>
      <template v-if="room.order.markup">
          <td>{{ parseInt(room_service.service.price * (1 + parseInt(room.order.markup)/100)) }} Р/{{ room_service.unit.name }}</td>
          <td>{{ priceCount(room_service.quantity, parseInt(room_service.service.price * (1 + parseInt(order.markup)/100))) }} Р</td>
      </template>
      <template v-if="room.order.markup === null && room.order.discount === null">
          <template v-if="room_service.markup">
              <td>{{ parseInt(room_service.service.price * (1 + parseInt(room_service.markup)/100)) }} Р/{{ room_service.unit.name }}</td>
              <td>{{ priceCount(room_service.quantity, parseInt(room_service.service.price * (1 + parseInt(room_service.markup)/100))) }} Р</td>
          </template>
          <template v-else>
              <td>{{ parseInt(room_service.service.price) }} Р/{{ room_service.unit.name }}</td>
              <td>{{ priceCount(room_service.quantity, parseInt(room_service.service.price)) }} Р</td>
          </template>
      </template>
    </tr>
</template>

<script>
    export default {
        props: ['room_service', 'room'],

        methods: {
            linkSelectedServicesToFinishedRoom () {
                axios.post(`/api/orders/${this.$route.params.id}/finished_order_act/${this.$route.params.finished_act_id}/services/store`, {
                    'finished_room_id': this.filterFinishedRoomId(),
                    'selected_service_ids': this.finished_room_service_ids,
                    'selected_service_quantities': this.removeEmptyElem(this.selected_service_quantities)
                }).then(response => {
                    this.$emit('price', parseFloat(response.data).toFixed(2))
                })
            },

            priceCount (quantity, price) {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(quantity * price))
            },
        }
    }
</script>
