<template>
    <div>
        <v-card :to="`/campaign/`+campaign.campaign_id">
            <v-img :src="campaign.image" class="red--text" height="200px" aspect-ratio="2">
                <v-card-title class="fill-height align-end" v-text="campaign.title"></v-card-title>
            </v-img>

            <v-card-actions>
                <v-progress-linear v-model="progress" color="blue" height="7"></v-progress-linear>
            </v-card-actions>

            <v-card-actions>
                <v-icon>mdi-cash</v-icon>
                <span>Rp {{ campaign.collected.toLocaleString('id-ID') }}</span>
                <v-spacer></v-spacer>
                <span>{{ progress }}%</span>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    name: 'campaign-item',
    props: ['campaign'],
    computed: {
        progress() {
            return (this.campaign.collected / this.campaign.required * 100)
        }
    }
}
</script>