<template>
    <div>
      <basic-header></basic-header>
      <div class="container-fluid">
        <div class="row">
          <navigation></navigation>
          <div class="col-md-10">

            <div class="col-md-12 px-0">
                <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" class="mp-10"></vue-dropzone>
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
                    url: 'https://httpbin.org/post',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
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
.mp-10 {
    margin-top: 100px;
}
</style>
