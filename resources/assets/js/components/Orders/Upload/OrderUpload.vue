<template>
    <div>
      <basic-header></basic-header>
      <div class="container-fluid px-0">
        <div class="row">
          <navigation></navigation>
          <div class="col-md-10 px-0">
            <div class="create__fixed-top col-10 shadow-light">
              <div class="row align-items-center ">
                <div class="col-md-8">
                  <h4>Загрузить файл</h4>
                </div>
                <div class="col-md-4 text-right d-flex">
                    <button
                            type="button"
                            class="primary-button col-6 ml-auto"
                            @click.prevent="uploadFiles()"
                            >
                        Сохранить
                    </button>
                </div>

              </div>
            </div>

            <UploadBlock />



            <div class="story-text">История загрузок:</div>

            <table class="table table-hover" v-if="folders.length">
              <tbody>
                <tr v-for="folder in folders" :key="folder.id">
                  <td>{{ folder.order_uploads.filter(row => row.type === 'photo').length }} фото</td>
                  <td>{{ folder.order_uploads.filter(row => row.type === 'doc').length }} док</td>
                  <td>Дата съёмки {{ folder.name }}</td>
                  <td>{{ moment(folder.created_at).format('DD-MM-YYYY') }}</td>
                  <td>
                    <button @click="deleteFolder(folder.id)" class="add-button add-button--remove d-flex align-items-center" title="Удалить">
                          <img src="/img/del.svg" alt="add-button">
                          <div class="remove-materials ml-1">
                            Удалить
                          </div>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

  </div>
</template>

<script>
    import UploadBlock from './partials/UploadBlock'

    export default {
        data () {
            return {
                moment,

                folders: [],
                currentPath: window.location.origin
            }
        },

        components: {
            UploadBlock
        },

        mounted () {
            this.getFolders()
        },

        methods: {
            getFolders () {
                axios.get(`/api/orders/${this.$route.params.id}/folders`)
                     .then(response => {
                         this.folders = response.data
                     })
            },

            uploadFiles () {
              this.$refs.myVueDropzone.processQueue()
              window.location.reload(true)
            },

            deleteFolder (id) {
                axios.delete(`/api/orders/${this.$route.params.id}/folders/${id}/destroy`)
                     .then(() => {
                         this.getFolders()
                     })
            }
        }
    }
</script>

<style lang="scss" scoped>

.container-fluid {
	&.px-0 {
		.row {
			margin-left: 0;
			margin-right: 0;
		}
	}
}

.subtitle {
  color: #314b5f;
}

.badger-accordion {
  &-item {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  padding: 15px;
  &:hover {
    background-color: #00A4D1;
  }
  }
}
.js-badger-accordion-header .-ba-is-active {
  &:hover {
          background-color: #red;
  }

}

.h-200 {
  height: 200px;
}


.accordion-wrapper {
  padding: 0 30px;
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

td {
  &:first-child {
    padding-left: 30px;
  }
}

.story-text {
  padding-left: 30px;
  margin-top: 30px;
  color:  #00A4D1;
  font-weight: bold;
  font-size: 18px;
}

</style>
