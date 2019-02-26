<template>
    <div class="row col-12 mt-3">

          <div class="col-6 pl-5 mb-3">
            <div class="subtitle-list">
              <div class="subtitle-list__item">
                  {{ material.name }}
              </div>
            </div>
          </div>

          <div class="col-6">
            <div class="d-flex align-items-center">
              <div class="form-group__calc col-md-2">
                  {{ filteredMaterialPrice }} Р
              </div>
            </div>
          </div>
    </div>
</template>

<script>
    export default {
        props: ['material', 'quantity'],

        computed: {
            filteredMaterialPrice () {
                return new Intl.NumberFormat('ru-Ru').format(
                    parseInt(Math.ceil((this.material.pivot.rate * this.quantity)/this.material.quantity) * this.material.price)
                )
            }
        }
    }
</script>
