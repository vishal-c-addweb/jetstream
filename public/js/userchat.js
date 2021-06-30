function sendMessage(id)
{   
    const receiverid = document.getElementById('incoming_id').value;
    const senderid = document.getElementById('outgoing_id').value;
    
    let receiverId = id;
    let url = document.getElementById('fileToUpload').value;
    let file = url.replace(/^.*[\\\/]/, '')
    
    let content = document.getElementById('chatMsg').value;
    
    $.ajax({
        url:"/chat/sendmessage",
        type:'post',
        data:{receiverId:receiverId,content:content,file:file},
        dataType: 'json',                            
        success:function(response){
            let result = response.chat;
            let message = "";
            let status = "";

                if(result.status == 0){
                    status += 'Delivered';
                }
                else if(result.status == 1){
                    status += 'read';
                }
            
                let file = '';
            
                if(result.message == ''){   
                    file += '<p>'+result.file+'</p>';
                }
                else{
                    file += '<p>'+decrypt(result.message)+'</p>';
                }
                
                let time = moment(result.time).format('h:mm a');
                
                if(result.receiver_id == receiverid && result.sender_id == senderid){
                    message += '<div class="chat outgoing">'+
                                    '<div class="details">'+
                                        file+
                                        '<small class="ml-5">'+status+'&nbsp;&nbsp;'+time+'</small>'+
                                    '</div>'+
                                '</div>';
                }
                else if(result.sender_id == receiverid && result.receiver_id == senderid){
                    message += '<div class="chat incoming">'+
                                    '<div class="details">'+
                                        file+
                                        '<small class="">'+time+'</small>'+
                                    '</div>'+
                                '</div>';
                }
            
                $('.chat-box').append(message);

            document.getElementById('chatMsg').value = "";
            $(".deactive").animate({ scrollTop: $(".deactive")[0].scrollHeight });
        },
        error: function (error) {
            console.log(error);
        }
    });
}

$('#searchBar').on('keyup',function(e) {
    
    let search = $('#searchBar').val();
    
    $.ajax({
            url:"/chat/search",
            type:'post',
            data:{search:search},
            dataType: 'json',
            success:function(response){
                
                console.log(response);
                
                let result = response.search;
                let searchUser="";
                
                for(let i=0;i<result.length;i++){
                    searchUser += '<a href="chats/'+result[i].id+'">'+
                                        '<div class="content">'+
                                        '<img src="'+result[i].profile_photo_url+'" alt="">'+
                                        '<div class="details">'+
                                            '<span>'+result[i].name+'</span>'+
                                            '<p id="msg/'+result[i].id+'"></p>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="status-dot . offline><i class="fa fa-circle"></i></div>'+
                                    '</a>';
                }
                
                $('.users-list').hide();
                $('.search-users-list').html(searchUser);
                
                if($("#searchBar").val().length>0){
                    $('.users-list').hide();
                    $('.search-users-list').show();
                }
                else{
                    $('.search-users-list').hide();
                    $('.users-list').show();
                }
            }   
        });
});

$("#chatMsg").keypress(function(){
    
    numMiliseconds = 500;
    
    const id = document.getElementById('incoming_id').value;
    const userId = document.getElementById('outgoing_id').value;
    
    if ($("#chatMsg").val().length>0){
        $('#typing_on').html('typing...');
    }
    else{
        $("#typing_on").hide();
    }
});

$(document).ready(function () {
const id = document.getElementById('incoming_id').value;
const userId = document.getElementById('outgoing_id').value;

    $.ajax({
        url:"/chat/chatuser",
        type:'post',
        data:{id:id},
        dataType: 'json',
        success:function(response){
            
            //console.log(response.chat);

            let result = response.chat;
            let message = "";
            let data_today="";

            for(let i=0;i<result.length;i++){

                let status = "";
                
                if(result[i].status == 0){
                    status += 'Delivered';
                }
                else if(result[i].status == 1){
                    status += 'read';
                }
            
                let file = '';
            
                if(result[i].message == ''){   
                    file += '<p>'+result[i].file+'</p>';
                }
                else{
                    file += '<p>'+decrypt(result[i].message)+'</p>';
                }
                
                let today = new Date();
                let dd = String(today.getDate()).padStart(2, '0');
                let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                let yyyy = today.getFullYear();

                today = yyyy + '/' + mm + '/' + dd;

                let datedata = "";

                if(moment(result[i].time).format('YYYY/MM/D') == today){   
                    if(data_today == "" || data_today < moment(result[i].time).format('YYYY/MM/D'))
                    {
                        datedata += '<div id="dateMessage" style="display:block";>'+
                                '<h6 style="margin-left:500px;">Today</h6>'+
                                    '<small>-----------------------------------------------------------------------------------------------------------------------------------------------------------------</small>'+
                                '</div>';
                    }
                }
                else{
                    if(data_today == "" || data_today < moment(result[i].time).format('YYYY/MM/D'))
                    {
                        datedata += '<div id="dateMessage" style="display:block";>'+
                        '<h6 style="margin-left:500px;">'+moment(result[i].time).format("MMMM Do YYYY")+'</h6>'+
                            '<small>-----------------------------------------------------------------------------------------------------------------------------------------------------------------</small>'+
                        '</div>';
                    }
                }

                let time = moment(result[i].time).format('h:mm a');
                
                message +=  datedata;
                
                if(result[i].receiver_id == id && result[i].sender_id == userId){
                    message += '<div class="chat outgoing">'+
                                    '<div class="details">'+
                                        file+
                                        '<small class="ml-5">'+status+'&nbsp;&nbsp;'+time+'</small>'+
                                    '</div>'+
                                '</div>';
                }
                else if(result[i].sender_id == id && result[i].receiver_id == userId){
                    message += '<div class="chat incoming">'+
                                    '<div class="details">'+
                                        file+
                                        '<small class="">'+time+'</small>'+
                                    '</div>'+
                                '</div>';
                }

                data_today = moment(result[i].time).format('YYYY/MM/D');
            }   
            
            message += '<small id="typing_on"></small>';

            
            $('.chat-box').html(message);

            $('.chat-box').mouseenter(function(){
                $('.chat-box').attr('class','chat-box active');
            });
            
            $('.chat-box').mouseleave(function(){
                $('.chat-box').attr('class','chat-box deactive');
            });
            
            $(".deactive").animate({ scrollTop: $(".deactive")[0].scrollHeight });
        }   
    });
}); 


