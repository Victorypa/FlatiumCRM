import axios from 'axios'

export default {
    all () {
        localStorage.clear()
        this.getServiceTypes()
        this.getServiceUnits()
        this.getMaterialUnits()
    },

    getServiceTypes () {
        if (localStorage.getItem('service_types')) {
            return JSON.parse(localStorage.getItem('service_types'))
        } else {
            return axios.get(`/api/service_types`).then(response => {
                localStorage.setItem('service_types', JSON.stringify(response.data))
                return response.data
            })
        }
    },

    getServiceUnits () {
        if (localStorage.getItem('units')) {
            return JSON.parse(localStorage.getItem('units'))
        } else {
            return axios.get(`/api/units`).then(response => {
                localStorage.setItem('units', JSON.stringify(response.data))
                return response.data
            })
        }
    },

    getMaterialUnits () {
        if (localStorage.getItem('material_units')) {
            return JSON.parse(localStorage.getItem('material_units'))
        } else {
            return axios.get(`/api/material_units`).then(response => {
                localStorage.setItem('material_units', JSON.stringify(response.data))
                return response.data
            })
        }
    },
}
