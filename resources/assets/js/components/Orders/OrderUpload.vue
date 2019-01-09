<template>
    <div>
      <basic-header></basic-header>
      <div class="container-fluid">
        <div class="row">
          <navigation></navigation>
          <div class="col-md-10">
            <div class="col-md-12 px-0">
                <datepicker class="mp-10"
                            :language="ru"
                            placeholder="Выбрать Дату"
                            v-model="chosenDate"
                            @input="createFolder()"
                            >
                </datepicker>


                <vue-dropzone v-if="chosenDate"
                              ref="myVueDropzone"
                              id="dropzone"
                              :options="dropzoneOptions"
                              class="mp-10">
                </vue-dropzone>
            </div>

            <div class="col-md-12 mp-10" v-if="folders.length">
                <VueFaqAccordion :items="folders" />
            </div>
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
    import VueFaqAccordion from 'vue-faq-accordion'

    export default {
        data () {
            return {
                ru,
                chosenDate: null,

                dropzoneOptions: {
                    url: `/api/orders/${this.$route.params.id}/uploads/store`,
                    paramName: 'uploadedFile',
                    thumbnailWidth: 300,
                    addRemoveLinks: true,
                    maxFilesize: 3.0,
                    dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> Документы или Фотки"
                },

                folders: []
            }
        },

        components: {
            vueDropzone: vue2Dropzone,
            Datepicker, VueFaqAccordion
        },
        mounted () {
            this.getFolders()
        },

        methods: {
            getFolders () {
                axios.get(`/api/orders/${this.$route.params.id}/folders`)
                     .then(response => {
                         response.data.forEach(folder => {
                             this.folders.push({
                                 title: folder.name,
                                 value: `
                                 <div class="row">
                                    <div class="col-md-6">
                                        <h4>Фото</h4>
                                        <table class="table">
                                            <thead>
                                                <th>Название</th>
                                                <th>Дата загрузки</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                    3
                                                    </td>
                                                    <td>
                                                        4
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Документы</h4>
                                        <table class="table">
                                            <thead>
                                                <th>Название</th>
                                                <th>Дата загрузки</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                    1
                                                    </td>
                                                    <td>
                                                        2
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                 </div>
                                 `,
                                 category: folder.name
                             })
                         })

                     })
            },

            createFolder () {
                axios.post(`/api/orders/${this.$route.params.id}/folders/store`, {
                    'date': moment(this.chosenDate).format('DD-MM-YYYY')
                }).then(response => {
                    this.getFolders()
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
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
</style>
