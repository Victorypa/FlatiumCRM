<template>
    <section class="create">

        <basic-header></basic-header>

        <div class="container-fluid">
            <div class="row">
                <navigation></navigation>

                <div class="col-md-10 estimates__content px-0 mt-5">

                    <div class="container-fluid px-0 mt-5 ml-5">
                        <div class="row ml-5">
                            <router-link>
                                <div :class="panelClass">
                                    <div class="card-body">
                                      <h5 class="card-title">Смета</h5>
                                    </div>
                                </div>
                            </router-link>

                            <div :class="panelClass">
                                <div class="card-body">
                                  <h5 class="card-title">Акты выполненных работ</h5>
                                </div>
                            </div>

                            <div :class="panelClass">
                                <div class="card-body">
                                  <h5 class="card-title">Акты дополнительных работ</h5>
                                </div>
                            </div>

                            <div :class="panelClass">
                                <div class="card-body">
                                  <h5 class="card-title">Баланс</h5>
                                </div>
                            </div>

                            <div :class="panelClass">
                                <div class="card-body">
                                  <h5 class="card-title">График работ</h5>
                                </div>
                            </div>

                            <div :class="panelClass">
                                <div class="card-body">
                                  <h5 class="card-title">Загрузить файлы</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
    export default {
        computed: {
            panelClass () {
                return 'card col-3 mt-5 ml-5 clickable'
            }
        }
    }
</script>

<style scoped>
    .clickable {
        height: 6em;
        cursor: pointer;
    }
</style>
