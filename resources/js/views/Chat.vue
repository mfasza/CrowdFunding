<template>
    <div>
        <v-tabs
            v-model="tab"
            background-color="indigo"
            dark
        >
            <v-tabs-slider color="orange"></v-tabs-slider>

            <v-tab
                v-for="item in items"
                :key="item.tab"
            >
                {{ item.tab }}
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item
                v-for="item in items"
                :key="item.tab"
            >
                <component :is="item.content"></component>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "Chat",
    data: () => ({
        tab: null,
        items: [
            { tab: 'Discussion Chat', content: 'DiscussChat' },
            { tab: 'Chat Admin', content: 'AdminChat' },
        ],
    }),
    components: {
        AdminChat: () => import("../components/AdminChat"),
        DiscussChat: () => import("../components/DiscussChat")
    },
    computed: {
        ...mapGetters({
            guest: 'auth/guest'
        })
    },
    watch: {
        guest() {
            if (this.guest) {
                this.$router.push({name: 'home'})
            }
        }
    }
}
</script>