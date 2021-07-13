<template>
    <div class="row">
           <div id="chat-component" v-bind:id="user.id" >
               <div class="card-body p-0" style="width:1740px;height:570px;">
                   <ul class="list-unstyled msg-body" style="height:530px; overflow-y:scroll" v-chat-scroll>
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                            <div v-if="message.sender_id == user.id" class="details mt-2" style="text-align:right;">
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
                                <small v-if="message.status == 0">Delivered</small>
                                <small v-else>Read</small>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                            <div class="details mt-2" v-else>
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
               <div class="form-popup" id="myForm" style="width: 1730px; margin-bottom: 90px; border: 1px solid black;">
                   <h1>jay ho</h1>
                   <h2>hello</h2>
                   <h3>jay mataji</h3>
                </div>
                <div style="display: flex; border:1px solid gray;width:1740px;" >
                <input
                    @keydown="sendTypingEvent"
                    v-on:keydown="keymonitor"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    style="width:1710px;height:38px;border: none;"
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
                data  : [],
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
                    this.messages.push(response.data.chatdata);
                }.bind(this))
                .catch(error => {
                    console.log(error.response)
                });
                this.newMessage = '';
            },
            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing',{'user':this.user,'otherUser':this.id});
            },
            keymonitor: function(event) {
                if(event.key == "@")
                {
                    if(event.target.value.length === 0)
                    {
                        document.getElementById("myForm").style.display = "block";
                    }
                    else if(event.target.value.length > 0 || event.target.value.length === ''){
                        document.getElementById("myForm").style.display = "none";
                    }
                }
                else{
                    document.getElementById("myForm").style.display = "none";
                }
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
                    this.messages.push(response.data.chatdata);
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
            }
        }
    }
</script>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>