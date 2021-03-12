<template>
    <v-card>
        <v-toolbar dark color="success" dense>
            <v-toolbar-title class="p-2">Update Password</v-toolbar-title>
        </v-toolbar>

        <v-container fluid>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="E-mail"
                    required
                    readonly
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
                <v-text-field
                    v-model="password_confirmation"
                    :rules="passwordRules"
                    type="password"
                    label="Password Confrimation"
                    hint="At least 6 characters"
                    counter
                ></v-text-field>

                <v-divider></v-divider>

                <div class="text-xs-center d-flex flex-column justify-center">
                    <v-btn
                        color="primary lighten-1"
                        :disabled="!valid"
                        @click="submit"
                        tile
                    > Confirm Password <v-icon right dark dense>mdi-check</v-icon> </v-btn>
                </div>
            </v-form>
        </v-container>
    </v-card>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: 'UpdatePassword',
    data() {
        return {
            valid: true,
            emailRules: [
                v => !!v || 'E-mail is required.',
                v=> /.+@.+\..+/.test(v) || 'Email must be valid'
            ],
            showPassword: false,
            password: '',
            password_confirmation: "",
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >=6) || 'Min 6 characters'
            ]
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        email() {
            return this.user.user.email
        }
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
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }
                axios.post('/api/auth/update-password', formData).then(
                    (response) => {

                        let loginData = {
                            email: this.email,
                            password: this.password
                        }

                        axios.post('/api/auth/login', loginData).then(
                            (response) => {
                                let {response_data} = response.data
                                this.setAuth(response_data)
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

                        this.$refs.form.reset()
                        this.$refs.form.resetValidation()

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