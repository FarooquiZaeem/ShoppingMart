<template>
    <v-container>
        <v-row>
            <v-col sm="12" md="6" lg="4" offset-md="6" offset-lg="4">
                <v-card>
                    <v-card-text>
                        <v-card-title>
                            Register Admin
                        </v-card-title>
                        <v-form @submit.prevent="validateBeforeSubmit" width="100%" data-vv-scope="register">
                            <v-text-field
                                v-model="user.name"
                                label="Name"
                                name="name"
                                color="primary"
                                v-validate="'required'"
                                :error-messages="errors.collect('register.name')"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.email"
                                label="E-mail Address"
                                name="email"
                                color="primary"
                                v-validate="'required|email'"
                                :error-messages="errors.collect('register.email')"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.password"
                                type="password"
                                name="password"
                                label="Password"
                                color="primary"
                                v-validate="'required'"
                                :error-messages="errors.collect('register.password')"
                            ></v-text-field>
                            <v-btn
                                type="submit"
                                class="primary white--text"
                                :loading="isLoading"
                                :disabled="isLoading"
                            >Login</v-btn>
                            <span class="red--text" v-if="responseError !== ''">{{responseError}}</span>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "RegisterAdmin",
        methods: {
            register() {
                this.isLoading = true
                this.responseError = ''
                axios.post(`/api/admin/register`, this.user)
                    .then((response) => {
                        this.$router.push({name: 'LoginAdmin'})
                    }).catch((error)=>{
                        this.responseError = error.message
                    }).finally(() => {
                        this.isLoading = false
                })
            },
            validateBeforeSubmit() {
                this.$validator.validateAll().then(result => {
                    if (result) {
                        this.register();
                    }
                    return false;
                });
            }
        },
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                },
                responseError: '',
                isLoading: false
            }
        }
    }
</script>

<style scoped>

</style>
