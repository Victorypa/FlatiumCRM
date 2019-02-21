<template>
    <div class="row align-items-center">
        <label class="col-md-3 mb-0 d-flex align-items-center">
            <div class="form-check custom-control d-flex edit-show"
                 >
                <input class="form-check-input"
                       type="checkbox"
                       :id="'extra-room-service-' + extra_room_service.id"
                       :checked="true"
                       @click="removeService()"
                       >

                <label class="form-check-label"
                       :for="'extra-room-service-' + extra_room_service.id"
                       >
                       {{ extra_room_service.service.name }}
                </label>

                <router-link class="ml-auto edit" :to="{ name: 'service-material', params: { service_id: extra_room_service.service_id } }">
                        Ред.
                </router-link>
            </div>
        </label>

        <!-- <div class="col-md-8 pr-0">
          <div class="form-group form-group--margin d-flex align-items-center">
              <input type="number"
                     class="form-control w-85 col-md-1"
                     placeholder="Кол-во"
                     min="0"
                     v-model="room_service.quantity"
                     @change="updateQuantity()"
                     >

              <div class="inputs-caption col-md-1">
                  {{ room_service.unit.name }}
              </div>

              <input  type="number"
                      class="form-control w-85 col-md-1"
                      min="0"
                      disabled
                      :value="room_service.service.price"
                      >

              <div class="inputs-caption col-md-2">
                  Р/{{ room_service.unit.name }}
              </div>

              <div class="form-group__calc w-85 col-2">
                  {{ servicePrice }} Р
              </div>


              <div class="col-md-1">
                  <button class="add-button add-button--remove d-flex align-items-center"
                          v-if="room_service.service.can_be_deleted"
                          @click.prevent="deleteService()"
                          >
                      <img src="/img/del.svg" alt="add-button">
                  </button>
              </div>

              <div class="col-md-2">
                  <input type="number"
                         v-if="checkServiceMarkup"
                         class="form-control w-85"
                         min="0"
                         placeholder="Наценка"
                         v-model="room_service.markup"
                         @change="updateMarkup()"
                         >
              </div>

              <div class="col-md-auto">
                  <router-link :to="{ name: 'actual-material', params: { id: room_service.room.order_id, room_id: room_service.room_id, service_id: room_service.id }}">
                      <button class="add-button " title="Добавить материалы">
                          <img src="/img/plus-circle.svg" alt="add-button">
                      </button>
                  </router-link>
              </div>
          </div>
        </div> -->

      <!-- <div class="row col-12"
           v-if="room_service.materials.length !== 0"
           v-for="material in room_service.materials"
           :key="material.id"
           >
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
        props: ['extra_room_service'],

        created () {

        }
    }
</script>
