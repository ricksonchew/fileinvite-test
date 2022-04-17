<script>
    import { layoutComputed } from '@state/helpers'
    import Topbar from '@components/topbar'
    import SideBar from '@components/side-bar'

    export default {
        components: { Topbar, SideBar },
        data() {
            return {
                isMenuCondensed: false,
                isMobileMenuOpened: false,
                user: this.$store ? this.$store.state.auth.currentUser : {} || {},
                layout: this.$store ? this.$store.state.layout.layoutType : null || null,
                theme: this.$store ? this.$store.state.layout.leftSidebarTheme : null || null,
                type: this.$store ? this.$store.state.layout.leftSidebarType : null || null,
                width: this.$store ? this.$store.state.layout.layoutWidth : null || null,
            }
        },
        computed: {
            ...layoutComputed,
        },
        created: () => {
            document.body.classList.remove('authentication-bg')
            document.body.classList.remove('authentication-bg-pattern')
            document.body.removeAttribute('data-layout')
            if (
                /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Mobile|mobile|CriOS/i.test(
                    navigator.userAgent
                )
            ) {
                if (window.screen.width >= 728 && window.screen.width <= 1028) {
                    document.body.classList.add('left-side-menu-condensed')
                }
            }
        },
    }
</script>

<template>
    <div id="wrapper">
        <Topbar :user="user" :is-menu-opened="isMobileMenuOpened" />
        <SideBar
            :is-condensed="isMenuCondensed"
            :theme="leftSidebarTheme"
            :type="leftSidebarType"
            :width="layoutWidth"
            :user="user"
        />

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
