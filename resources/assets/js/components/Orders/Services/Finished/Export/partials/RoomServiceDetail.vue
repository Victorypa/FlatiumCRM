<template>
    <tr>
      <th scope="row" class="w-50">{{ finished_room_service.service.name }}</th>
      <td>{{ finished_room_service.quantity }} {{ finished_room_service.service.unit.name }}</td>

      <td>{{ filteredServicePrice }} Р/{{ finished_room_service.service.unit.name }}</td>
      <td>{{ finished_room_service.price }} Р</td>

    </tr>
</template>

<script>
    export default {
        props: ['finished_room_service', 'finished_room'],

        computed: {
            filteredServicePrice () {
                if (this.finished_room.room.order.discount) {
                    if (this.finished_room_service.service.can_be_discounted) {
                        return parseInt(this.finished_room_service.service.price * (1 - parseInt(this.finished_room.room.order.discount)/100))
                    } else {
                        return parseInt(this.finished_room_service.service.price)
                    }
                }

                if (this.finished_roomюroom.order.markup) {
                    return parseInt(this.finished_room_service.service.price * (1 + parseInt(this.finished_room_service.room.order.markup)/100))
                }

                if (this.finished_room_service.room.order.markup === null && this.finished_room_service.room.order.discount === null) {
                    return parseInt(finished_room_service.service.price)
                }
            }
        }
    }
</script>
