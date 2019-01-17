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
                    <button v-if="chosenDate"
                            type="button"
                            class="primary-button col-6 ml-auto"
                            @click.prevent="uploadFiles()"
                            >
                        Сохранить
                    </button>
                </div>

              </div>
            </div>

            <div class="col-md-12 mp-10">

              <div class="row">
                <div class="col-md-12">
                  <vue-dropzone
                                ref="myVueDropzone"
                                id="dropzone"
                                :options="dropzoneOptions"
                                class="mp-10">
                  </vue-dropzone>
                </div>
              </div>

              <div class="row mp-5">
                <div class="col-md-4">
                  <datepicker :language="ru"
                              placeholder="Выбрать Дату"
                              v-model="chosenDate"
                              @input="createFolder()"
                              >
                  </datepicker>
                </div>
              </div>
            </div>

            <!-- <div class="col-md-12 mp-5 accordion-wrapper" v-if="folders.length">
                <badger-accordion>
                    <badger-accordion-item v-for="folder in folders" :key="'folder-' + folder.id">
                        <template slot="header">
                            <a>{{ folder.name }}</a>
                        </template>

                        <template slot="content" v-if="folder.order_uploads">
                            <div class="collapse show">
                                 <div class="card-body">
                                   <div class="row">
                                       <div class="col-md-6" v-if="folder.order_uploads.filter(row => row.type === 'photo').length">
                                           <h5>Фото</h5>
                                           <ul class="list-group">
                                              <li class="list-group-item" v-for="upload in folder.order_uploads.filter(row => row.type === 'photo')" :key="'upload-' + upload.id">
                                                  <a :href="currentPath + '/storage/' + folder.name + '/photos/' + upload.path" target="_blank">
                                                      {{ upload.path }}
                                                  </a>
                                              </li>
                                          </ul>
                                       </div>
                                       <div class="col-md-6" v-if="folder.order_uploads.filter(row => row.type === 'doc').length">
                                           <h5>Документы</h5>
                                           <ul class="list-group">
                                              <li class="list-group-item" v-for="upload in folder.order_uploads.filter(row => row.type === 'doc')" :key="'upload-' + upload.id">
                                                  <a :href="currentPath + '/storage/' + folder.name + '/docs/' + upload.path" target="_blank">
                                                      {{ upload.path }}
                                                  </a>
                                              </li>
                                          </ul>
                                       </div>
                                   </div>
                                 </div>
                             </div>
                        </template>
                    </badger-accordion-item>
                </badger-accordion>
            </div> -->

            <div class="story-text">История загрузок:</div>

            <table class="table table-hover" v-if="folders.length">
              <tbody>
                <tr v-for="folder in folders" :key="folder.id">
                  <td>{{ folder.order_uploads.filter(row => row.type === 'photo').length }} фото </td>
                  <td>Дата съёмки {{ folder.name }}</td>
                  <td>{{ folder.created_at }}</td>
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
            <span v-else>Загрузок нет</span>
          </div>
        </div>
      </div>

  </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import Datepicker from "vuejs-datepicker"
    import { ru } from "vuejs-datepicker/dist/locale"

    export default {
        data () {
            return {
                ru,
                chosenDate: null,

                dropzoneOptions: {
                    url: `/api/orders/${this.$route.params.id}/uploads/store`,
                    paramName: 'uploadedFile',
                    autoProcessQueue: false,
                    thumbnailWidth: 100,
                    addRemoveLinks: true,
                    maxFilesize: 10.0,
                    dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> Документы или Фотки"
                },

                folders: [],
                currentPath: window.location.origin
            }
        },

        components: {
            vueDropzone: vue2Dropzone,
            Datepicker
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

            createFolder () {
                axios.post(`/api/orders/${this.$route.params.id}/folders/store`, {
                    'date': moment(this.chosenDate).format('DD-MM-YYYY')
                }).then(response => {
                    this.getFolders()
                })
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

.vue-dropzone {
  box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(0, 0, 0, 0.1);
border-radius: 4px;
}

.dropzone-custom-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.dropzone-custom-title {
  margin-top: 0;
  color: #00b782;
}

.subtitle {
  color: #314b5f;
}

.mp-10 {
    margin-top: 100px;
}

.mp-5 {
    margin-top: 50px;
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
