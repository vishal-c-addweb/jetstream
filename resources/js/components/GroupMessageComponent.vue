<template>
    <div class="row">
           <div>
               <div class="card-body p-0" style="width:1740px;height:700px;">
                   <ul class="list-unstyled msg-body" style="height:650px; overflow-y:scroll" v-chat-scroll>
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                            <div v-if="message.user_id == user.id" class="details mt-2" style="text-align:right;">
                                <b v-if="message.message!=''">{{ decrypt(message.message) }}</b>
                                    <div v-if="message.message==''">        
                                        <button style="background-color:gray;border:1px solid black;padding:10px;border-radius:4%;">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.png') || message.file.includes('.jpg') || message.file.includes('.jpeg')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/imageicon.png">
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.mp4') || message.file.includes('.mp3')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/videoicon.png">
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.pdf')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/pdficon.png">
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.sql') || message.file.includes('.txt')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/texticon.png">    
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.zip')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/zipicon.png">    
                                                    </td>
                                                &nbsp;&nbsp;
                                                <b style="color:white;" else>{{ message.file }}</b>
                                                </tr>
                                            </table>
                                        </button>
                                    </div>
                                </br>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                            <div class="details mt-2" v-else>
                                <p>{{message.user.name}}</p>
                                <b v-if="message.message!=''">{{ decrypt(message.message) }}</b>    
                                    <div v-if="message.message==''">        
                                        <button style="background-color:gray;border:1px solid black;padding:10px;border-radius:4%;">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.png') || message.file.includes('.jpg') || message.file.includes('.jpeg')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/imageicon.png">
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.mp4') || message.file.includes('.mp3')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/videoicon.png">
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.pdf')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/pdficon.png">
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.sql') || message.file.includes('.txt')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/texticon.png">
                                                        <img v-on:click="preview($event)" v-if="message.file.includes('.zip')" v-bind:id="message.file" style="border:1px solid black;width:34px;height:38px;" src="http://127.0.0.1:8000/assets/uploads/zipicon.png">    
                                                    </td>
                                                &nbsp;&nbsp;
                                                <b style="color:white;" else>{{ message.file }}</b>
                                                </tr>
                                            </table>
                                        </button>
                                    </div>
                                </br>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                       </li>
                   </ul>
               </div>
               <span class="text-muted ml-2" v-if="activeUser && otherUser" >{{ activeUser.name }} is typing...</span>
               <div class="form-popup" id="wordForm" style="width: 1730px; margin-bottom: 90px;">
                
                        <tr>
                            <td v-for="(pred_msg,index) in predefined_messages" :key="index" >
                               <a v-bind:id="pred_msg" v-on:click="msg_click($event)" style="background-color:#E7EDF6;">&nbsp;&nbsp;~{{pred_msg}}</a>
                            </td>
                        </tr>
                </div>
               <div class="form-popup" id="myForm" style="width: 1730px; margin-bottom: 90px; border: 1px solid black;">
                    <div style="overflow:scroll;height:150px;background-color:#E7EDF6;">
                        <ul>
                            <li>&nbsp;&nbsp;People</li>
                        </ul>
                        <div style="margin-left:80px;">
                            <ul v-for="(user, index) in usergroup" :key="index" style="display:flex;">
                                <li style="display:flex;"><img v-bind:src="user.user.profile_photo_url" style="height:30px;width:30px;margin-top:2px;" alt="" />&nbsp;:&nbsp;<button v-on:click="uname($event)" id="" v-bind:id="user.user.name">{{user.user.name}}</button></li>
                                <small style="margin-top: 6px;margin-left:1400px;">All Group Members</small>
                            </ul>
                        </div>
                    </div>
                </div>
                <div style="display: flex; border:1px solid gray;width:1740px;" >
                <input
                    @keydown="sendTypingEvent"
                    v-on:keydown="keymonitor"
                    v-model="newMessage"
                    id="input-id"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    style="width:1710px;height:38px;border: none;"
                    class="form-control input-form">
                    
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

        props:['user','group','usergroup'],
        
        data() {
            return {
                messages: [],
                newMessage : "",
                users:[],
                activeUser: false,
                otherUser: false,
                typingTimer: false,
                filename: '',
                file: '',
                predefined_messages : [],
            }
        },
        created() {
            this.fetchMessage();
            
            Echo.join('groupchat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);                
                })
                .listen('GroupMessage',(event) => {
                    console.log(event.chat);
                    if(event.chat.group_id == this.group.id ){
                        this.messages.push(event.chat);
                        if(event.chat.user_id != this.user.id){
                            let message = decrypt(event.chat.message);
                            if(message.toLowerCase().includes("good morning"))
                            {
                                this.predefined_messages = [];
                                let msg = ['good morning', 'good afternoon','good evening','good night'];
                                this.predefined_messages = msg;
                                document.getElementById("wordForm").style.display = "block";
                            }
                            else if(message.toLowerCase().includes("hy"))
                            {
                                this.predefined_messages = [];
                                let msg = ['Hello', 'Kese ho ap log','How are you?'];
                                this.predefined_messages = msg;
                                document.getElementById("wordForm").style.display = "block";
                            }
                            else if(message.toLowerCase().includes("hello"))
                            {
                                this.predefined_messages = [];
                                let msg = ['Hy', 'Kese ho ap log','How are you?','jay mataji'];
                                this.predefined_messages = msg;
                                document.getElementById("wordForm").style.display = "block";
                            }
                            else if(message.toLowerCase().includes("how are you?"))
                            {
                                this.predefined_messages = [];
                                let msg = ['fine'];
                                this.predefined_messages = msg;
                                document.getElementById("wordForm").style.display = "block";
                            }
                        }
                    }
                })
                .listenForWhisper('typing', response => {
                    this.activeUser = response.user;
                    this.otherUser = response.otherUser;
                    if(this.group.id == response.otherUser)
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
                axios.get('/groupmessages/'+this.group.id).then(response => {
                    console.log(response);
                    this.messages = response.data;
                    let last_record = response.data[response.data.length - 1];
                   //console.log(last_record.user_id);
                    if(last_record.user_id != this.user.id)
                    {
                        let message = decrypt(last_record.message);
                        if(message.toLowerCase().includes("good morning"))
                        {
                            this.predefined_messages = [];
                            let msg = ['good morning', 'good afternoon','good evening','good night'];
                            this.predefined_messages = msg;
                            document.getElementById("wordForm").style.display = "block";
                        }
                        else if(message.toLowerCase().includes("hy"))
                        {
                            this.predefined_messages = [];
                            let msg = ['Hello', 'Kese ho ap log','How are you?'];
                            this.predefined_messages = msg;
                            document.getElementById("wordForm").style.display = "block";
                        }
                        else if(message.toLowerCase().includes("hello"))
                        {
                            this.predefined_messages = [];
                            let msg = ['Hy', 'Kese ho ap log','How are you?'];
                            this.predefined_messages = msg;
                            document.getElementById("wordForm").style.display = "block";
                        }
                        else if(message.toLowerCase().includes("how are you?"))
                        {
                            this.predefined_messages = [];
                            let msg = ['fine'];
                            this.predefined_messages = msg;
                            document.getElementById("wordForm").style.display = "block";
                        }
                    }
                })
                .catch(error => {
                    console.log(error.response)
                });
            },
            sendMessage() {  
                document.getElementById("wordForm").style.display = "none";
                this.predefined_messages = [];
                axios.post('/groupmessages/'+this.group.id, {message: this.newMessage}).then(function (response) {
                    console.log(response.data);
                    this.messages.push(response.data.message);
                }.bind(this))
                .catch(error => {
                    console.log(error.response)
                });
                this.newMessage = '';
            },
            sendTypingEvent() {
                Echo.join('groupchat')
                    .whisper('typing',{'user':this.user,'otherUser':this.group.id});
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
                axios.post('/groupmessages/'+this.group.id, 
                formData,
                {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                ).then(function (response) {
                    console.log(response.data);
                    this.messages.push(response.data.message);
                }.bind(this))
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
                else if(fileExt == 'pdf' || fileExt == 'txt' || fileExt == 'sql' || fileExt == 'zip'){
                    document.getElementById('openWith').src=path;
                    let newurl = document.getElementById('openWith').src;
                    let tabOrWindow = window.open(newurl, '_blank');
                    tabOrWindow.focus();
                }
            },
            keymonitor: function(event) {
                if(event.key == "@")
                {
                    //alert(event.key);
                    //alert(event.target.value);
                    document.getElementById("myForm").style.display = "block";
                }
                else{
                    document.getElementById("myForm").style.display = "none";
                }
            },
            uname(event){
                alert(event.currentTarget.id);
                alert(document.getElementById('input-id').value);
                document.getElementById("myForm").style.display = "none";
                let input_value = document.getElementById('input-id').value
                document.getElementById('input-id').value=input_value+event.currentTarget.id+":";
            },
            msg_click(event){
                document.getElementById("wordForm").style.display = "none";
                let input_value = document.getElementById('input-id').value
                document.getElementById('input-id').value=input_value+":"+event.currentTarget.id;
                this.newMessage = input_value+" "+event.currentTarget.id;
            },
        }
    }
</script>