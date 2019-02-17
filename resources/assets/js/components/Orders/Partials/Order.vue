<template>
    <tr>
        <td>
            <input type="checkbox"
                   :checked="order.processing"
                   @click="updateStatus(order)"
                   >
        </td>
      <td>
        <div class="form-check custom-control checkbox">

          <label :for="'order-' + this.order.id">
              <router-link v-if="order.rooms.length" :to="{ name: 'room-show', params: { id: order.id, room_id: getFirstRoomId } }">
                  {{ orderName }}
              </router-link>
              <router-link v-else :to="{ name: 'order-show', params: { id: order.id } }">
                  {{ orderName }}
              </router-link>
              <button class="add-button add-button--remove d-flex align-items-center"
                      v-if="order.isCopy"
                      @click="deleteOrder(order)"
                      >
                  <img src="/img/del.svg" alt="add-button">
              </button>
          </label>
        </div>
      </td>


      <td class="d-flex justify-content-end">
          <div class="pr-30">
               {{ humanDate }}
          </div>

          <!-- <div class="pl-30">
              <a class="estimates__dropdown-img estimates__dropdown-img--rotate" href="." data-toggle="dropdown" data-html="true"
                title="Действия">
                <img src="/img/dropdown-toggle.svg" alt="export">
              </a>
          <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item text-color"
                @click="createFinishedOrderAct(order.id)">
                Создать акт
            </a>
              <a class="dropdown-item text-color"
                 @click="createExtraOrderAct(order.id)">
                  Создать доп.ведомость
              </a>

              <router-link class="dropdown-item text-color" :to="{ name: 'order-finance', params: { id: order.id} }">
                  Баланс
              </router-link>

              <router-link class="dropdown-item text-color" :to="{ name: 'order-step', params: { id: order.id} }">
                  График работ
              </router-link>

              <router-link class="dropdown-item text-color" :to="{ name: 'order-upload', params: { id: order.id} }">
                  Загрузить файлы
              </router-link>
          </div>
        </div> -->
      </td>
    </tr>
</template>

<script>
    export default {
        props: ['order'],

        methods: {
            deleteOrder (order) {
                if (confirm('Удалить ?')) {
                    axios.delete(`/api/orders/${this.order.id}/destroy`)
                         .then(response => {
                             this.$emit('deleted-copy')
                         })
                }
            },

            updateStatus (order) {
                axios.patch(`/api/orders/${this.order.id}/update_status`, {
                    'processing': !this.order.processing
                })
            }
        },

        computed: {
            orderName () {
                return this.order.address != null ? this.order.address : this.order.order_name.substring(0, 25)
            },

            getFirstRoomId () {
                return this.order.rooms.length != 0 ? this.order.rooms[this.order.rooms.length - 1].id : null
            },

            humanDate () {
                return moment(new Date(this.order.created_at)).format("DD-MM-YYYY")
            }
        }
    }
</script>

<style scoped lang="scss">
table {
  tr:hover {

   .show-button {
     opacity:1;
   }
   .add-button {
     opacity: 1;
   }
  }
  .add-button {
    opacity: 0;
  }
  .form-check-label {
    display: flex;
  }
}

.add-button img {
  width: 11px;
  cursor: pointer;
}
</style>
