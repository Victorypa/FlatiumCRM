<template>
    <tr :class="{ 'income-color': financeType ? true : false }">
      <td class="pl-4">
          {{ financeType ? '+' : '-' }}{{ finance.price }}
      </td>
      <td>{{ finance.reason }}</td>
      <td>{{ filteredInputedAt }}</td>
      <td>
          <button @click="deleteFinance()" class="add-button add-button--remove d-flex align-items-center">
                <img src="/img/del.svg" alt="add-button">
                <div class="remove-materials ml-1">
                  Удалить
                </div>
          </button>
      </td>
      <td>
        <div class="form-check custom-control checkbox">
          <input class="form-check-input check"
                 :id="'finance-' + finance.id"
                 type="checkbox"
                 :checked="finance.can_be_showed"
                 @click="updateFinance()"
                 >
          <label class="form-check-label" :for="'finance-' + finance.id">
            показывать
          </label>
        </div>
      </td>
      <td>&nbsp;</td>
    </tr>
</template>

<script>
    export default {
        props: ['finance'],

        methods: {
            updateFinance () {
              axios.patch(`/api/orders/${this.$route.params.id}/finance/${this.finance.id}/update`, {
                'can_be_showed': this.finance.can_be_showed ? false : true
              })
            },

            deleteFinance () {
                if (confirm('Удалить ?')) {
                    axios.delete(`/api/orders/${this.$route.params.id}/finance/${this.finance.id}/delete`)
                         .then(response => {
                             this.$emit('finance-changed')
                         })
                }
            },
        },

        computed: {
            filteredInputedAt () {
                return moment(new Date(this.finance.inputed_at)).format("DD-MM-YYYY");
            },

            financeType () {
                return this.finance.finance_type === 'income'
            }
        }
    }
</script>

<style scoped>
    .income-color {
        background-color: #DEFFE8;
    }
</style>
