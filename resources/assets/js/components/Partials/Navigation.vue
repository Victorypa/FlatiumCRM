<template>
    <div class="sidebar col-2 px-0">
        <div class="sidebar-items px-0">
            <div class="sidebar-list">
                <router-link class="sidebar-list-item" :to="{ name: 'orders' }">Все сметы</router-link>
            </div>
            <div class="sidebar-list">
                <router-link class="sidebar-list-item" :to="{ name: 'services' }">Виды работ</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>

<style scoped lang="scss">
    .sidebar-list-item:hover {
        text-decoration: none;
    }

    .sidebar {
        min-height: 100vh;
    }
</style>
