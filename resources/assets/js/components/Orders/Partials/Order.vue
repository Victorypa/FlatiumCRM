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
              <router-link :to="{ name: 'order-panel', params: { id: order.id } }">
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
