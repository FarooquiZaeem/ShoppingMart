<template>
    <v-app>
        <v-app-bar
            app
            clipped
            color="blend"
            v-if="isLoggedIn"
            style="box-shadow: none"
        >
            <v-row justify="end">
<!--                <v-col sm="6" md="2" lg="1">-->
                    <b class="mr-4">{{$store.getters.userInfo.first_name}}</b>
<!--                </v-col>-->
<!--                <v-col sm="6" md="2" lg="1">-->
                    <v-btn small color="primary" @click="logout">Logout</v-btn>
<!--                </v-col>-->
            </v-row>
        </v-app-bar>
        <br><br>
        <router-view :key="$route.fullPath" @logged-in="loggedIn" ></router-view>
    </v-app>
</template>
<script>
    export default {
        methods: {
            loggedIn() {
                this.isLoggedIn = true
            },
            logout() {
                axios.get('api/logout')
                .then((response) => {
                    this.$router.replace('/login', () => {
                        this.isLoggedIn = false
                        this.$store.dispatch('userLogout')
                    })
                })
            }
        },
        data() {
            return {
                isLoggedIn: false
            }
        },
        mounted() {
            if(localStorage.getItem('accessToken')) {
                this.isLoggedIn = true
            }
        }
    };
</script>
<style>

</style>
