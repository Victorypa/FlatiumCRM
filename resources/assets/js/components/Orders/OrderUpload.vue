<template>
    <div>
      <basic-header></basic-header>
      <div class="container-fluid">
        <div class="row">
          <navigation></navigation>
          <div class="col-md-10">

            <div class="col-md-12 px-0">
                <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" class="mp-10">

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

    export default {
        data () {
            return {
                dropzoneOptions: {
                    url: `/api/orders/${this.$route.params.id}/upload/store`,
                    thumbnailWidth: 300,
                    addRemoveLinks: true,
                    maxFilesize: 2.0,
                    dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> Документы или Фотки",
                    headers: { "My-Awesome-Header": "header value" }
                }
            }
        },

        components: {
            vueDropzone: vue2Dropzone
        },
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
