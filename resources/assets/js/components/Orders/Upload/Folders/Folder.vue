<template>
    <table class="table table-hover">
      <tbody>
        <tr>
          <td>{{ folder.order_uploads.filter(row => row.type === 'photo').length }} фото</td>
          <td>{{ folder.order_uploads.filter(row => row.type === 'doc').length }} док</td>
          <td>Дата съёмки {{ folder.name }}</td>
          <td>{{ filteredDate }}</td>
          <td>
            <button @click="deleteFolder()" class="add-button add-button--remove d-flex align-items-center" title="Удалить">
                  <img src="/img/del.svg" alt="add-button">
                  <div class="remove-materials ml-1">
                    Удалить
                  </div>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
</template>

<script>
    export default {
        props: ['folder'],

        methods: {
            deleteFolder () {
                if (confirm('Удалить ?')) {
                    axios.delete(`/api/orders/${this.$route.params.id}/folders/${this.folder.id}/destroy`)
                         .then(() => {
                             this.$emit('deleted-folder')
                         })
                }
            }
        },

        computed: {
            filteredDate () {
                return moment(this.folder.created_at).format('DD-MM-YYYY')
            }
        }
    }
</script>

<style lang="scss" scoped>
.add-button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  &:focus {
    outline: none;
  }
  img {
    width: 35px;
    border-radius: 50%;
    &:hover {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
  }
  &--remove {
    color: #ccc;
    &:hover {
      color: #00A4D1;
    }
    img {
      width: 15px;
    }
  }
}
</style>
