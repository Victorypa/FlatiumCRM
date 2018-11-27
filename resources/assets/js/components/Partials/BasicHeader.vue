<template>
    <header class="header">

        <div class="container-fluid">

            <div class="row align-items-center justify-content-between header__top">

                <div class="header__logo col-md-2">
                    <router-link :to="{ name: 'orders' }">
                        <img class="header__logo--img" src="/img/logo.svg" alt="">
                    </router-link>
                </div>

                <div class="col-2 text-right">
                    <button type="button" class="dropdown-toggle transparent-button user-button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="/img/user.svg" alt="user-icon">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a @click="logout()" class="dropdown-item">Выход</a>
                    </div>

                </div>
            </div>
        </div>
    </header>
</template>

<script>
    import store from './../../store'
    import { mapActions } from 'vuex'

    export default {
        methods: {
            ...mapActions({
                logout: 'auth/logout'
            })
        }
    }
</script>

<style scoped lang="scss">
    .transparent-button {
        color: #00A4D1;
        font-size: 20px;
    }

    .dropdown-toggle::after {
        display: none;
    }
</style>
