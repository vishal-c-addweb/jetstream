<template>
   <div class="row">

       <div class="col-12">
           <div class="card card-default">
               <div class="card-body p-0">
                   <ul class="list-unstyled" style="height:300px; overflow-y:scroll">
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                            <div v-if="message.user.id == user.id" style="margin-left:1000px;">
                                <strong v-if="message.user.name">{{ message.user.name }}</strong>
                                </br>
                                {{ message.message }}   
                                </br>
                                <small>{{ message.created_at | formatDate}}</small>
                            </div>
                            <div v-else>
                                <strong v-if="message.user.name">{{ message.user.name }}</strong>
                                </br>
                                {{ message.message }}
                            </div>
                       </li>
                   </ul>
               </div>

               <input
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control">
           </div>
            <span class="text-muted" >user is typing...</span>
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
            }
        },
        created() {

            this.fetchMessage();

            Echo.join('chat')
                .listen('ChatMessage',(event) => {
                    console.log(event.chat);
                    this.messages.push(event.chat);
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
                this.messages.push({
                    message: this.newMessage,
                });
                axios.post('/messages/'+this.id, {message: this.newMessage})
                .catch(error => {
                            console.log(error.response)
                        });;
                this.newMessage = '';
            },
        }
    }
</script>