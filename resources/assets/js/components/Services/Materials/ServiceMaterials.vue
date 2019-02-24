<template>
    <section class="create-floor-work">
        <basic-header></basic-header>
      <div class="container-fluid">
        <div class="row">

            <navigation></navigation>

          <div class="col-md-10 bg px-0">
            <div class="container-fluid px-0">

                <ServiceDetail v-if="service.length !== 0"
                              :service="service"
                              />

              <div class="row create-floor-work__content px-15">
                  <div class="col-10">
                      <div class="input-group">
                        <input class="form-control py-2"
                               placeholder="Введите навание материала"
                               v-model="searchQuery"
                               @change="getMaterials()"
                               >
                      </div>
                  </div>
                  <div class="col-2">
                      <button type="button"
                              class="btn btn-link"
                              @click="searchQuery = ''"
                              >
                          Чистить
                      </button>
                  </div>
              </div>

              <div class="row pt-4">
                  <AddMaterial @added-material="getService()" />

                  <ServiceMaterial v-if="service.materials.length !== 0 && material_units.length !== 0"
                                   v-for="material in service.materials"
                                   :material="material"
                                   :material_units="material_units"
                                   :key="material.id"
                                   />

                  <Material v-if="materials.length !== 0 && searchQuery !== ''"
                            v-for="material in materials"
                            :material="material"
                            :material_units="material_units"
                            :key="material.id"
                            />
              </div>

            </div>

          </div>
        </div>

      </div>

    </section>
</template>

<script>
    import ServiceDetail from './partials/ServiceDetail'
    import AddMaterial from './partials/AddMaterial'
    import Material from './partials/Material'
    import ServiceMaterial from './partials/ServiceMaterial'

    export default {
        components: {
            ServiceDetail, AddMaterial,
            Material, ServiceMaterial
        },

        data () {
            return {
                service: [],
                materials: [],
                material_units: [],

                service_material_ids: [],

                searchQuery: ""
            }
        },

        created () {
            this.getService()
            this.getMaterialUnits()
        },

        methods: {
            getService () {
                return axios.get(`/api/services/${this.$route.params.service_id}`)
                            .then(response => {
                                this.service = response.data

                                this.service.materials.forEach(row => {
                                    this.service_material_ids.push(row.id)
                                })
                            })
            },

            getMaterials () {
                return axios.get(`/api/materials/search`, {
                    params: { 'searchQuery': this.searchQuery }
                }).then(response => {
                    this.materials = response.data.materials.filter(row => {
                        return this.service_material_ids.indexOf(row.id) < 0
                    })
                })
            },

            getMaterialUnits () {
                if (localStorage.getItem('material_units')) {
                    this.material_units = JSON.parse(localStorage.getItem('material_units'))
                } else {
                    return axios.get(`/api/material_units`).then(response => {
                        localStorage.setItem('material_units', JSON.stringify(response.data))
                        this.material_units = response.data
                    })
                }
            }
        }
    }
</script>

<style scoped lang="scss">
$main-color: #00A4D1;

input:required:valid {
    border-color: #495057 !important;
}

.main-caption {
  &::after {
    display: none;
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
       color: $main-color;
     }
     img {
       width: 15px;

     }
   }
 }

 .service-input {
  &--height {
    line-height: 37px;
  }
}

.main-caption img, .main-subtitle img {
   width: 16px;
   cursor: pointer;
 }
</style>
