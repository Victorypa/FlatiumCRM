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
                    <button v-if="show"
                            type="button"
                            class="primary-button col-6 ml-auto"
                            @click.prevent="uploadFiles()"
                            >
                        Сохранить
                    </button>
                </div>

              </div>
            </div>

            <UploadBlock @created-folder="show = true" />

            <template v-if="folders.length !== 0">
                <div class="story-text">
                    История загрузок:
                </div>

                <Folder v-for="folder in folders"
                        :folder="folder"
                        :key="'folder-' + folder.id"
                        @deleted-folder="getFolders()"
                        />
            </template>

          </div>
        </div>
      </div>

  </div>
</template>

<script>
    import UploadBlock from './partials/UploadBlock'
    import Folder from './Folders/Folder'

    export default {
        data () {
            return {
                show: false,

                folders: [],
                currentPath: window.location.origin
            }
        },

        components: {
            UploadBlock, Folder
        },

        created () {
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
