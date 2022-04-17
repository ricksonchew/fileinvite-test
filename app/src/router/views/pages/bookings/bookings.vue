<script>
    import appConfig from '@src/app.config.json'
    import Layout from '@layouts/main'
    import DataTableBookings from '@components/data-table-bookings'
    import PageHeader from '@components/page-header'

    export default {
        page: {
            title: 'Bookings',
            meta: [{ name: 'description', content: appConfig.description }],
        },
        components: {
            Layout,
            PageHeader,
            DataTableBookings,
        },
        data() {
            return{
                title: 'Bookings',
            }
        }
    }
</script>

<template>
    <Layout>
        <PageHeader :title="title" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <DataTableBookings />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>