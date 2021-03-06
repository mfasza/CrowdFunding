<template>
    <v-app>
        <v-navigation-drawer app>
            Sidebar
        </v-navigation-drawer>

        <v-app-bar app>
            <router-link to="/">Home</router-link>
            <router-link to="/donations">Donations</router-link>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

                <!-- If using vue-router -->
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            @CrowdFunding 2021
        </v-footer>
    </v-app>
</template>

<script>
export default {
    created() {
        console.log('Component mounted.');
    }
}
</script>