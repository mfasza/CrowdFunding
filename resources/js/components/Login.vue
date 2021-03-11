<template>
    <v-card>
        <v-toolbar dark color="success">
            <v-btn icon dark @click.native="close">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-toolbar>
        <v-toolbar-title class="p-2">Login</v-toolbar-title>

        <v-divider></v-divider>

        <v-container fluid>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="E-mail"
                    required
                    append-icon="mdi-email"
                ></v-text-field>
                <v-text-field
                    v-model="password"
                    :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                    :rules="passwordRules"
                    :type="showPassword ? 'text': 'password'"
                    label="Password"
                    hint="At least 6 characters"
                    counter
                    @click:append="showPassword = !showPassword"
                ></v-text-field>

                <div class="text-xs-center">
                    <v-btn
                        color="success lighten-1"
                        :disabled="!valid"
                        @click="submit"
                    > Login <v-icon right dark>mdi-lock-open</v-icon> </v-btn>
                </div>
            </v-form>
        </v-container>
    </v-card>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: 'Login',
    data() {
        return {
            valid: true,
            email: "",
            emailRules: [
                v => !!v || 'E-mail is required.',
                v=> /.+@.+\..+/.test(v) || 'Email must be valid'
            ],
            showPassword: false,
            password: '',
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >=6) || 'Min 6 characters'
            ]
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    },
    methods: {
        ...mapActions({
            setAlert: 'alert/showAlert',
            setAuth: 'auth/set'
        }),
        submit() {
            if (this.$refs.form.validate()) {
                let formData = {
                    email: this.email,
                    password: this.password
                }
                axios.post('/api/auth/login', formData).then(
                    (response) => {
                        let {response_data} = response.data
                        this.setAuth(response_data)
                        this.$refs.form.reset()
                        this.$refs.form.resetValidation()
                        if(this.user.user.user_id.length>0){
                            this.setAlert({
                                color: 'success',
                                text: "Login Success.",
                                outline: false
                            })
                            this.close()
                        } else {
                            this.setAlert({
                                color: 'error',
                                text: "Login Failed.",
                                outline: true
                            })
                        }
                    }
                ).catch(
                    (error) => {
                        let {data, status} = error.response
                        let text = data.error

                        if (status === 422) {
                            let errors = data.errors
                            text = errors[Object.keys(errors)[0]][0]
                        }
                        this.setAlert({
                            color: 'error',
                            text: text,
                            outline: true
                        })
                    }
                )
            }
        },
        close() {
            this.$emit('closed', false);
        }
    }
}
</script>