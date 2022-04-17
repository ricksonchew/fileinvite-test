<script>
import { authComputed } from '@state/helpers'

export default {
    props: {
        isMenuOpened: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {}
    },
    computed: {
        ...authComputed,
    },
    methods: {
        toggleMenu() {
            this.$parent.toggleMenu()
        },
    },
}
</script>

<template>
    <div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
        <div class="container-fluid">
            <router-link tag="a" :to="{ name: 'Bookings' }" class="navbar-brand mr-0 mr-md-2 logo">
                <span class="d-inline h5 ml-2 text-logo">Booking App</span>
            </router-link>

            <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
                <li>
                    <button
                        class="button-menu-mobile open-left disable-btn"
                        :class="{ open: isMenuOpened }"
                        @click="toggleMenu"
                    >
                        <feather type="menu" class="menu-icon align-middle"></feather>
                        <feather type="x" class="close-icon"></feather>
                    </button>
                </li>
            </ul>

            <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
                <li id="setting-tooltip" class="dropdown notification-list">
                    <router-link tag="a" :to="{ name: 'logout' }">
                        <feather type="log-out" class="icon-dual"></feather>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
