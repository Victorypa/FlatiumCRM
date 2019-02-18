<template>
    <tr>
        <th scope="row" class="w-50">
            {{ room_service.service.name }}
        </th>
        <td>{{ room_service.quantity }}  {{ room_service.unit.name }}</td>

        <template v-if="order.discount">
            <template v-if="room_service.service.can_be_discounted">
                <td>{{ room_service.service.price * (1 - parseInt(order.discount)/100) }} Р/{{ room_service.unit.name }}</td>
                <td>{{ priceCount(room_service.quantity, room_service.service.price * (1 - parseFloat(order.discount)/100)) }} Р</td>
            </template>
            <template v-else>
                <td>{{ room_service.service.price }} Р/{{ room_service.unit.name }}</td>
                <td>{{ priceCount(room_service.quantity, room_service.service.price) }} Р</td>
            </template>
        </template>
        <template v-if="order.markup">
            <td>{{ room_service.service.price * (1 + parseInt(order.markup)/100) }} Р/{{ room_service.unit.name }}</td>
            <td>{{ priceCount(room_service.quantity, room_service.service.price * (1 + parseFloat(order.markup)/100)) }} Р</td>
        </template>
        <template v-if="order.discount === null && order.markup === null">
            <td>{{ room_service.service.price }} Р/{{ room_service.unit.name }}</td>
            <td>{{ priceCount(room_service.quantity, room_service.service.price) }} Р</td>
        </template>
    </tr>
</template>

<script>
    export default {
        props: ['order', 'room_service'],

        methods: {
            priceCount (quantity, price) {
                return new Intl.NumberFormat('ru-Ru').format(parseInt(quantity * price))
            },
        }
    }
</script>
