<template>
    <div class="row align-items-center">
        <label class="col-md-4 mb-0 d-flex align-items-center">
            <div class="form-check custom-control d-flex edit-show">
                <input class="form-check-input"
                       type="checkbox"
                       :id="'service-' + room_service.id"
                       :checked="true"
                       @click=""
                       >

                <label class="form-check-label"
                       :for="'service-' + room_service.id"
                       >
                       {{ room_service.service.name }}
                </label>

                <router-link class="ml-auto edit" :to="{ name: 'service-material', params: { service_id: room_service.id } }">
                        Ред.
                </router-link>
            </div>
        </label>

        <div class="col-md-8 pr-0">
          <div class="form-group form-group--margin d-flex align-items-center">
              <!-- <input type="number"
                     class="form-control w-85"
                     placeholder="Кол-во"
                     min="0"
                     v-model="service_quantities[room_service_id]"
                     @change="linkServicesToRoom()"
                     > -->

              <!-- <div class="inputs-caption col-md-2">
                  {{ service_units[room_service_id] }}
              </div> -->

              <!-- <input  type="number"
                      class="form-control w-85"
                      min="0"
                      disabled
                      :value="service_prices[room_service_id]"
                      > -->

              <!-- <div class="inputs-caption col-md-2">
                  Р/{{ service_units[room_service_id] }}
              </div> -->

              <!-- <template v-if="room_service_markups[room_service_id]">
                  <div class="form-group__calc w-85">
                      {{ parseInt(service_prices[room_service_id] * service_quantities[room_service_id] * (1 + (parseInt(room_service_markups[room_service_id])/100))) }} P
                  </div>
              </template>
              <template v-else>
                  <div class="form-group__calc w-85">
                      {{ getServiceSummary(room_service_id) }} P
                  </div>
              </template> -->


              <!-- <template v-if="service_can_be_deleted[room_service_id]">
                  <div class="col-md-1">
                      <button @click="deleteService(room_service_id)" class="add-button add-button--remove d-flex align-items-center" title="Удалить материал">
                          <img src="/img/del.svg" alt="add-button">
                      </button>
                  </div>
              </template>
              <template v-else>
                  <div class="col-md-1">
                      &nbsp;
                  </div>
              </template> -->

              <!-- <div class="col-md-2">
                  <input type="number"
                         class="form-control w-85"
                         min="0"
                         placeholder="Наценка"
                         v-model="room_service_markups[room_service_id]"
                         @change="updateRoomServiceMarkup()"
                         >
              </div> -->

              <!-- <div class="col-md-auto">
                  <template v-if="room.order">
                      <router-link :to="{ name: 'actual-material', params: { id: room.order.id, room_id: room.id, service_id: room_service_id }}">
                          <button class="add-button " title="Добавить материалы">
                              <img src="/img/plus-circle.svg" alt="add-button">
                          </button>
                      </router-link>
                  </template>
              </div> -->

          </div>
        </div>

      <!-- <div class="row col-12" v-for="(material) in room_service_materials[room_service_id]">
        <div class="col-4 pl-5 mb-3">
          <div class="subtitle-list">
            <div class="subtitle-list__item">
                {{ material.name }}
            </div>
          </div>
        </div>
        <template v-if="material.pivot.rate">
            <div class="col-8">
              <div class="d-flex align-items-center">
                <div class="col-4" style="margin-left:163px"></div>
                <div class="form-group__calc col-md-2">
                    {{ getMaterialSummary(material.pivot.rate, material.quantity, material.price, service_quantities[room_service_id]) }} Р
                </div>
              </div>
            </div>
        </template>
      </div> -->

    </div>
</template>

<script>
    export default {
        props: ['service_type_id', 'room_service'],

        created () {
            // console.log(this.room_service);
        }
    }
</script>

<style scoped lang="scss">
.edit-show:hover {
  .edit {
    transition: 0.5s;
    opacity:1;
  }
}
.edit {
    opacity: 0;
          color: #00A4D1;
    &:hover {
      cursor: pointer;
    }
}

</style>
