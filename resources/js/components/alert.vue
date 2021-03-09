<template>
    <v-snackbar
        v-model="show"
        :timeout="timeout"
    >
      {{ text }}

        <template v-slot:action="{ attrs }">
            <v-btn
                color="red"
                text
                v-bind="attrs"
                @click="show = false"
            >
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
    export default {
        name: 'donate-alert',
        computed: {
            ...mapGetters({
                snackbar: 'alert/snackbar',
                text: 'alert/text',
                timeout: 'alert/timeout',
            }),
            show: {
                get: function(){
                    return this.snackbar
                },
                set: function(value){
                    this.hideSnackbar(value)
                }
            }
        },
        methods: {
            ...mapActions({
                hideSnackbar: 'alert/hideAlert'
            })
        }
    }
</script>