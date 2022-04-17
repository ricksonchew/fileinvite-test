<script>
    import Layout from '@layouts/main'

    export default {
        page: {
            title: 'Loading page...',
            meta: [{ name: 'description', content: 'Loading page...' }],
        },
        name: 'Loading',
        components: { Layout },
    }
</script>

<template>
    <Layout>
        <div class="preloader">
            <div class="status">
                <div class="spinner">
                    <div class="circle1"></div>
                    <div class="circle2"></div>
                    <div class="circle3"></div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style lang="scss" module>
    .loadingIcon {
        display: block;
        margin: 0 auto;

        &:global(.v-enter-active) {
            transition: opacity 1s;
        }
        &:global(.v-enter) {
            opacity: 0;
        }
    }
</style>
