<template>
    <div class="row align-items-center col-12 py-4 fixed-search">

        <template v-if="service_type_id !== 0">
            <div class="col-12 pr-0" style="margin-bottom: 5em;" :key="'extra_room' + extra_room.id">
              <div class="main-subtitle main-subtitle--fz pt-3 pb-2">
                  {{ getServiceTypeName(service_type_id) }}
              </div>

              <div class="col-md-12 px-0 all-items" v-for="service in filteredServices">

                <div class="row align-items-center">

                  <label class="col-md-4 mb-0">
                      <div class="form-check custom-control d-flex edit-show">
                          <input class="form-check-input"
                                 type="checkbox"
                                 :id="'service-' + service.id"
                                 :checked="extra_room_service_ids.includes(service.id)"
                                 @click="addToExtraRoomServiceId(service.id)"
                                 >

                          <label class="form-check-label"
                                 :for="'service-' + service.id"
                                 >
                                 {{ service.name }}
                          </label>

                          <router-link class="ml-auto edit" :to="{ name: 'service-material', params: { service_id: service.id } }">
                                  Ред.
                          </router-link>
                      </div>
                  </label>

                <div class="col-md-8 pr-0">
                  <div class="form-group form-group--margin d-flex align-items-center">
                    <input type="number"
                           class="form-control w-85"
                           placeholder="Кол-во"
                           min="0"
                           v-model="service_quantities[service.id]"
                           @change="linkExtraServicesToExtraRoom()"
                           >

                    <div class="inputs-caption col-md-2">
                        {{ service.unit.name }}
                    </div>

                    <input type="number"
                           class="form-control w-85"
                           :value="parseInt(service_prices[service.id])"
                           disabled
                           >

                    <div class="inputs-caption col-md-2">
                        Р/{{ service.unit.name }}
                    </div>

                    <div class="form-group__calc w-85">
                        {{ getServiceSummary(service.id) }} P
                    </div>

                    <template v-if="service.can_be_deleted">
                        <div class="col-md-2">
                            <button @click="deleteService(service.id)" class="add-button add-button--remove d-flex align-items-center" title="Удалить материал">
                                <img src="/img/del.svg" alt="add-button">
                                <div class="remove-materials ml-1">
                                  Удалить
                                </div>
                            </button>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-md-2">
                            &nbsp;
                        </div>
                    </template>

                    <template v-if="extra_room_service_ids.includes(service.id)">
                        <router-link class="ml-auto" :to="{ name: 'order-extra-services-materials', params: { id: extra_room.extra_order_act.order.id, extra_order_act_id: extra_room.extra_order_act.id, extra_room_id: extra_room.id, service_id: service.id }}">
                            <div class="col-md-auto px-0 ml-auto">
                                <button class="add-button " title="Добавить материалы">
                                    <img src="/img/plus-circle.svg" alt="add-button">
                                </button>
                            </div>
                        </router-link>
                    </template>
                    <template v-else>
                        <div class="col-md-auto px-0">
                            &nbsp;
                        </div>
                    </template>
                  </div>
                </div>

              </div>
              </div>
            </div>
        </template>

    </div>
</template>
