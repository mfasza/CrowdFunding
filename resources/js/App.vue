<template>
    <v-app>

        <alert/>

        <keep-alive>
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="scroll-x-reverse-transition" persistent>
                <component :is="dialogComponent" @closed="setDialogStatus"></component>

            </v-dialog>
        </keep-alive>

        <v-navigation-drawer app v-model="drawer">
            <v-list>
                <v-list-item v-if="!guest">
                    <v-list-item-avatar>
                        <v-img :src="user.user.photo"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>{{ user.user.name }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <div class="pa-2" v-if="guest">
                    <v-btn block color="primary" class="mb-1" @click="setDialogComponent('Login')">
                        <v-icon left>mdi-lock</v-icon>
                        Login
                    </v-btn>
                    <v-btn block color="success" @click="setDialogComponent('register')">
                        <v-icon left>mdi-account</v-icon>
                        Register
                    </v-btn>
                </div>

                <v-divider></v-divider>

                <v-list-item
                    v-for="(item,index) in menus"
                    :key="'menu-'+index"
                    :to="item.route"
                >
                    <v-list-item-icon>
                        <v-icon left>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <template v-slot:append v-if="!guest">
                <div class="pa-2">
                    <v-btn block color="red" dark @click="logout">
                        <v-icon left>mdi-lock</v-icon>
                        Logout
                    </v-btn>
                </div>
            </template>

        </v-navigation-drawer>

        <v-app-bar app color="success" dark v-if="isHome">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>CrowdFunding</v-toolbar-title>

            <!-- pemisah konten -->
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-badge color="red" overlap :content="transactions" :value="transactions">
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
            </v-btn>
            
            <v-btn icon @click="setDialogComponent('search')">
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

        </v-app-bar>

        <v-app-bar app color="success" dark v-else>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-btn icon @click.stop="$router.go(-1)">
                <v-icon>mdi-arrow-left-circle</v-icon>
            </v-btn>
            <v-toolbar-title>{{titleBar}}</v-toolbar-title>

            <!-- pemisah konten -->
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-badge color="red" overlap :content="transactions" :value="transactions">
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
            </v-btn>
            
            <v-btn icon @click="setDialogComponent('search')">
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

                <!-- If using vue-router -->
                <v-slide-y-transition>
                    <router-view></router-view>
                </v-slide-y-transition>
            </v-container>
        </v-main>

        <v-card>
            <v-footer absolute app>
                <v-card-text class="text-center">
                    &copy; {{ new Date().getFullYear() }} - <strong>CrowdFunding</strong>
                </v-card-text>
            </v-footer>
        </v-card>
    </v-app>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name: 'App',
    components: {
        Alert: () => import('./components/alert'),
        Search: () => import('./components/search'),
        Login: () => import('./components/Login'),
        Register: () => import('./components/Register'),
        UpdatePassword: () => import('./components/UpdatePassword'),
    },
    data: () => {
        return {
            drawer: false,
            menus: [
                { title: 'Home', icon: 'mdi-home', route: '/' },
                { title: 'Campaigns', icon: 'mdi-hand-heart', route: '/campaigns' },
                { title: 'Chat', icon: 'mdi-message', route: '/chat' },
            ]
        }
    },
    computed: {
        isHome() {
            return (this.$route.path==='/' || this.$route.path==='/home')
        },
        ...mapGetters({
            transactions: 'transaction/transactions',
            guest: 'auth/guest',
            user: 'auth/user',
            dialogStatus: 'dialog/status',
            dialogComponent: 'dialog/component',
        }),
        dialog: {
            get() {
                return this.dialogStatus
            },
            set(value) {
                this.setDialogStatus(value)
            }
        },
        titleBar() {
            let text = this.$route.path.split('/')[1]
            let firstChar = text.charAt(0).toUpperCase()
            let restChar = text.slice(1)

            return firstChar + restChar
        }
    },
    methods: {
        ...mapActions({
            setDialogStatus: 'dialog/setStatus',
            setDialogComponent: 'dialog/setComponent',
            setAuth: 'auth/set',
            setAlert: 'alert/showAlert',
            checkToken: 'auth/checkToken'
        }),
        logout() {
            let config = {
                headers: {
                    'Authorization': 'Bearer ' + this.user.token
                }
            }
            axios.post('/api/auth/logout/', {}, config).then(
                (response) => {
                    this.setAuth({}) // kosongkan auth ketika logout
                    this.setAlert({
                        text: response.data.response_message,
                        color: 'success',
                        outline: false
                    })
                }
            ).catch(
                (error) => {
                    let {response_data} = error.response
                    this.setAlert({
                        color: 'error',
                        text: response_data.message,
                        outline: true
                    })
                }
            )
        }
    },
    mounted() {
        if (Object.keys(this.user).length !== 0) {
            this.checkToken(this.user)
        }
    }
}
</script>