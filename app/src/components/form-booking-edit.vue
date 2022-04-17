<script>
    import AlertModal from '@components/alert-modal'
    import * as API_URL from '@constants/api'

    export default {
        components: {
            AlertModal,
        },
        props: {
            bookingId: { type: Number },
        },
        methods: {
            getDetail(args) {
                this.$store.dispatch('dataTable/fetchDetail', {
                    apiUrl: API_URL.API_URL.bookings.default,
                    params: args,
                }).then((response)=> {
                    const responseData = response.data[0];
                    this.$store.commit('bookings/SET_FORM', {
                        name        : responseData.name,
                        description : responseData.description,
                    });
                });
            },
            onSubmitEvent() {
                this.$store.commit('dataTable/PAGE_LOADING_OVERLAY', true)
                return this.$store.dispatch('productCategory/onSubmitEdit', {
                    params : {
                        id : this.bookingId,
                    },
                }).then((response) => {
                    this.modalShow    = true;
                    this.modalMessage = response.message;
                    this.modalVariant = response.variant;

                    this.$store.commit('dataTable/PAGE_LOADING_OVERLAY', false);

                    if (response.variant == 'success') {
                        this.$store.dispatch('dataTable/fetchList', {
                            apiUrl: API_URL.API_URL.bookings.default,
                        });
                    }
                })
            }
        },
        beforeMount() {
            this.getDetail({'booking_id': this.bookingId});
        },
        beforeCreate() {
            this.$store.commit('bookings/SET_FORM', {
                name        : null,
                description : null,
            });
        },
        computed: {
            pageIsLoading: {
                get() {
                    return this.$store.state.bookings.pageIsLoading;
                },
            }
        },
        data() {
            return {
                modalMessage: 'Error',
                modalShow: false,
                modalVariant: 'danger',
            }
        }
    }
</script>

<template>
    <b-form class="form-horizontal" @submit.prevent="onSubmitEvent" :novalidate="true">
        <div class="card-body p-0">
            <div class="row py-1">
                <div class="col-lg-12">
                    <div class="px-3 pt-3" v-if="modalShow">
                        <AlertModal :message="modalMessage" :show="modalShow" :modalVariant="modalVariant" />
                    </div>
                    <h6 class="card-title border-bottom p-3 mb-0 header-title">Booking Details</h6>
                    <div class="p-3">
                        <b-form-group label-cols-sm="10" label-cols-lg="2" label="Name" label-for="date">
                            <b-form-input id="date"></b-form-input>
                        </b-form-group>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top text-right">
            <b-button type="submit" variant="primary">Submit</b-button>
        </div>
        <b-overlay :show="pageIsLoading" no-wrap></b-overlay>
    </b-form>
</template>