import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
    {
        name: 'login',
    	path: '/login',
    	component: require('./components/Auth/Login'),
        meta: { authenticated: true }
    },

    {
        name: 'orders',
    	path: '/',
    	component: require('./components/Orders/Orders'),
        meta: { requiresAuth: true }
    },

    {
        name: 'report',
        path: '/reports',
        component: require('./components/Reports/Report'),
        meta: { requiresAuth: true }
    },

    {
        name: 'order-upload',
    	path: '/orders/:id?/upload',
    	component: require('./components/Orders/Upload/OrderUpload'),
        meta: { requiresAuth: true }
    },

    {
        name: 'order-show',
    	path: '/orders/:id?',
    	component: require('./components/Orders/OrderShow'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-panel',
    	path: '/orders/:id?/panel',
    	component: require('./components/Orders/Panel/Panel'),
        meta: { requiresAuth: true }
    },

    {
        name: 'order-finance',
    	path: '/orders/:id?/finance',
    	component: require('./components/Orders/Finances/Finances'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-steps',
    	path: '/orders/:id?/steps',
    	component: require('./components/Orders/Steps/OrderSteps'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-step-graphic',
    	path: '/orders/:id?/steps/graphic',
    	component: require('./components/Orders/Steps/Graphic/OrderStepGraphic'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-finished-acts',
    	path: '/orders/:id?/order_finished_acts',
    	component: require('./components/Orders/Services/Finished/FinishedActs'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-finished-act-show',
    	path: '/orders/:id?/order_finished_services/:finished_act_id?',
    	component: require('./components/Orders/Services/Finished/FinishedActShow'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-finished-services-export-show',
    	path: '/orders/:id?/order_finished_services/:finished_act_id?/export/show',
    	component: require('./components/Orders/Services/Finished/Export/Export'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-extra-services-rooms-show',
    	path: '/orders/:id?/order_extra_services/:extra_order_act_id?/extra_rooms/:extra_room_id?',
    	component: require('./components/Orders/Services/Rooms/ExtraRoom'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-extra-services-materials',
    	path: '/orders/:id?/order_extra_services/:extra_order_act_id?/extra_rooms/:extra_room_id?/services/:service_id?/materials',
    	component: require('./components/Orders/Services/Rooms/Services/Materials/Materials'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-extra-services-export-show',
    	path: '/orders/:id?/order_extra_services/:extra_order_act_id?/export/show',
    	component: require('./components/Orders/Services/Export/ExtraServicesShow'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'room-show',
    	path: '/orders/:id?/rooms/:room_id?',
    	component: require('./components/Orders/Rooms/RoomShow'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'actual-material',
    	path: '/orders/:id?/rooms/:room_id?/services/:service_id?/materials',
    	component: require('./components/Orders/Rooms/Services/Materials/Materials'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'order-export-show',
        path: '/orders/:id?/export/pdf/show',
        component: require('./components/Orders/Export/Show'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'service-material',
        path: '/services/:service_id?/materials',
        component: require('./components/Services/Materials/ServiceMaterial'),
        meta: { requiresAuth: true },
        props: true
    },

    {
        name: 'services',
        path: '/services',
        component: require('./components/Services/Services'),
        meta: { requiresAuth: true },
        props: true
    }


]

const router = new VueRouter({
    routes,
	linkActiveClass: 'active'
})

export default router
