<template>
    <div>
        <v-container fluid grid-list-sm>
            <v-subheader>
                All Campaigns
            </v-subheader>
            <v-layout wrap>
                <v-flex v-for="(campaign) in campaigns" :key="`campaign-`+campaign.campaign_id" xs6>
                    <!-- <v-card :to="'/campaign/' + campaign.campaign_id">
                        <v-img :src="campaign.image" class="red--text" :aspect-ratio="2">
                            <v-card-title class="fill-height align-end" v-text="campaign.title"></v-card-title>
                        </v-img>
                    </v-card> -->
                    <campaign-item :campaign='campaign'/>
                </v-flex>
            </v-layout>
            <v-pagination v-model="page" @input="go" :length="lengthPage" :total-visible="6"></v-pagination>
        </v-container>
    </div>
</template>

<script>
export default {
    data: () => ({
        campaigns: [],
        page: 0,
        lengthPage: 0
    }),
    components:{
        CampaignItem: () => import('../components/CampaignItem.vue')
    },
    created(){
        this.go()
    },
    methods: {
        go(){
            axios.get('/api/campaign?page='+this.page).then(
                (response) => {
                    let {response_data} = response.data;

                    this.campaigns = response_data.campaigns.data;
                    this.page = response_data.campaigns.current_page;
                    this.lengthPage = response_data.campaigns.last_page;
                }
            ).catch(
                (error) => {
                    let {response} = error;
                    console.log(response);
                }
            )
        }
    }
}
</script>