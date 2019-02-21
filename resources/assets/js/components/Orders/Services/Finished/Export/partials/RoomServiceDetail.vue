<template>
    <tr>
      <th scope="row" class="w-50">{{ finished_room_service.service.name }}</th>
      <td>{{ finished_room_service.quantity }} {{ finished_room_service.service.unit.name }}</td>

      <!-- <template v-if="finished_order.order.discount">
          <template v-if="finished_room_service.service.can_be_discounted">
              <td>{{ finished_room_service.price * (1 - parseInt(finished_order.order.discount)/100) }} Р/{{ finished_service.unit.name }}</td>
              <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price * (1 - parseInt(finished_order.order.discount)/100)) }} Р</td>
          </template>
          <template v-else>
              <td>{{ finished_service.price }} Р/{{ finished_service.unit.name }}</td>
              <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price) }} Р</td>
          </template>
      </template>
      <template v-if="finished_order.order.markup">
          <td>{{ finished_service.price * (1 + parseInt(finished_order.order.markup)/100) }} Р/{{ finished_service.unit.name }}</td>
          <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price * (1 + parseInt(finished_order.order.markup)/100)) }} Р</td>
      </template>
      <template v-if="finished_order.order.discount === null && finished_order.order.markup === null">
          <td>{{ finished_service.price }} Р/{{ finished_service.unit.name }}</td>
          <td>{{ priceCount(finished_service.pivot.quantity, finished_service.price) }} Р</td>
      </template> -->
    </tr>
</template>

<script>
    export default {
        props: ['finished_room_service'],

        computed: {
            filteredPrice () {
                
            }
        }
    }
</script>
