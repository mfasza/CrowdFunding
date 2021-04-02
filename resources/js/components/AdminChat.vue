<template>
    <v-card tile>

        <v-container fluid v-if="user.user.roles.role !== 'admin'">
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

        <v-container fluid v-else>
            <div class="row">
                <div class="col-3" style="border-right: solid 2px #eee; overflow: auto">
                    <!-- <v-list> -->
                        <v-list-item-group v-model="selected" color="indigo">
                            <v-list-item
                                v-for="(user, i) in users"
                                :key="`user-`+i"
                                @click="getChats(user.user_id)"
                            >
                                <v-list-item-avatar>
                                    <v-img :src="user.photo"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title v-text="user.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    <!-- </v-list> -->
                </div>
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
                    <v-form ref="form" lazy-validation v-model="valid" class="d-flex align-end">
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
import moment from 'moment'
import { mapGetters } from 'vuex'
    export default {
        name: "chat-admin",
        data: () => ({
            chats: [],
            pesan: '',
            valid: true,
            users: [],
            selected: null
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
                let newChat = {
                    subject: this.pesan,
                    created_at: moment().utc(0).format('YYYY-MM-DD HH:mm:ss'),
                    users: {name: this.user.user.name}
                }
                let url = '';

                if (this.user.user.roles.role === 'admin') {
                    url = '/api/chat/store-admin/' + this.users[this.selected].user_id
                } else {
                    url = '/api/chat/store-admin/' + this.user.user.user_id
                }
                
                axios.post(url, {subject: this.pesan}, {"headers" : {"Authorization": "Bearer " + this.user.token}}).then(
                    (response) => {
                        this.chats.push(newChat);
                        this.pesan = '';
                    }
                ).catch(
                    (error) => {
                        console.log(error);
                    }
                )

            },
            scrollPage(){
                let chatList = document.getElementsByClassName('admin-chat-list')[0];
                setTimeout(() => {
                    chatList.scrollTop = chatList.scrollHeight;
                }, 1);
            },
            getChats(user_id) {
                // get specific user chats
                axios.get('/api/chat/get-admin/'+user_id, {headers: {'Authorization': "Bearer " + this.user.token}}).then(
                    (response) => {
                        let {response_data} = response.data;
                        this.chats = response_data.chats;
                        this.scrollPage();
                    }
                )
            }
        },
        mounted() {
            // get all users data
            axios.get('/api/chat/get-all-users', {headers: {'Authorization': 'Bearer ' + this.user.token}}).then(
                    (response) => {
                        let {response_data} = response.data;
                        let users = response_data.users;
                        users = users.filter((user) => {
                            return user.user_id !== this.user.user.user_id
                        });
                        this.users = users;
                    }
                ).catch(
                    (error) => {
                        console.log(error);
                    }
                )

            // load chat if not admin
            if (this.user.user.roles.role !== 'admin') {
                this.getChats(this.user.user.user_id);
            }
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