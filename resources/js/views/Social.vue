<template>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: 'social',
    data: () => ({
        provider: '',
        code: ''
    }),
    computed: {
        ...mapGetters({
            user: 'auth/user',
        })
    },
    methods: {
        ...mapActions({
            setAuth: 'auth/set',
            setAlert: 'alert/showAlert',
            setDialogStatus: 'dialog/setStatus'
        }),
        go(provider, code) {
            let url = '/api/auth/social/' + provider + '/callback?code=' + code
            axios.get(url).then(
                (response) => {
                    let {response_data} = response.data
                    this.setAuth(response_data)
                    if(this.user.user.user_id.length>0){
                        this.setAlert({
                            color: 'success',
                            text: "Login berhasil.",
                            outline: false
                        })
                        this.setDialogStatus(false)
                        this.$router.push({name: 'home'})
                    } else {
                        this.setAlert({
                            color: 'error',
                            text: "Login gagal.",
                            outline: true
                        })
                    }
                }
            ).catch(
                (error) => {
                    this.setAlert({
                        color: 'error',
                        text: error.message,
                        outline: true
                    })
                }
            )
        }
    },
    mounted() {
        this.code = this.$route.query.code
        this.provider = this.$route.params.provider

        this.go(this.provider, this.code)
    }
}
</script>