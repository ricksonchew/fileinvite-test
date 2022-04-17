<script>
    import Layout from '@layouts/default'
    import { authMethods } from '@state/helpers'
    import AlertModal from '@components/alert-modal'
    import appConfig from '@src/app.config'

    /**
     * Login component
     */
    export default {
        page: {
            title: 'Log in',
            meta: [{ name: 'description', content: `Log in to ${appConfig.title}` }],
        },
        components: { Layout, AlertModal },
        data() {
            return {
                email: '',
                password: '',
                pageIsLoading: false,
                modalMessage: 'Error',
                modalShow: false,
                modalVariant: 'danger',
            }
        },
        methods: {
            ...authMethods,
            tryToLogIn() {
                this.pageIsLoading = true;
                return this.logIn({
                    email: this.email,
                    password: this.password,
                })
                    .then((response) => {
                        this.modalShow    = true;
                        this.modalMessage = response.message;
                        this.modalVariant = response.variant;

                        this.pageIsLoading = false;
                        if (response.variant == 'success') {
                            this.$router.push(
                                this.$route.query.redirectFrom || { name: 'Bookings' }
                            )
                        }
                    })
            },
        },
    }
</script>

<template>
    <Layout>
        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-12 p-5">
                                        <div class="mx-auto mb-5">
                                            <a routerLink="/">
                                                <h3 class="d-inline align-middle ml-1 text-logo">Login</h3>
                                            </a>
                                        </div>

                                        <h6 class="h5 mb-0 mt-4">Welcome back!</h6>
                                        <p class="text-muted mt-1 mb-4">
                                            Enter your email address and password to access admin panel.
                                        </p>

                                        <AlertModal :message="modalMessage" :show="modalShow" :modalVariant="modalVariant" />

                                        <b-form class="authentication-form" @submit.prevent="tryToLogIn">
                                            <div class="form-group">
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <feather type="mail" class="align-middle icon-dual icon-xs" />
                                                        </span>
                                                    </div>
                                                    <b-form-input
                                                        id="email"
                                                        v-model="email"
                                                        type="text"
                                                        required
                                                        placeholder="Email address"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <label class="form-control-label">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <feather type="lock" class="align-middle icon-dual icon-xs" />
                                                        </span>
                                                    </div>
                                                    <b-form-input
                                                        id="password"
                                                        v-model="password"
                                                        type="password"
                                                        required
                                                        placeholder="Password"
                                                    />
                                                </div>
                                            </div>
                                            <b-form-group id="button-group" class="mt-4 mb-1">
                                                <b-button
                                                    type="submit"
                                                    variant="primary"
                                                    class="btn-block"
                                                >Log In</b-button>
                                            </b-form-group>
                                        </b-form>
                                    </div>
                                </div>
                            </div>

                            <b-overlay :show="pageIsLoading" no-wrap></b-overlay>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">
                                    Don't have an account?
                                    <router-link tag="a" :to="{ name: 'register' }" class="text-primary font-weight-bold ml-1">Sign Up</router-link>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style lang="scss" module></style>
