<template>
    <div class="row">
           <div>
               <div class="card-body p-0" style="width:1160px;">
                   <ul class="list-unstyled msg-body" style="height:420px; overflow-y:scroll" v-chat-scroll>
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                            <div v-if="message.sender_id == user.id" class="details mt-2" style="text-align:right;">
                                <b v-if="message.message!=''">{{ decrypt(message.message) }}</b>
                                    <b v-on:click="preview($event)"  v-bind:id="message.file" else>{{ message.file }}</b>
                                </br>
                                <small v-if="message.status == 0">Delivered</small>
                                <small v-else>Read</small>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                            <div class="details mt-2" v-else>
                                <b v-if="message.message!=''">{{ decrypt(message.message) }}</b>    
                                    <b id="imageresource" v-bind:id="message.file" v-on:click="preview($event)" else>{{ message.file }}</b>
                                </br>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                       </li>
                   </ul>
               </div>
               <span class="text-muted ml-2" v-if="activeUser && otherUser" >{{ activeUser.name }} is typing...</span>
                <div style="display: flex; border:1px solid gray;width:1150px;" >
                <input
                    @keydown="sendTypingEvent"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    style="width:1110px;height:38px;border: none;"
                    class="form-control">
                    
                    <button  @click="onPickFile"><i class="fa fa-file ml-1 "></i></button>
                    <input
                        type="file"
                        name="file"
                        id="file"
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
                filename: '',
                file: '',
            }
        },
        created() {
            
            let r_id = this.user.id;

            this.fetchMessage();
            
            Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);                
                })
                .listen('ChatMessage',(event) => {
                    console.log(event.chat);
                    if(event.chat.receiver_id == r_id && event.chat.sender_id == this.id){
                        this.messages.push(event.chat);
                    }
                })
                .listenForWhisper('typing', response => {
                    this.activeUser = response.user;
                    this.otherUser = response.otherUser;
                    if(this.user.id == response.otherUser && this.id == response.user.id)
                    {
                        if(this.typingTimer) {
                            clearTimeout(this.typingTimer);
                        }
                        this.typingTimer = setTimeout(() => {
                            this.activeUser = false;
                            this.otherUser = false;
                        }, 500);
                    }
                    else{
                        this.activeUser = false;
                        this.otherUser = false;
                    }
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
                    let message = decrypt(response.data.chatdata.message);
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
                this.file = event.target.files[0];
                console.log(this.file);
               
                let formData = new FormData();

                formData.append('file',this.file);
                axios.post('/messages/'+this.id, 
                formData,
                {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                ).then(function (response) {
                    console.log(response.data.chatdata);
                    let file = response.data.chatdata.file;
                    let created_at = response.data.chatdata.created_at;
                    let status = "";
                    let msg = '<li class = "p-2" ><div style="text-align:right;"><b v-bind:id="'+file+'" v-on:click="preview($event)">'+file+'</b></br><small>Delivered</small>&nbsp;<small>'+moment(created_at).format('hh: mm: a')+'</small></div></li>';
                    $('.msg-body').append(msg);
                })
                .catch(error => {
                    console.log(error.response)
                });
                this.newMessage = '';
            },    
            decrypt(encrypted) {
                let key = process.env.MIX_APP_KEY.substr(7);
                var encrypted_json = JSON.parse(atob(encrypted));
                return CryptoJS.AES.decrypt(encrypted_json.value, CryptoJS.enc.Base64.parse(key), {
                    iv : CryptoJS.enc.Base64.parse(encrypted_json.iv)
                }).toString(CryptoJS.enc.Utf8);
            },
            preview(event){
                let imag = event.currentTarget.id;
                let fileExt = imag.split('.').pop();
                let url = $('#appUrl').html();
                let path = url+'/assets/uploads/'+imag;
                if(fileExt == 'png' || fileExt == 'jpg' || fileExt == 'jpeg'){
                    document.getElementById('imagepreview').src=path;
                    $('#imagemodal').modal('show');
                }
                else if(fileExt == 'mp4' || fileExt == 'mp3'){
                    document.getElementById('cartoonVideo').src=path;
                    $('#myModal').modal('show');
                }
                else if(fileExt == 'pdf'){
                    document.getElementById('openWith').style.display="block";
                    document.getElementById('openWith').src="http://docs.google.com/viewer?url=<?=urlencode('+imag+')?>&embedded=true";
                    
                }
            }
        }
    }
</script>
