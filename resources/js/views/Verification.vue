<template>
    <v-container fluid>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
                v-model="otp"
                :rules="otpRules"
                label="Kode OTP"
                maxlength="6"
                counter
                required
                @keypress.enter.prevent=""
                append-icon="mdi-key"
            ></v-text-field>

            <div class="text-xs-center d-flex justify-space-between align-center">
                <v-btn
                    color="success lighten-1"
                    :disabled="!valid"
                    @click="verif"
                > Verifikasi <v-icon dark right medium>mdi-send</v-icon> </v-btn>
                <a class="text-decoration-none" @click.prevent="regenerate = !regenerate">Regenerate OTP Code</a>
            </div>
        </v-form>

        <v-form ref="formRegenerate" v-model="valid" lazy-validation>

            <div v-show="regenerate">
                <v-divider></v-divider>
                <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="E-mail"
                    required
                    append-icon="mdi-email"
                ></v-text-field>

                 <div class="text-xs-center d-flex justify-space-between align-center">
                    <v-btn
                        color="primary lighten-1"
                        :disabled="!valid"
                        @click="generateOtp"
                    > send OTP Code </v-btn>
                </div>
            </div>
        </v-form>
    </v-container>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: 'emailVerification',
    data() {
        return {
            valid: true,
            otp: "",
            otpRules: [
                v => !!v || 'OTP Code required.',
                v => /^\d+$/.test(v) || 'OTP Code must be a number.',
                v => /^.{6,}$/.test(v) || 'Minimum 6 digit OTP Code'
            ],
            email: "",
            emailRules: [
                v => !!v || 'E-mail is required.',
                v=> /.+@.+\..+/.test(v) || 'Email must be valid'
            ],
            regenerate: false
        }
    },
    methods: {
        ...mapActions({
            setAlert: 'alert/showAlert',
            setDialogComponent: 'dialog/setComponent',
            setAuth: 'auth/set'
        }),
        verif() {
            if (this.$refs.form.validate()) {
                let formData = {
                    otp_code: this.otp
                }
                axios.post("/api/auth/verification", formData).then(
                    (response) => {
                        let {response_code,response_message, response_data} = response.data
                        this.setAuth(response_data)
                        this.$refs.form.reset()
                        this.$refs.form.resetValidation()

                        if (response_code == '01') {
                            this.setAlert({
                                color: 'error',
                                text: response_message,
                                outline: true
                            })
                        } else {
                            this.setAlert({
                                color: 'success',
                                text: response_message,
                                outline: false
                            })
                            this.$router.push({name: 'home'})
                            this.setDialogComponent('UpdatePassword')
                        }
                    }
                ).catch(
                    (error) => {
                        console.log(error);
                    }
                )
            }
        },
        generateOtp() {
            if (this.$refs.formRegenerate.validate()) {
                let formData = {
                    email: this.email
                }
                axios.post("/api/auth/regenerate-otp", formData).then(
                    (response) => {
                        let {response_code,response_message} = response.data
                        this.$refs.formRegenerate.reset()
                        this.$refs.formRegenerate.resetValidation()

                        if (response_code == '01') {
                            this.setAlert({
                                color: 'error',
                                text: response_message,
                                outline: true
                            })
                        } else {
                            this.setAlert({
                                color: 'success',
                                text: response_message,
                                outline: false
                            })
                        }
                    }
                ).catch(
                    (error) => {
                        console.log(error);
                    }
                )
            }
        }
    }
}
</script>