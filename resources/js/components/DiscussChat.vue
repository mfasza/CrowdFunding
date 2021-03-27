<template>
    <v-card tile>

        <v-container fluid>
            <div class="row">
                <div class="col-9">
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

                <div class="col-3" style="border-left: solid 2px #eee">
                    <strong>Users Online : {{users.length}}</strong>
                    <ul style="list-style: none">
                        <li v-for="user in users" :key="`user-`+user.user_id">{{user.name}}</li>
                    </ul>
                </div>
            </div>
        </v-container>
        
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
import moment from 'moment';
export default {
    name: "Chat",
    data: () => ({
        chats: [],
        valid: true,
        pesan: '',
        users: []
    }),
    computed: {
        ...mapGetters({
            user: 'auth/user',
            guest: 'auth/guest'
        })
    },
    methods: {
        handleInput(e){
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault()
                this.sendMessage()
            }
        },
        sendMessage() {
            let input = this.pesan.trim();

            if(input !== "") {
                let newChat = {
                    subject: input,
                    created_at: moment().utc(0).format('YYYY-MM-DD HH:mm:ss'),
                    users: {name: this.user.user.name}
                }

                axios.post('/api/chat/store-discuss', {subject: this.pesan, channel: 'chat-channel'}, {headers: {'Authorization': 'Bearer ' + this.user.token}}).then(
                    (response) => {
                        this.chats.push(newChat);
                        this.pesan = ''
        
                        this.scrollPage();
                    }
                )
            }

        },
        scrollPage() {
            let chatList = document.getElementsByClassName('chat-list')[0]
            setTimeout(() => {
                chatList.scrollTop = chatList.scrollHeight;
            }, 1);
        }
    },
    mounted() {
        let config = {
            headers: {
                'Authorization': 'Bearer ' + this.user.token
            }
        }
        axios.get('/api/chat/get-discuss', config).then(
            (response) => {
                let {response_data} = response.data
                this.chats = response_data.chats
                
                this.scrollPage();
            }
        ).catch(
            (error) => {
                console.log(error.message);
            }
        )

        Echo.connector.pusher.config.auth.headers['Authorization'] = 'Bearer ' + this.user.token;
        Echo.join('chat-channel')
            .here((users) => {
                this.users = users
            })
            .joining((user) => {
                this.users.push(user)
            })
            .leaving((user) => {
                this.users = this.users.filter((u) => {
                    return u.user_id !== user.user_id
                })
            })
            .listen('ChatStoredEvent' , (e) => {
                let data = e.data;
                let newChat = {
                    subject: data.subject,
                    created_at: data.created_at,
                    users: {name: data.users.name}
                }
                this.chats.push(newChat);
                this.scrollPage();
            });
    },
    destroyed() {
        Echo.leave('chat-channel');
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
    }
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
</style>