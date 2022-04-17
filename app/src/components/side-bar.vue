<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import { authComputed } from '@state/helpers'
import Appmenu from './app-menu'

/**
 * Left sidebar component - contains mainly the application menu
 */
export default {
    components: { VuePerfectScrollbar, Appmenu },
    props: {
        isCondensed: {
            type: Boolean,
            default: false,
        },
        theme: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        width: { type: String, required: true },
        user: {
            type: Object,
            required: false,
            default: () => ({}),
        },
    },
    data() {
        return {
            settings: {
                minScrollbarLength: 60,
            },
        }
    },
    computed: {
        ...authComputed,
    },
    watch: {
        theme: function(newVal, oldVal) {
            if (newVal !== oldVal) {
                switch (newVal) {
                    case 'dark':
                        document.body.classList.add('left-side-menu-dark')
                        document.body.classList.remove('left-side-menu-condensed')
                        document.body.classList.remove('boxed-layout')
                        break
                    default:
                        document.body.classList.remove('left-side-menu-dark')
                        break
                }
            }
        },
        type: function(newVal, oldVal) {
            if (newVal !== oldVal) {
                switch (newVal) {
                    case 'condensed':
                        document.body.classList.add('left-side-menu-condensed')
                        document.body.classList.remove('left-side-menu-dark')
                        document.body.classList.remove('boxed-layout')
                        break
                    default:
                        document.body.classList.remove('left-side-menu-condensed')
                        break
                }
            }
        },
        width: function(newVal, oldVal) {
            if (newVal !== oldVal) {
                switch (newVal) {
                    case 'boxed':
                        document.body.classList.add('left-side-menu-condensed')
                        document.body.classList.remove('left-side-menu-dark')
                        document.body.classList.add('boxed-layout')
                        break
                    default:
                        document.body.classList.remove('left-side-menu-condensed')
                        document.body.classList.remove('boxed-layout')
                        break
                }
            }
        },
    },
}
</script>

<template>
    <div class="left-side-menu">
        <div class="sidebar-content">
            <VuePerfectScrollbar
                v-if="!isCondensed"
                v-once
                class="slimscroll-menu"
                :settings="settings"
            >
                <div id="sidebar-menu">
                    <Appmenu />
                </div>
            </VuePerfectScrollbar>
            <div v-else id="sidebar-menu">
                <Appmenu />
            </div>
        </div>
    </div>
</template>