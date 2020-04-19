<template>
    <v-container>
        <v-row>
            <v-col sm="12" md="6" lg="4" offset-md="6" offset-lg="4">
                <v-card>
                    <v-card-text>
                        <v-card-title>
                            Login
                        </v-card-title>
                        <v-form @submit.prevent="validateBeforeSubmit" width="100%" data-vv-scope="login">
                            <v-text-field
                                v-model="user.email"
                                label="E-mail Address"
                                name="email"
                                color="primary"
                                v-validate="'required|email'"
                                :error-messages="errors.collect('login.email')"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.password"
                                type="password"
                                name="password"
                                label="Password"
                                color="primary"
                                v-validate="'required'"
                                :error-messages="errors.collect('login.password')"
                            ></v-text-field>
                            <v-btn
                                type="submit"
                                class="primary white--text"
                                :loading="isLoading"
                                :disabled="isLoading"
                            >Login</v-btn>
                            <br><br>
                            <router-link :to="{name: 'RegisterCustomer'}">Register</router-link>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "LoginCustomer",
        methods: {
            login() {
                axios.post(`/api/login`, this.user)
                    .then((response) => {
                        this.isLoading = true
                        let loginObject = {
                            accessToken: response.data.data.access_token,
                            userInfo: response.data.data.user,
                        }
                        this.$store.dispatch('userLogin', loginObject);
                        this.$emit('logged-in', true);
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.data.access_token;
                        this.$router.push({name: 'ProductList'})
                    }).catch((error)=>{
                        console.log(error);
                        this.responseError = error.message
                    }).finally(() => {
                        this.isLoading = false
                })
            },
            validateBeforeSubmit() {
                this.$validator.validateAll().then(result => {
                    if (result) {
                        this.login();
                    }
                    return false;
                });
            }
        },
        data() {
            return {
                user: {
                    email: '',
                    password: '',
                },
                isLoading: false,
                responseError: ''
            }
        }
    }
</script>

<style scoped>

</style>
