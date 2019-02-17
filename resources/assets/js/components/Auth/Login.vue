<template>
    <section class="login">
        <auth-header></auth-header>
        <div class="container">
            <div class="row justify-content-center align-items-center h-100vh">

                <form @submit.prevent="login(credentials)" class="col-4">
                    <div class="login-form">

                        <div class="form-group">
                            <input type="text"
                                   placeholder="Почта"
                                   class="form-control"
                                   autofocus
                                   v-model="credentials.email"
                                   >
                        </div>
                        <div class="form-group">
                            <input type="password"
                                   placeholder="Пароль"
                                   class="form-control"
                                   v-model="credentials.password"
                                   >
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="col-md-8 mx-auto">
                            <button type="submit" class="primary-button col-md-12">Войти</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

</template>

<script>
    import { mapActions } from 'vuex'
    import others from '../../services/others'
    import AuthHeader from './Partials/AuthHeader'

    export default {
        data() {
            return {
                others,
                credentials: {
                    email: '',
                    password: ''
                }
            }
        },

        components: {
            AuthHeader
        },

        created () {
            others.all()
        },

        methods: {
            ...mapActions({
                login: 'auth/login'
            })
        }

    }
</script>
