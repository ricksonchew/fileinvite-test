<script>
    import Layout from '@layouts/default'
    import { authMethods } from '@state/helpers'
    import appConfig from '@src/app.config'

    export default {
        page: {
            title: 'Register',
            meta: [{ name: 'description', content: `Register to ${appConfig.title}` }],
        },
        components: { Layout },
        computed: {},
        methods: {
            ...authMethods,
            tryToRegisterIn() {
                this.pageIsLoading = true;
                return this.register({
                    firstName: this.firstName,
                    lastName: this.lastName,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                    .then((response) => {
                        this.pageIsLoading = false;

                        // Redirect to the originally requested page, or to the confirm-account page
                        this.$router.push(
                            this.$route.query.redirectFrom || { name: 'Dashboard' }
                        )
                    })
                    .catch((error) => {
                        this.modalShow    = true;
                        this.modalMessage = error.response.data.response.error;
                        this.modalVariant = 'danger';

                        this.pageIsLoading = false;
                    })
            },
        },
        data() {
            return {
                firstName: '',
                lastName: '',
                email: '',
                password: '',
                password_confirmation: '',
                pageIsLoading: false,
                modalMessage: 'Error',
                modalShow: false,
                modalVariant: 'danger',
            }
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
                                                <h3 class="d-inline align-middle ml-1 text-logo">Registration</h3>
                                            </a>
                                        </div>

                                        <h6 class="h5 mb-0 mt-4">Sign up now!</h6>
                                        <p class="text-muted mt-0 mb-4">Create a free account!</p>

                                        <AlertModal :message="modalMessage" :show="modalShow" :modalVariant="modalVariant" />

                                        <b-form class="authentication-form" @submit.prevent="tryToRegisterIn">
                                            <div class="form-group">
                                                <label class="form-control-label">Name</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <feather type="user" class="icon-dual icon-xs"></feather>
                                                        </span>
                                                    </div>
                                                    <b-form-input
                                                        id="firstName"
                                                        v-model="firstName"
                                                        type="text"
                                                        required
                                                        placeholder="First name"
                                                    />
                                                    <b-form-input
                                                        id="lastName"
                                                        v-model="lastName"
                                                        type="text"
                                                        required
                                                        placeholder="Last name"
                                                    />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-control-label">Email Address</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <feather type="mail" class="icon-dual icon-xs"></feather>
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

                                            <div class="form-group">
                                                <label class="form-control-label">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <feather type="lock" class="icon-dual icon-xs"></feather>
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

                                            <div class="form-group">
                                                <label class="form-control-label">Confirm Password</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <feather type="lock" class="icon-dual icon-xs"></feather>
                                                </span>
                                                    </div>
                                                    <b-form-input
                                                        id="password_confirmation"
                                                        v-model="password_confirmation"
                                                        type="password"
                                                        required
                                                        placeholder="Confirm Password"
                                                    ></b-form-input>
                                                </div>
                                            </div>
                                            <b-form-group id="button-group" class="mt-4 mb-1">
                                                <b-button type="submit" variant="primary" class="btn-block">Sign Up</b-button>
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
                                    Already have an account?
                                    <router-link tag="a" :to="{ name: 'login' }" class="text-primary font-weight-bold ml-1">Login</router-link>
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
