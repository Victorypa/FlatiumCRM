<template>
    <div class="projects">
        <basic-header></basic-header>
        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 mt-5">
                    <div class="col-2 mt-5" v-if="show">
                        <div class="form-group">
                            <button type="button"
                                    class="btn primary-button"
                                    @click.prevent="show = !show">
                                Создать
                            </button>
                        </div>
                    </div>
                    <div class="col-12 mt-5" v-else>
                        <p>new form</p>
                    </div>
                    <div class="col-12 mt-5">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Название</th>
                                <th scope="col">Стоимость</th>
                                <th scope="col">Начало</th>
                                <th scope="col">Окончание</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                 <td>@mdo</td>
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
    export default {
        data () {
            return {
                show: true
            }
        }
    }
</script>
