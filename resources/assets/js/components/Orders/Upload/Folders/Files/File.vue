<template>
    <tr v-if="show">
        <th></th>
        <th>
            <a :href="uploadPath" target="_blank">
                {{ upload.path }}
            </a>
        </th>
        <th></th>
        <th>{{ filteredDate }}</th>
        <th>
            <button @click="deleteFile()" class="add-button add-button--remove d-flex align-items-center" title="Удалить">
                  <img src="/img/del.svg" alt="add-button">
                  <div class="remove-materials ml-1">
                    Удалить
                  </div>
            </button>
        </th>
    </tr>
</template>

<script>
    export default {
        props: ['upload', 'folder'],

        data () {
            return {
                show: true
            }
        },

        methods: {
            deleteFile () {
                axios.delete(`/api/orders/${this.$route.params.id}/uploads/${this.upload.id}/destroy`)
                     .then(response => {
                         this.show = !this.show
                     })
            }
        },

        computed: {
            filteredDate () {
                return moment(this.upload.created_at).format('DD-MM-YYYY')
            },

            uploadPath () {
                if (this.upload.type === 'doc') {
                    return `/storage/${this.folder.name}/docs/${this.upload.path}`
                }

                if (this.upload.type === 'photo') {
                    return `/storage/${this.folder.name}/photos/${this.upload.path}`
                }
            }
        }
    }
</script>

<style scoped lang="scss">
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
