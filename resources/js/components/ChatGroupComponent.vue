<template>
    <div class="row">
        </div>
</template>

<script>
 export default {

        props:['user','group'],
        
        data() {
            return {
                messages: [],
                message: [],
            }
        },
        created() {
            
            this.lastMessage();
            
            Echo.join('groupchat')
                .listen('GroupMessage',(event) => {
                    console.log(event.chat);
                    let result = this.messages;
                    for(let i=0;i<result.length;i++){
                        if(result[i].file == '')
                        {
                            $('#groupmessage'+result[i].group_id).html(decrypt(result[i].message));
                        }
                        else if(result[i].message == '')
                        {   
                           $('#groupmessage'+result[i].group_id).html(result[i].file);
                        }
                    }
                    if(event.chat.file == '')
                    {
                        $('#groupmessage'+event.chat.group_id).html(decrypt(event.chat.message));
                    }
                    else if(event.chat.message == '')
                    {   
                       $('#groupmessage'+event.chat.group_id).html(event.chat.file);
                    }
                })
            
        },
        methods: {
            lastMessage() {
                
                axios.get('/lastgroupmessage').then(response => {
                    console.log(response.data);
                    console.log(this.group);
                    this.messages = response.data;
                    let result = response.data;
                    for(let i=0;i<result.length;i++){
                        if(result[i].file == '')
                        {
                            $('#groupmessage'+result[i].group_id).html(decrypt(result[i].message));
                        }
                        else if(result[i].message == '')
                        {   
                           $('#groupmessage'+result[i].group_id).html(result[i].file);
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