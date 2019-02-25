<template>
    <table class="table table-hover">
      <tbody>
        <tr @click="show = !show">
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

        <File v-if="show && folder.order_uploads.length !== 0"
              v-for="upload in folder.order_uploads"
              :upload="upload"
              :key="'upload-' + upload.id"
              />
      </tbody>
    </table>
</template>

<script>
    import File from './Files/File'

    export default {
        props: ['folder'],

        data () {
            return {
                show: false
            }
        },

        components: {
            File
        },

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
tr {
    cursor: pointer;
    &:hover {
        cursor: pointer;
    }
}

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
