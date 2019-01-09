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

              <table class="table mp-10">
                <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Название</th>
                      <th scope="col">Дата Загрузки</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>1</td>
                      <td>Название</td>
                      <td>Имя</td>
                  </tr>
                </tbody>
              </table>
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
                }
            }
        },

        components: {
            vueDropzone: vue2Dropzone,
            Datepicker
        },

        methods: {
            createFolder () {
                axios.post(`/api/orders/${this.$route.params.id}/folders/store`, {
                    'date': moment(this.chosenDate).format('DD-MM-YYYY')
                }).then(response => {
                    console.log(response);
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
