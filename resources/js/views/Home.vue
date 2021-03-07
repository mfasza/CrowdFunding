<template>
    <div>
        <!-- template categories -->
        <v-container class="ma-0 pa-0" grid-list-sm>
            <div class="text-right">
                <v-btn small text to="/campaigns" class="blue--text">
                    All Campaigns <v-icon>mdi-chevron-right</v-icon>
                </v-btn>
            </div>
            <v-layout wrap>
                <v-flex v-for="(campaign) in campaigns" :key="`campaign-`+campaign.campaign_id" xs6>
                    <v-card :to="'/campaign/'+campaign.campaign_id">
                        <v-img
                            :src="campaign.image"
                            class="red--text"
                            contain
                            :aspect-ratio="2"
                        >
                            <v-card-title
                                class="fill-height align-end"
                                v-text="campaign.title"
                            ></v-card-title>
                        </v-img>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>

        <!-- template book -->

    </div>
</template>

<script>
export default {
    data: () => ({
        campaigns: []
    }),
    created(){
        axios.get('api/campaign/random/2').then(
            (response) => {
                let {response_data} = response.data;
                this.campaigns = response_data.campaigns;
            }
        )
        .catch(
            (error) => {
                let {response} = error;
                console.log(response);
            }
        )
    }
}
</script>