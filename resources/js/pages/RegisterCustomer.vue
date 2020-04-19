<template>
    <v-container>
        <v-row>
            <v-col sm="12" md="6" lg="4" offset-md="6" offset-lg="4">
                <v-card>
                    <v-card-text>
                        <v-card-title>
                            Register Customer
                        </v-card-title>
                        <v-form @submit.prevent="validateBeforeSubmit" width="100%" class="login_form" data-vv-scope="register">
                            <v-text-field
                                v-model="user.first_name"
                                label="First Name"
                                name="First Name"
                                color="primary"
                                v-validate="'required'"
                                :error-messages="errors.collect('register.First Name')"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.last_name"
                                label="Last Name"
                                name="Last Name"
                                color="primary"
                                v-validate="'required'"
                                :error-messages="errors.collect('register.Last Name')"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.contact_no"
                                label="Contact No."
                                name="Contact No"
                                color="primary"
                                :error-messages="errors.collect('register.Contact No')"
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
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "RegisterCustomer",
        methods: {
            register() {
                this.isLoading = true
                axios.post(`/api/customer/register`, this.user)
                    .then((response) => {
                        this.$router.push({name: 'LoginCustomer'})
                    }).catch((error)=>{
                        console.log(error)
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
                    first_name: '',
                    last_name: '',
                    contact_no: '',
                    email: '',
                    password: '',
                },
                isLoading: false
            }
        }
    }
</script>

<style scoped>

</style>
