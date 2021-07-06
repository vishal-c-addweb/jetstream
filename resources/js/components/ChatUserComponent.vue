<template>
    <div class="row">
        </div>
</template>

<script>
 export default {

        props:['user','receiver'],
        
        data() {
            return {
                messages: [],
                message: [],
            }
        },
        created() {
            
            this.lastMessage();
            
            Echo.join('chat')
                .listen('ChatMessage',(event) => {
                    console.log(event.chat);
                    console.log(this.messages);
                    console.log(this.user);
                    console.log(this.receiver);
                    this.message.push(event.chat);
                    this.messages.push(event.chat);
                    let result = this.messages;
                    let count=0;
                    for(let i=0;i<result.length;i++){
                        if(result[i].status == 0){
                            $('#msgcount'+result[i].sender_id+result[i].receiver_id).prop({style:"background-color:gray;padding:10px;border: none;color: white;margin-bottom:5px;text-align: center;border-radius: 50%;"});    
                            count+=1;
                        }
                        else{
                            count = null;
                        }
                        if(result[i].file == '')
                        {
                            $('#msgcount'+result[i].sender_id+result[i].receiver_id).html(count);
                            $('#msg'+result[i].sender_id+result[i].receiver_id).html(decrypt(result[i].message));
                            $('#msg'+result[i].receiver_id+result[i].sender_id).html(decrypt(result[i].message));
                        }
                        else if(result[i].message == '')
                        {   
                            $('#msgcount'+result[i].sender_id+result[i].receiver_id).html(count);
                            $('#msg'+result[i].sender_id+result[i].receiver_id).html(result[i].file);
                            $('#msg'+result[i].receiver_id+result[i].sender_id).html(result[i].file);
                        }
                        
                    }
                    if(event.chat.file == '')
                    {
                        $('#msg'+event.chat.sender_id+event.chat.receiver_id).html(decrypt(event.chat.message));
                    }
                    else if(event.chat.message == '')
                    {   
                       $('#msg'+event.chat.sender_id+event.chat.receiver_id).html(event.chat.file);
                    }
                    
                })
        },
        methods: {
            lastMessage() {
                
                axios.get('/lastmessage/'+this.user).then(response => {
                    console.log(response.data);
                    this.messages = response.data;
                    let result = response.data;
                    for(let i=0;i<result.length;i++){
                        if(result[i].file == '')
                        {
                            $('#msg'+result[i].sender_id+result[i].receiver_id).html(decrypt(result[i].message));
                            $('#msg'+result[i].receiver_id+result[i].sender_id).html(decrypt(result[i].message));
                        }
                        else if(result[i].message == '')
                        {   
                            $('#msg'+result[i].sender_id+result[i].receiver_id).html(result[i].file);
                            $('#msg'+result[i].receiver_id+result[i].sender_id).html(result[i].file);
                        }
                    }
                })
                .catch(error => {
                    console.log(error.response)
                });
            },

        }
    }
</script>