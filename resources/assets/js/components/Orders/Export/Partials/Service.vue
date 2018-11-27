<template>
    <!-- <div class="col-12 px-0">

        <table class="table table-hover">

            <tbody>
                <tr v-for="room_service in getServicesByServiceType(room.services, service_type.id)">
                    <th scope="row" class="w-50">
                        {{ room_service.name }}
                    </th>
                    <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                    <td>{{ room_service.price }} Р/м<sup>2</sup></td>
                    <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                </tr>
            </tbody>
        </table>

    </div> -->
</template>

<script>
    export default {
        props: ['room', 'service_type'],

        data () {
            return {

            }
        },

        mounted () {
            console.log(this.room);
        },

        methods: {

        }
    }
</script>
