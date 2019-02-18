<template>
    <div>
        <div class="projects__information" v-for="room in filteredRooms" :key="'room-' + room.id">
            <div class="px-15 pb-3">
                <h2 class="main-subtitle main-subtitle--room">
                    {{ room.description ? room.description : room.room_type.type }}
                </h2>
            </div>

            <div class="projects__desc col-8 d-flex justify-content-between align-items-center pt-3"
                 v-if="room.room_type_id === 1">
                <div class="projects__desc-item">
                    Общая площадь: {{ room.area }} м<sup>2</sup>
                </div>
                <div class="projects__desc-item">
                    Высота потолка: {{ room.height }} м
                </div>
                <div class="projects__desc-item">
                    Площадь стен: {{ room.wall_area }} м<sup>2</sup>
                </div>
                <div class="projects__desc-item">
                    Периметр: {{ room.perimeter }}
                </div>
            </div>

            <div class="row bg px-15"
                 v-if="room.room_services.length !== 0"
                 v-for="(room_services, service_type) in servicesGroupBy(room.room_services)"
                 >

                <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                    {{ service_type }}
                </div>

                <div class="col-12 px-0">
                    <table class="table table-hover">
                        <tbody>
                            <tr v-for="room_service in room_services" :key="room_service.id">
                                <th scope="row" class="w-50">
                                    {{ room_service.service.name }}
                                </th>
                                <td>{{ room_service.quantity }}  {{ room_service.unit.name }}</td>

                                <template v-if="room.order.discount">
                                    <template v-if="room_service.service.can_be_discounted">
                                        <td>{{ room_service.service.price * (1 - parseInt(room.order.discount)/100) }} Р/{{ room_service.unit.name }}</td>
                                        <td>{{ priceCount(room_service.quantity, room_service.service.price * (1 - parseFloat(room.order.discount)/100)) }} Р</td>
                                    </template>
                                    <template v-else>
                                        <td>{{ room_service.service.price }} Р/{{ room_service.unit.name }}</td>
                                        <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price')) }} Р</td>
                                    </template>
                                </template>
                                <template v-if="order.markup">
                                    <td>{{ getServiceDetails(room_service.service_id, 'price') * (1 + parseInt(order.markup)/100) }} Р/{{ room_service.unit.name }}</td>
                                    <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price') * (1 + parseFloat(order.markup)/100)) }} Р</td>
                                </template>
                                <template v-if="order.discount === null && order.markup === null">
                                    <td>{{ getServiceDetails(room_service.service_id, 'price') }} Р/{{ room_service.unit.name }}</td>
                                    <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price')) }} Р</td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    export default {
        props: ['rooms'],

        created () {
            console.log(this.rooms);
        },

        methods: {
            getServiceTypeName (service_type_id) {
                if (this.service_types && service_type_id) {
                    return this.service_types.filter(row => {
                        return row.id === parseInt(service_type_id)
                    })[0].name
                }
            },

            servicesGroupBy (room_services) {
                return _.groupBy(room_services, 'service_type.name')
            }
        },

        computed: {
            filteredRooms () {
                let data = this.rooms

                data = _.orderBy(data, ['priority'], ['asc'])

                return data
            }
        }
    }
</script>
