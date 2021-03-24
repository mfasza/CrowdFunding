<template>
    <v-card tile>
        <v-toolbar dense bottom elevation="2" tile color="primary" dark>
            <v-toolbar-title>Chat Admin</v-toolbar-title>
        </v-toolbar>

        <v-container fluid>
            <div class="row">
                <div class="col">
                    <div class="admin-chat-list">
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
                            v-model="pesan"
                            color="primary"
                            placeholder="Type message here..."
                            rows="1"
                            append-icon="mdi-send"
                            @click:append="sendMessage"
                            @keydown="handleInput"
                        ></v-textarea>
                    </v-form>
                </div>
            </div>
        </v-container>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex'
    export default {
        name: "chat-admin",
        data: () => ({
            chats: [],
            pesan: '',
            valid: true
        }),
        computed: {
            ...mapGetters({
                user: 'auth/user'
            })
        },
        methods: {
            handleInput(e){
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault()
                    this.sendMessage()
                }
            },
            sendMessage(){
                // 
            },
            scrollPage(){
                let chatList = document.getElementsByClassName('admin-chat-list')[0];
                setTimeout(() => {
                    chatList.scrollTop = chatList.scrollHeight;
                }, 1);
            }
        },
        mounted() {
            // get specific user chats
            axios.get('/api/chat/get-admin', {headers: {'Authorization': "Bearer " + this.user.token}}).then(
                (response) => {
                    let {response_data} = response.data;
                    this.chats = response_data.chats;
                    this.scrollPage();
                }
            )
        }
    }
</script>

<style lang="scss">
    .admin-chat-list {
        overflow: auto;
        padding: 0 15px;
        width: 100%;
        height: 50vh;
    }
</style>