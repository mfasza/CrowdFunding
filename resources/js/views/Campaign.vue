<template>
    <div>
        <v-card v-if="campaign.campaign_id">
            <v-img :src="campaign.image" class="red--text" height="300px">
                <v-card-title class="fill-height align-end" v-text="campaign.title"></v-card-title>
            </v-img>

            <v-card-text>
                <v-simple-table dense>
                    <tbody>
                        <tr>
                            <td><v-icon>mdi-home-city</v-icon> Alamat</td>
                            <td>{{ campaign.address }}</td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-hand-heart</v-icon> Terkumpul</td>
                            <td class="blue--text">Rp {{ campaign.collected.toLocaleString('id-ID') }}</td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-cash</v-icon> Dibutuhkan</td>
                            <td class="orange--text">Rp {{ campaign.required.toLocaleString('id-ID') }}</td>
                        </tr>
                    </tbody>
                </v-simple-table>
                <span>Description:</span>
                <p>{{ campaign.description }}</p>
            </v-card-text>

            <v-card-actions>
                <v-btn block color="primary" @click="doDonate" :disabled="campaign.collected >= campaign.required">
                    <v-icon>mdi-hand-heart</v-icon>&nbsp;
                    DONATE
                </v-btn>
            </v-card-actions>

        </v-card>
        <donate-alert></donate-alert>
    </div>
    
</template>

<script>
import { mapActions } from 'vuex'
export default {
    data: () => ({
        campaign: {}
    }),
    components: {
        donateAlert: () => import('../components/alert.vue')
    },
    created() {
        this.go()
    },
    methods: {
        go() {
            let {id} = this.$route.params
            axios.get('/api/campaign/'+id).then(
                (response) => {
                    let {response_data} = response.data
                    this.campaign = response_data.campaign
                }
            ).catch(
                (error) => {
                    let {response} = error
                    console.log(response)
                }
            )
        },
        ...mapActions({
            donate: 'transaction/donate',
            showAlert: 'alert/showAlert'
        }),
        doDonate(){
            this.donate()
            this.showAlert({
                color: 'dark',
                text: "Donasi berhasil dilakukan.",
                outline: false
            })
        }
    },
    watch: {
        $route(to, from) {
            axios.get('/api/campaign/'+to.params.id).then(
                (response) => {
                    let {response_data} = response.data
                    this.campaign = response_data.campaign
                }
            ).catch(
                (error) => {
                    let {response} = error
                    console.log(response)
                }
            )
        }
    }
}
</script>