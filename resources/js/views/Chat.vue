<template>
    <v-card tile>
        <v-toolbar dense bottom elevation="2" tile color="primary" dark>
            <v-toolbar-title>Chat Admin</v-toolbar-title>
        </v-toolbar>

        <v-container fluid>

            <div class="chat-list">
                <div class="messages" v-for="(chat, index) in chats" :key="`chat-`+index">
                    <div class="user">
                        {{chat.users.name}} <small class="time">{{chat.created_at}}</small>
                    </div>
                    <div class="message">
                        {{chat.subject}}
                    </div>
                </div>
            </div>

            <v-form ref="form" lazy-validation v-model="valid">
                <v-textarea
                    color="primary"
                    placeholder="Type message here..."
                    rows="1"
                    append-icon="mdi-send"
                    @click:append.prevent=""
                ></v-textarea>
            </v-form>
        </v-container>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "Chat",
    data: () => ({
        chats: [],
        valid: true
    }),
    computed: {
        ...mapGetters({
            user: 'auth/user',
            guest: 'auth/guest'
        })
    },
    mounted() {
        let config = {
            headers: {
                'Authorization': 'Bearer ' + this.user.token
            }
        }
        axios.get('/api/chat', config).then(
            (response) => {
                let {response_data} = response.data
                this.chats = response_data.chats
                let chatList = document.getElementsByClassName('chat-list')[0]
                setTimeout(() => {
                    chatList.scrollTop = chatList.scrollHeight;
                }, 1);
            }
        ).catch(
            (error) => {
                console.log(error.message);
            }
        )
    },
    watch: {
        guest() {
            if (this.guest) {
                this.$router.push({name: 'home'})
            }
        }
    }
}
</script>

<style lang="scss">
    .chat-list {
        overflow: auto;
        padding: 0 15px;
        width: 100%;
        height: 50vh;
        .messages {
            margin-top: 5px;
            position: relative;
            .time {
                font-weight: 800;
                position: absolute;
                right: 0;
            }
            .message {
                padding: 5px 15px;
                font-size: 1.15rem;
                background-color: rgba(25, 118, 210, 0.2);
                border-radius: 0 20px 0 20px;
            }
        }
    }
</style>