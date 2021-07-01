<template>
    <div class="row">
           <div>
               <div class="card-body p-0" style="width:1160px;">
                   <ul class="list-unstyled msg-body" style="height:420px; overflow-y:scroll" v-chat-scroll>
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                            <div v-if="message.sender_id == user.id" class="details mt-2" style="text-align:right;">
                                <b v-if="message.message!=''">{{ message.message }}</b>
                                <b else>{{ message.file }}</b>   
                                </br>
                                <small v-if="message.status == 0">Delivered</small>
                                <small v-else>Read</small>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                            <div class="details mt-2" v-else>
                                <b v-if="message.message!=''">{{ message.message }}</b>
                                <b else>{{ message.file }}</b>    
                                </br>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                            <span class="text-muted ml-2" v-if="activeUser && otherUser" >{{ activeUser.name }} is typing...</span>
                       </li>
                   </ul>
               </div>
                <div style="display: flex; border:1px solid gray;width:1150px;" >
                <input
                    @keydown="sendTypingEvent"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    style="width:1110px;height:38px;border: none;"
                    class="form-control">
                    <button  @click="onPickFile"><i class="fa fa-file ml-1"></i></button>
                    <input
                        type="file"
                        style="display: none"
                        ref="fileInput"
                        @change="onFilePicked"/>
                    <button v-on:click="sendMessage" style="width:35px;height:40px;text-align:center;"><i class="fa fa-telegram"></i></button>
                </div>
           </div>
        </div>
</template>

<script>
    export default {

        props:['user','id'],
        
        data() {
            return {
                messages: [],
                newMessage: '',
                users:[],
                activeUser: false,
                otherUser: false,
                typingTimer: false,
                image: null
            }
        },
        created() {

            let r_id = this.user.id;

            this.fetchMessage();
            
            Echo.join('chat')
                .listen('ChatMessage',(event) => {
                    console.log(event.chat);
                    if(event.chat.receiver_id == r_id && event.chat.sender_id == this.id)
                    {
                        this.messages.push(event.chat);
                    }
                })
                .listenForWhisper('typing', response => {
                    this.activeUser = response.user;
                    this.otherUser = response.otherUser;
                    if(this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }
                   this.typingTimer = setTimeout(() => {
                       this.activeUser = false;
                       this.otherUser = false;
                   }, 500);
                })
        },
        methods: {
            fetchMessage() {
                axios.get('/messages/'+this.id).then(response => {
                    console.log(response);
                    this.messages = response.data;
                })
                .catch(error => {
                    console.log(error.response)
                });
            },
            sendMessage() {
                
                axios.post('/messages/'+this.id, {message: this.newMessage}).then(function (response) {
                    console.log(response.data.chatdata);
                    let message = response.data.chatdata.message;
                    let created_at = response.data.chatdata.created_at;
                    let status = "";
                    let msg = '<li class = "p-2" ><div style="text-align:right;"><b>'+message+'</b></br><small>Delivered</small>&nbsp;<small>'+moment(created_at).format('hh: mm: a')+'</small></div></li>';
                    $('.msg-body').append(msg);
                })
                .catch(error => {
                    console.log(error.response)
                });
                this.newMessage = '';
            },
            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing',{'user':this.user,'otherUser':this.id});
            },
            previewFiles(event) {
                console.log(event.target.files);
            },
            onPickFile () {
                this.$refs.fileInput.click()
            },
            onFilePicked (event) {
                const files = event.target.files
                let filename = files[0].name
                const fileReader = new FileReader()
                fileReader.addEventListener('load', () => {
                    this.imageUrl = fileReader.result
                })
                fileReader.readAsDataURL(files[0])
                this.image = files[0]
                axios.post('/messages/'+this.id, {file: filename}).then(function (response) {
                    let file = response.data.chatdata.file;
                    let created_at = response.data.chatdata.created_at;
                    let status = "";
                    let msg = '<li class = "p-2" ><div style="text-align:right;"><b>'+file+'</b></br><small>Delivered</small>&nbsp;<small>'+moment(created_at).format('hh: mm: a')+'</small></div></li>';
                    $('.msg-body').append(msg);
                })
                .catch(error => {
                    console.log(error.response)
                });
                this.newMessage = '';
            }
        }
    }
</script>