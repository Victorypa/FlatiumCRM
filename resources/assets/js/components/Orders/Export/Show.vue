<template>
    <section class="projects">

        <basic-header></basic-header>

        <div class="container-fluid ">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10">

                    <div class=" row col-10 main-caption-wrapper shadow-light px-15 align-items-center">
                        <div class="col-md-8">
                            <h1 class="main-caption">
                                <template v-if="order.address">
                                    {{ order.address }}
                                </template>
                                <template v-else>
                                    {{ order.order_name }}
                                </template>
                            </h1>
                        </div>

                        <div class="col-md-2">
                        </div>

                        <div class="col-md-2">
                            <template v-if="order.rooms">
                                <router-link :to="{ name: 'room-show', params: { id: this.order.id, room_id: this.order.rooms[0].id } }" >
                                    <button type="button" class="primary-button w-100">
                                        Редактировать
                                    </button>
                                </router-link>
                            </template>
                            <template v-else>
                                <router-link :to="{ name: 'order-show', params: { id: this.order.id } }" >
                                    <button type="button" class="primary-button w-100">
                                        Редактировать
                                    </button>
                                </router-link>
                            </template>

                        </div>

                        <div class="col-md-12 px-0 pt-4">
                            <h2 class="main-subtitle px-15">
                                <template v-if="order.rooms">
                                    <span>Общая S:</span> {{ square }} м<sup>2</sup>
                                </template>


                                <template v-if="order.discount">
                                    <span>Итого:</span> {{ new Intl.NumberFormat().format(order.price) }} Р
                                    <span class="small-case">{{ order.original_price }} Р</span>
                                    <span class="small-case">(скидка: -{{ order.discount }}%)</span>
                                </template>

                                <template v-else-if="order.markup">
                                    <span>Итого:</span> {{ new Intl.NumberFormat().format(order.price) }} Р
                                    <span class="small-case">{{ order.original_price }} Р</span>
                                    <span class="small-case">(наценка: +{{ order.markup }}%)</span>
                                </template>

                                <template v-else>
                                    <span>Итого:</span> {{ new Intl.NumberFormat().format(order.price) }} Р
                                </template>
                            </h2>
                        </div>

                    </div>

                        <div class="col-12 px-0">

                            <div class="projects__content px-15">

                                <div class="row align-items-center pt-5">
                                    <div class="col-10">
                                        <div class="form-group d-flex align-items-center">

                                            <input type="text"
                                                   class="form-control"
                                                   placeholder="Имя клиента"
                                                   v-model="client_name"
                                                   @change="orderUpdate()"
                                                   >

                                            <div class="col-3">
                                                <select class="form-control"
                                                        style="height: 46px;"
                                                        v-model="manager_id"
                                                        @change="orderUpdate()"
                                                        >
                                                    <option v-for="manager in managers"
                                                            :value="manager.id"
                                                            >
                                                        {{ manager.name }}
                                                    </option>
                                                </select>
                                            </div>

                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="Телефон менеджера"
                                                       v-model="manager_phones[manager_id]"
                                                       disabled
                                                       >


                                            <input type="text"
                                                   class="form-control"
                                                   placeholder="№ Договора"
                                                   v-model="contract"
                                                   @change="orderUpdate()"
                                                   >

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" @click.prevent="exportFile()" class="primary-button w-100">
                                            Экспорт
                                        </button>
                                    </div>
                                </div>


                                <div class="col-12 px-0 pt-3">
                                  <div class="form-check custom-control checkbox">
                                    <input class="form-check-input check"
                                           id="exportmaterials"
                                           type="checkbox"
                                           v-model="withMaterials"
                                           >

                                    <label class="form-check-label" for="exportmaterials">
                                      Экспортировать с материалами
                                    </label>
                                  </div>
                                </div>
                            </div>


                            <template v-if="order.discount">
                                <template v-if="order.rooms">
                                    <template v-for="(room, index) in order.rooms">
                                        <div class="projects__information">
                                            <div class="px-15 pb-3">
                                                <template v-if="room.description">
                                                    <template v-if="!show">
                                                        <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName()">
                                                            {{ room.description }}
                                                        </h2>
                                                    </template>
                                                    <template v-else>
                                                        <div class="row" style="padding-top: 30px;">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           :placeholder="room.description"
                                                                           v-model="descriptions[room.id]"
                                                                           @change="updateDescription(room.id)"
                                                                           >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template v-else>
                                                    <template v-if="!show">
                                                        <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName()">
                                                            {{ room.room_type.type }}
                                                        </h2>
                                                    </template>
                                                    <template v-else>
                                                        <div class="row" style="padding-top: 30px;">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           :placeholder="room.room_type.type"
                                                                           v-model="descriptions[room.id]"
                                                                           @change="updateDescription(room.id)"
                                                                           >
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </template>
                                                </template>

                                            </div>

                                            <template v-if="room.room_type_id === 1">
                                                <div class="projects__desc col-8 d-flex justify-content-between align-items-center pt-3">
                                                    <div class="projects__desc-item">Общая площадь: {{ room.area }} м<sup>2</sup></div>
                                                    <div class="projects__desc-item">Высота потолка: {{ room.height }} м</div>
                                                    <div class="projects__desc-item">Площадь стен: {{ room.wall_area }} м<sup>2</sup></div>
                                                    <div class="projects__desc-item">Периметр: {{ room.perimeter }}</div>
                                                </div>

                                                <template v-for="service_type in service_types.slice(0, 3)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in getServicesByServiceType(room.room_services, service_type.id)">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service }}
                                                                        </th>
                                                                        <!-- <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td> -->

                                                                        <!-- <template v-if="room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) * (1 - parseInt(order.discount)/100) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 - parseFloat(order.discount)/100) }} Р</td>
                                                                        </template>
                                                                        <template v-if="!room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                        </template> -->
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>


                                            <template v-if="room.room_type_id === 2">
                                                <template v-for="service_type in service_types.slice(3, 4)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in room.services">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <template v-if="room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) * (1 - parseInt(order.discount)/100) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 - parseFloat(order.discount)/100) }} Р</td>
                                                                        </template>
                                                                        <template v-if="!room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                        </template>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>


                                            <template v-if="room.room_type_id === 3">
                                                <template v-for="service_type in service_types.slice(4, 5)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in room.services">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <template v-if="room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) * (1 - parseInt(order.discount)/100) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 - parseFloat(order.discount)/100) }} Р</td>
                                                                        </template>
                                                                        <template v-if="!room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                        </template>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>

                                            <template v-if="room.room_type_id === 4">
                                                <template v-for="service_type in service_types">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in getServicesByServiceType(room.services, service_type.id)">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <template v-if="room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) * (1 - parseInt(order.discount)/100) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 - parseFloat(order.discount)/100) }} Р</td>
                                                                        </template>
                                                                        <template v-if="!room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                        </template>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>

                                        </div>
                                    </template>

                                    <div class="row bg py-4">
                                        <div class="col-12 d-flex align-items-center justify-content-end">
                                             <div class="col-2">
                                                <select class="form-control"
                                                        v-model="selected_id"
                                                        @change="percentage = null"
                                                        >
                                                        <option value=null>Выберите</option>
                                                        <option value=1>Скидка</option>
                                                        <option value=2>Наценка</option>
                                                </select>
                                            </div>
                                            <div class="col-1">
                                                <input type="number"
                                                       class="form-control"
                                                       placeholder="%"
                                                       min="0"
                                                       v-model="percentage"
                                                       @change="updateOrderDiscountOrMarkup()"
                                                       >
                                            </div>

                                            <h2 class="main-subtitle px-15">
                                                Итого: {{ order.price }} Р
                                            </h2>

                                        </div>
                                    </div>

                                    <div class="row ml-3 my-4">
                                        <textarea class="col-6"
                                                  placeholder="Добавить комментарий к смете"
                                                  v-model="description"
                                                  @change="orderUpdate()"
                                                  >
                                        </textarea>
                                    </div>

                                </template>
                            </template>

                            <template v-if="order.markup">
                                <template v-if="order.rooms">
                                    <template v-for="(room, index) in order.rooms">
                                        <div class="projects__information">
                                            <div class="px-15 pb-3">
                                                <template v-if="room.description">
                                                    <template v-if="!show">
                                                        <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName()">
                                                            {{ room.description }}
                                                        </h2>
                                                    </template>
                                                    <template v-else>
                                                        <div class="row" style="padding-top: 30px;">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           :placeholder="room.description"
                                                                           v-model="descriptions[room.id]"
                                                                           @change="updateDescription(room.id)"
                                                                           >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template v-else>
                                                    <template v-if="!show">
                                                        <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName()">
                                                            {{ room.room_type.type }}
                                                        </h2>
                                                    </template>
                                                    <template v-else>
                                                        <div class="row" style="padding-top: 30px;">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           :placeholder="room.room_type.type"
                                                                           v-model="descriptions[room.id]"
                                                                           @change="updateDescription(room.id)"
                                                                           >
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </template>
                                                </template>

                                            </div>

                                            <template v-if="room.room_type_id === 1">
                                                <div class="projects__desc col-8 d-flex justify-content-between px-0 align-items-center pt-3">
                                                    <div class="projects__desc-item">Общая площадь: {{ room.area }} м<sup>2</sup></div>
                                                    <div class="projects__desc-item">Высота потолка: {{ room.height }} м</div>
                                                    <div class="projects__desc-item">Площадь стен: {{ room.wall_area }} м<sup>2</sup></div>
                                                    <div class="projects__desc-item">Периметр: {{ room.perimeter }}</div>
                                                </div>

                                                <template v-for="service_type in service_types.slice(0, 3)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in room.room_services">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>

                                                                        <td>{{ parseInt(room_service.price) * (1 + parseInt(order.markup)/100) }} Р/м<sup>2</sup></td>
                                                                        <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 + parseFloat(order.markup)/100) }} Р</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>


                                            <!-- <template v-if="room.room_type_id === 2">
                                                <template v-for="service_type in service_types.slice(3, 4)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in room.services">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>

                                                                        <td>{{ parseInt(room_service.price) * (1 + parseInt(order.markup)/100) }} Р/м<sup>2</sup></td>
                                                                        <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 + parseFloat(order.markup)/100) }} Р</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>


                                            <template v-if="room.room_type_id === 3">
                                                <template v-for="service_type in service_types.slice(4, 5)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in room.services">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <td>{{ parseInt(room_service.price) * (1 + parseInt(order.markup)/100) }} Р/м<sup>2</sup></td>
                                                                        <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 + parseFloat(order.markup)/100) }} Р</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>

                                            <template v-if="room.room_type_id === 4">
                                                <template v-for="service_type in service_types">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in getServicesByServiceType(room.services, service_type.id)">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <td>{{ parseInt(room_service.price) * (1 + parseInt(order.markup)/100) }} Р/м<sup>2</sup></td>
                                                                        <td>{{ priceCount(room_service.pivot.quantity, room_service.price) * (1 + parseFloat(order.markup)/100) }} Р</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template> -->

                                        </div>
                                    </template>

                                    <!-- <div class="row bg py-4">
                                        <div class="col-12 d-flex align-items-center justify-content-end">
                                             <div class="col-2">
                                                <select class="form-control"
                                                        v-model="selected_id"
                                                        @change="percentage = null"
                                                        >
                                                        <option value=null>Выберите</option>
                                                        <option value=1>Скидка</option>
                                                        <option value=2>Наценка</option>
                                                </select>
                                            </div>
                                            <div class="col-1">
                                                <input type="number"
                                                       class="form-control"
                                                       placeholder="%"
                                                       min="0"
                                                       v-model="percentage"
                                                       @change="updateOrderDiscountOrMarkup()"
                                                       >
                                            </div>

                                            <h2 class="main-subtitle px-15">
                                                Итого: {{ order.price }} Р
                                            </h2>

                                        </div>
                                    </div>

                                    <div class="row ml-3 my-4">
                                        <textarea class="col-6"
                                                  placeholder="Добавить комментарий к смете"
                                                  v-model="description"
                                                  @change="orderUpdate()"
                                                  >
                                        </textarea>
                                    </div> -->

                                </template>
                            </template>

                            <!-- <template v-if="order.discount === null && order.markup === null">
                                <template v-if="order.rooms">
                                    <template v-for="(room, index) in order.rooms">
                                        <div class="projects__information">
                                            <div class="px-15 pb-3">
                                                <template v-if="room.description">
                                                    <template v-if="!show">
                                                        <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName()">
                                                            {{ room.description }}
                                                        </h2>
                                                    </template>
                                                    <template v-else>
                                                        <div class="row" style="padding-top: 30px;">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           :placeholder="room.description"
                                                                           v-model="descriptions[room.id]"
                                                                           @change="updateDescription(room.id)"
                                                                           >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template v-else>
                                                    <template v-if="!show">
                                                        <h2 class="main-subtitle main-subtitle--room" @click="changeRoomName()">
                                                            {{ room.room_type.type }}
                                                        </h2>
                                                    </template>
                                                    <template v-else>
                                                        <div class="row" style="padding-top: 30px;">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           :placeholder="room.room_type.type"
                                                                           v-model="descriptions[room.id]"
                                                                           @change="updateDescription(room.id)"
                                                                           >
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </template>
                                                </template>

                                            </div>

                                            <template v-if="room.room_type_id === 1">
                                                <div class="projects__desc col-8 d-flex justify-content-between px-0 align-items-center pt-3">
                                                    <div class="projects__desc-item">Общая площадь: {{ room.area }} м<sup>2</sup></div>
                                                    <div class="projects__desc-item">Высота потолка: {{ room.height }} м</div>
                                                    <div class="projects__desc-item">Площадь стен: {{ room.wall_area }} м<sup>2</sup></div>
                                                    <div class="projects__desc-item">Периметр: {{ room.perimeter }}</div>
                                                </div>

                                                <template v-for="service_type in service_types.slice(0, 3)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in getServicesByServiceType(room.room_services, service_type.id)">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>

                                                                        <td>{{ room_service.price }} Р/м<sup>2</sup></td>
                                                                        <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>


                                            <template v-if="room.room_type_id === 2">
                                                <template v-for="service_type in service_types.slice(3, 4)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in room.services">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <template v-if="room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                        </template>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>


                                            <template v-if="room.room_type_id === 3">
                                                <template v-for="service_type in service_types.slice(4, 5)">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in room.services">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <template v-if="room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                        </template>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>

                                            <template v-if="room.room_type_id === 4">
                                                <template v-for="service_type in service_types">
                                                    <div class="row bg px-15">

                                                        <div class="main-subtitle main-subtitle--fz col-12 pt-4">
                                                            {{ service_type.name }}
                                                        </div>

                                                        <div class="col-12 px-0">

                                                            <table class="table table-hover">

                                                                <tbody>
                                                                    <tr v-for="room_service in getServicesByServiceType(room.services, service_type.id)">
                                                                        <th scope="row" class="w-50">
                                                                            {{ room_service.name }}
                                                                        </th>
                                                                        <td>{{ room_service.pivot.quantity }} м<sup>2</sup></td>
                                                                        <template v-if="room_service.can_be_discounted">
                                                                            <td>{{ parseInt(room_service.price) }} Р/м<sup>2</sup></td>
                                                                            <td>{{ priceCount(room_service.pivot.quantity, room_service.price) }} Р</td>
                                                                        </template>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </template>
                                            </template>

                                        </div>
                                    </template>

                                    <div class="row bg py-4">
                                        <div class="col-12 d-flex align-items-center justify-content-end">
                                             <div class="col-2">
                                                <select class="form-control"
                                                        v-model="selected_id"
                                                        @change="percentage = null"
                                                        >
                                                        <option value=null>Выберите</option>
                                                        <option value=1>Скидка</option>
                                                        <option value=2>Наценка</option>
                                                </select>
                                            </div>
                                            <div class="col-1">
                                                <input type="number"
                                                       class="form-control"
                                                       placeholder="%"
                                                       min="0"
                                                       v-model="percentage"
                                                       @change="updateOrderDiscountOrMarkup()"
                                                       >
                                            </div>

                                            <h2 class="main-subtitle px-15">
                                                Итого: {{ order.price }} Р
                                            </h2>

                                        </div>
                                    </div>

                                    <div class="col-12 my-4">
                                        <textarea class="col-12"
                                                  placeholder="Добавить комментарий к смете"
                                                  v-model="description"
                                                  @change="orderUpdate()"
                                                  >
                                        </textarea>
                                    </div>

                                </template>
                            </template> -->
                        </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Service from './Partials/Service'

    export default {
        data () {
            return {
                order: [],
                square: 0,
                contract: null,
                client_name: null,
                description: '',
                percentage: null,
                managers: [],
                manager_phones: [],
                manager_id: 1,

                withMaterials: false,
                service_types: [],

                show: false,
                descriptions: [],

                selected_id: null,

                room_services: [],

            }
        },

        components: {
            Service
        },

        mounted () {
            this.getOrder()
            this.getManagers()
        },

        methods: {
            getOrder () {
                return axios.get(`/api/orders/${this.$route.params.id}`)
                            .then(response => {
                                this.order = response.data
                                this.contract = this.order.contract
                                this.manager_id = this.order.manager_id
                                this.client_name = this.order.client_name
                                this.description = this.order.description

                                if (this.order.discount) {
                                    this.selected_id = "1"
                                    this.percentage = this.order.discount
                                }
                                if (this.order.markup) {
                                    this.selected_id = "2"
                                    this.percentage = this.order.markup
                                }

                                this.square = 0
                                this.order.rooms.forEach(room => {
                                    this.square += parseInt(room.area)
                                    this.room_services[room.id] = _.groupBy(room.room_services, 'service_type_id')

                                })
                                console.log(this.room_services);
                            })
            },

            getManagers() {
                return axios.get(`/api/managers`)
                            .then(response => {
                                this.managers = response.data
                                response.data.forEach(item => {
                                    this.manager_phones[item.id] = item.phone
                                })
                            })
            },

            orderUpdate () {
                axios.patch(`/api/orders/${this.order.id}/update`, {
                    'manager_id': this.manager_id,
                    'contract': this.contract,
                    'client_name': this.client_name,
                    'description': this.description,
                    'discount': this.discount
               })
           },

           updateOrderDiscountOrMarkup () {
               if (this.selected_id === "1") {
                   axios.patch(`/api/orders/${this.order.id}/discount_or_markup/update`, {
                       'discount': this.percentage,
                       'markup': null
                   }).then(response => {
                       this.getOrder()
                   })
               }

               if (this.selected_id === "2") {
                   axios.patch(`/api/orders/${this.order.id}/discount_or_markup/update`, {
                       'discount': null,
                       'markup': this.percentage
                   }).then(response => {
                       this.getOrder()
                   })
               }

           },

           priceCount (quantity, price) {
               return new Intl.NumberFormat().format(quantity * price)
           },

           changeRoomName (id) {
               this.show = !this.show
           },

           updateDescription (id) {
               axios.patch(`/api/orders/${this.$route.params.id}/rooms/${id}/update_description`, {
                  'description': this.descriptions[id]
              }).then(response => {
                  window.location.reload(true)
              })

           },

           exportFile () {
               let answer = prompt("PDF or Excel", "PDF")

               if (answer.toLowerCase() === 'pdf') {
                   if (this.withMaterials) {
                       axios.get(`/api/orders/${this.order.id}/export/pdf/materials`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                            })
                   } else {
                       axios.get(`/api/orders/${this.order.id}/export/pdf`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                            })
                   }
               }
               if (answer.toLowerCase() === 'excel') {
                   if (this.withMaterials) {
                       axios.get(`/api/orders/${this.order.id}/export/excel/materials`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                                console.log(response);
                            })
                   } else {
                       axios.get(`/api/orders/${this.order.id}/export/excel`)
                            .then(response => {
                                window.open(`${response.data.url}/storage/${response.data.data}`)
                            })
                   }
               }
           },



        },


    }
</script>

<style scoped lang="scss">
    $main-color: #00A4D1;
    $ccc: #CCCCCC;
    .create {
        &__features {
            display: flex;
            align-items: center;

            &__name {
           font-weight: bold;
           font-size: 20px;
           display: inline-block;
           color: $ccc;
           border: none;
           cursor: pointer;
           &:hover,
           &.active {
               color: $main-color;
               border-bottom: 3px solid $main-color;
               transition-duration: 0.3s;
           }
       }
        }
    }

    a:hover {
        text-decoration: none;
    }

    .btn-primary {
        background-color: #00A4D1;
        border-radius: .25rem;
        border: none;
        color: #fff;
        cursor: pointer;
    }
    .form-control {
    border-radius: 0;
    &::placeholder {
        opacity: 0.3;
    }
    &:focus,
    &:hover {
        box-shadow: none;
        border-color: #000;
    }
}

.form-group {
    .form-control {
        border-radius: 0;
        font-size: 0.875rem;
        &:focus {
            border-color: #000;
            box-shadow: none;
        }
    }
}
textarea {
     resize: none;
     height:175px;
}

   .small-case {
    font-size: 1rem;
  }
  .main-subtitle--room {
    padding-top: 75px;
  }
</style>
