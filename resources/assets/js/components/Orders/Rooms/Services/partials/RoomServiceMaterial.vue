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
                  <!-- {{ getMaterialSummary(material.pivot.rate, material.quantity, material.price, service_quantities[room_service_id]) }} Р -->
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

            }
        }
    }
</script>
