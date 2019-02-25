<template>
    <div class="col-md-12 mp-10">

      <div class="row">
          <div class="col-md-12">
            <datepicker :language="ru"
                        placeholder="Выбрать дату для создания папки"
                        v-model="chosenDate"
                        @input="createFolder()"
                        >
            </datepicker>
          </div>

        <div class="col-md-12">
          <vue-dropzone ref="myVueDropzone"
                        id="dropzone"
                        :options="dropzoneOptions"
                        class="mp-10">
          </vue-dropzone>
        </div>
      </div>

      <div class="row mp-5">
        <div class="col-md-6">
                <datepicker :language="ru"
                            placeholder="Выбрать дату"
                            v-model="chosenDate"
                            @input="createFolder()"
                            />
        </div>

        <div class="col-md-6">
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
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import Datepicker from "vuejs-datepicker"
    import { ru } from "vuejs-datepicker/dist/locale"

    export default {
        components: {
            vueDropzone: vue2Dropzone,
            Datepicker
        },

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
                    maxFilesize: 20.0,
                    dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> Документы или Фотки"
                }
            }
        },

        methods: {
            createFolder () {
                axios.post(`/api/orders/${this.$route.params.id}/folders/store`, {
                    'date': moment(this.chosenDate).format('DD-MM-YYYY')
                }).then(response => {
                    this.$emit('created-folder')
                })
            },

            uploadFiles () {
              this.$refs.myVueDropzone.processQueue()
              setTimeout(() => {
                   window.location.reload(true)
              }, 3000)
            }
        }
    }
</script>

<style scoped lang="scss">
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

.mp-10 {
    margin-top: 100px;
}

.mp-5 {
    margin-top: 50px;
}
</style>
