<template>
    <header class="header">

        <div class="container-fluid">

            <div class="row align-items-center justify-content-between header__top">

                <div class="header__logo header__logo--color col-md-2">
                    <router-link :to="{ name: 'login' }">
                        <img class="header__logo--img" src="/images/logo-flat.svg" alt="">
                    </router-link>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    export default {

    }
</script>
