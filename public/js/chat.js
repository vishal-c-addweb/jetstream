$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function userbox(id)
{
    document.getElementById('userId').innerHTML="";
    $('#removeActive li.active').removeClass('active');
    $("#active"+id).addClass("active");
    document.getElementById('user').style.display = "block";
    document.getElementById('chat').style.display = "block";
    $.ajax({
        url:"/chat/chatuser",
        type:'post',
        data:{id:id},
        dataType: 'json',
        success:function(response){
            console.log(response);
            let result = response.chat;
            let userId = response.user.user_id;
            $('.chatId ul').attr('id','message'+userId+'');
            $('#message'+userId).empty();
            document.getElementById('userName').innerHTML = response.chatuser.user.name; 
            document.getElementById('userId').innerHTML = response.chatuser.user.id; 

            let sendermessage = "";
            let receivermessage = "";
            for(let i=0;i<result.length;i++)
            {
                if(result[i].sender_id == userId && result[i].receiver_id == id)
                {
                    let send = ""
                    if(result[i].status == 0)
                    {
                        send += 'Delivered';
                    }
                    else if(result[i].status == 1)
                    {
                        send += 'read';
                    }
                    let time = result[i].time;
                    var a = time.split(':');
                    let minute = a[0];
                    let second = a[1];
                    sendermessage +=   '<li class="msg-right">'+
                                    '<div class="msg-right-sub">'+
                                        '<div class="msg-desc">'+
                                        result[i].message +
                                    '</div>'+
                                    '<small>'+send +'&nbsp;&nbsp;'+minute+':'+second+'</small>'+
                                     
                                    '</div>'+
                                '</li>';
                }
                else if(result[i].sender_id == id && result[i].receiver_id == userId)
                {
                    let time = result[i].time;
                    var a = time.split(':');
                    let minute = a[0];
                    let second = a[1];
                    sendermessage +=   '<li class="msg-left">'+
                                    '<div class="msg-left-sub">'+
                                        '<img src="/demo/man03.png">'+
                                        '<div class="msg-desc">'+
                                        result[i].message +
                                    '</div>'+
                                    '<small>'+minute+':'+second+'</small>'+
                                    '</div>'+
                                '</li>';
                }
                
            }
            $('#message'+userId).append(sendermessage);
        }
    });
}

var receiverId = document.getElementById('userId').innerHTML;
$.ajax({

})

$('#chatForm').submit(function(){
    let receiverId = document.getElementById('userId').innerHTML;  
    let content = document.getElementById('content').value;
    $.ajax({
        url:"/chat/sendmessage",
        type:'post',
        data:{receiverId:receiverId,content:content},
        dataType: 'json',                            
        success:function(response){
                console.log(response);
                let userId = response.user.user.id;
                document.getElementById('content').value = "";
                document.getElementById('userName').innerHTML = response.chatuser.user.name; 
                document.getElementById('userId').innerHTML = response.chatuser.user.id; 
    
                let sendermessage = "";
                let receivermessage = "";
                let time = response.chat.time;
                var a = time.split(':');
                let minute = a[0];
                let second = a[1];

                sendermessage +=   '<li class="msg-right">'+
                                '<div class="msg-right-sub">'+
                                    '<div class="msg-desc">'+
                                    response.chat.message +
                                '</div>'+
                                '<small>Delivered&nbsp;&nbsp;'+minute+':'+second+'</small>'+
                                '</div>'+
                            '</li>';
                
                receivermessage +=   '<li class="msg-left">'+
                            '<div class="msg-left-sub">'+
                                '<img src="/demo/man03.png">'+
                                '<div class="msg-desc">'+
                                response.chat.message +
                            '</div>'+
                            '<small>'+minute+':'+second+'</small>'+
                            '</div>'+
                        '</li>';

                $('#message'+userId).append(sendermessage);
                $('#message'+receiverId).append(receivermessage);
                $('#msg'+receiverId).append(response.chat.message);
                $('#msg'+userId).append(response.chat.message);
        }
    });  
});