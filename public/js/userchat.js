function sendMessage(id)
{
    let receiverId = id;
    let file = document.getElementById('fileToUpload').value;
    let content = document.getElementById('chatMsg').value;
    $.ajax({
        url:"/chat/sendmessage",
        type:'post',
        data:{receiverId:receiverId,content:content,file:file},
        dataType: 'json',                            
        success:function(response){
            console.log(response);
            document.getElementById('chatMsg').value = "";
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
    //THIS IF STATEMENT EXECUTES IF USER CTRL-A DELETES THE TEXT BOX
    if ($("#chatMsg").val().length>0){
        $('#typing_on').html('typing...');
    }
    else{
        $("#typing_on").hide();
    }
});

$(document).ready(function () {
setInterval(function() {
const id = document.getElementById('incoming_id').value;
const userId = document.getElementById('outgoing_id').value;
    $.ajax({
        url:"/chat/chatuser",
        type:'post',
        data:{id:id},
        dataType: 'json',
        success:function(response){
            console.log(response.chat);
            let result = response.chat;
            let message = "";
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
                    file += '<p>'+result[i].message+'</p>';
                }
                let time = moment(result[i].time).format('h:mm a');
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
            }
            message += '<small id="typing_on"></small>'
            $('.chat-box').html(message);
        }   
    });
},500);
}); 
