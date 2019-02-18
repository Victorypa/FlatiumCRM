<template>
    <!-- <template v-for="(room_service, index) in room_service_ids">
        <div class="projects__information">
            <div class="px-15 pb-3">
                <template v-if="!show">
                    <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName">
                        {{ getRoomDetails(room_service[0], 'description') ? getRoomDetails(room_service[0], 'description') : getRoomDetails(room_service[0], 'room_type') }}
                        <img src="/img/edit.svg" alt="add-button" title="Редактировать">
                    </h2>
                </template>
                <template v-else>
                    <div class="row main-subtitle main-subtitle--room" @mouseleave="show = false">
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text"
                                       class="form-control"
                                       :placeholder="getRoomDetails(room_service[0], 'room_type')"
                                       v-model="descriptions[room_service[0]]"
                                       @change="updateDescription(room_service[0])"
                                       >
                            </div>
                        </div>
                    </div>
                </template>

            </div>

            <template v-if="getRoomDetails(room_service[0], 'room_type_id') === 1">
                <div class="projects__desc col-8 d-flex justify-content-between align-items-center pt-3">
                    <div class="projects__desc-item">Общая площадь: {{ getRoomDetails(room_service[0], 'area') }} м<sup>2</sup></div>
                    <div class="projects__desc-item">Высота потолка: {{ getRoomDetails(room_service[0], 'height') }} м</div>
                    <div class="projects__desc-item">Площадь стен: {{ getRoomDetails(room_service[0], 'wall_area') }} м<sup>2</sup></div>
                    <div class="projects__desc-item">Периметр: {{ getRoomDetails(room_service[0], 'perimeter') }}</div>
                </div>
            </template>

            <template v-for="(services, service_type_id) in groupByServiceType(room_service[1])">
                <div class="row bg px-15">

                    <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                        {{ getServiceTypeName(service_type_id) }}
                    </div>

                    <div class="col-12 px-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr v-for="room_service in sortServicesByCreatedAt(services)" :key="room_service.id">
                                    <th scope="row" class="w-50">
                                        {{ getServiceDetails(room_service.service_id, 'name') }}
                                    </th>
                                    <td>{{ parseFloat(room_service.quantity).toFixed(2) }}  {{ room_service.unit.name }}</td>

                                    <template v-if="order.discount">
                                        <template v-if="getServiceDetails(room_service.service_id, 'can_be_discounted')">
                                            <td>{{ getServiceDetails(room_service.service_id, 'price') * (1 - parseInt(order.discount)/100) }} Р/{{ room_service.unit.name }}</td>
                                            <td>{{ priceCount(room_service.quantity, getServiceDetails(room_service.service_id, 'price') * (1 - parseFloat(order.discount)/100)) }} Р</td>
                                        </template>
                                        <template v-else>
                                            <td>{{ getServiceDetails(room_service.service_id, 'price') }} Р/{{ room_service.unit.name }}</td>
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
                                    <td>
                                        <i class="fa fa-arrow-down"
                                           v-if="!checkElement(room_service, sortServicesByCreatedAt(services), 'last')"
                                           @click="move(room_service, 'down')"
                                           ></i>
                                        &nbsp;
                                        <i class="fa fa-arrow-up"
                                           v-if="!checkElement(room_service, sortServicesByCreatedAt(services), 'first')"
                                           @click="move(room_service, 'up')"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
        </div>
    </template> -->
</template>

<script>
    export default {
        props: ['rooms'],

        data () {
            return {

            }
        },

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
            }
        }
    }
</script>
