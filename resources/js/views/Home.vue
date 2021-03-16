<template>
    <div>
        <!-- template categories -->
        <v-container fluid grid-list-sm>
            <div class="text-right">
                <v-btn small text to="/campaigns" class="blue--text text-decoration-none">
                    All Campaigns <v-icon>mdi-chevron-right</v-icon>
                </v-btn>
            </div>
            <v-layout wrap>
                <v-flex v-for="(campaign) in campaigns" :key="`campaign-`+campaign.campaign_id" xs6>
                    <campaign-item :campaign='campaign'/>
                </v-flex>
            </v-layout>
        </v-container>

        <!-- template book -->
        <v-container grid-list-sm fluid>
            <div class="text-right">
                <v-btn small text to="/blogs" class="blue--text text-decoration-none">
                    All Blogs <v-icon>mdi-chevron-right</v-icon>
                </v-btn>
            </div>
            <v-layout wrap>
                <v-carousel hide-delimiters height="200px">
                    <v-carousel-item v-for="blog in blogs" :key="`blog-`+blog.blog_id" :to="'/blog/'+blog.blog_id">
                        <v-img :src="blog.image" class="fill-height">
                            <v-container fill-height fluid pa-0 ma-0>
                                <v-layout fill-height align-end>
                                    <v-flex xs12 mx-2>
                                        <span class="headline white--text" v-text="blog.title"></span>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-img>
                    </v-carousel-item>
                </v-carousel>
            </v-layout>
        </v-container>

    </div>
</template>

<script>
export default {
    data: () => ({
        campaigns: [],
        blogs: []
    }),
    components:{
        CampaignItem: () => import('../components/CampaignItem.vue')
    },
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
        );
        axios.get('api/blog/random/2').then(
            (response) => {
                let {response_data} = response.data;
                this.blogs = response_data.blogs;
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