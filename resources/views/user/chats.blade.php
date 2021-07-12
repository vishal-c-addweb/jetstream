@include('template.header')

@section('body')

<div class="wrapper">
    <section class="chat-area mt-20">
      <header style="border: 2px solid black;padding: 10px;border-radius: 5px;">
        <a href="{{route('chats') }}" class="back-icon"><i class="fa fa-arrow-left" style="color:white;"></i></a>
        <input type="hidden" id="chatUserId">
        <img src="{{$user->user->profile_photo_url}}" alt="">
        <div class="details">
          <span style="color:white;">{{$user->user->name}}</span>
          @if(Carbon\Carbon::parse($user->time_8601)->format('H:i a') == Carbon\Carbon::parse(Carbon\Carbon::now())->format('H:i a'))
            
          @else
            @if(Carbon\Carbon::parse($user->time_8601)->format('Y-m-d') == Carbon\Carbon::parse(Carbon\Carbon::now())->format('Y-m-d'))
              <p style="color:white;">Last seen:{{Carbon\Carbon::parse($user->time)->format('H:i a')}}</p>
            @else
              <p style="color:white;">Last seen: {{Carbon\Carbon::parse($user->time_8601)->format('Y M D')}} {{Carbon\Carbon::parse($user->time)->format('H:i a')}}</p>
            @endif
          @endif
        </div>
      </header>
      <p id="appUrl" hidden>{{env('APP_URL')}}</p>
      <div class="container mr-10 mt-2" id="app">
      
        <chat :user="{{auth()->user()}}" :receiver="{{$user}}" :id="{{$id}}"></chat> 
      </div>
      <!-- <div class="chat-box deactive" style="height:350px;">
      </div>
      
      <form action="#" class="typing-area" enctype="multipart/form-data">
      
          <input type="text" class="outgoing_id" name="outgoing_id" value="{{auth()->user()->id}}" hidden id="outgoing_id">
          <input type="text" class="incoming_id" name="incoming_id" value="{{$id}}" hidden id="incoming_id">
          <label for="fileToUpload" type="submit" style="margin-right:8px;margin-top:8px; ">
            <i class="fa fa-upload" aria-hidden="true" style="width:20px;"></i>
          </label>
          <input type="File" name="fileToUpload" id="fileToUpload" style="display:none;">
          <input type="text" name="message" class="input-field" placeholder="Type a message here..." id="chatMsg">
        <a onClick="sendMessage({{$id}})" type="submit" class="btn"><i class="fa fa-send"></i></a>
      </form> -->
    </section>
  </div>
   <!-- Creates the bootstrap modal where the image will appear -->
   <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Image preview</h4>
          </div>
          <div class="modal-body">
              <img src="" id="imagepreview" >
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
      </div>
  </div>  
  <iframe id="openWith" src="" width="600" height="780" style="border: none;display:none;"></iframe>
  <div class="bs-example">
    <div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Video</h4>
                </div>
                <div class="modal-body">
                    <iframe id="cartoonVideo" width="560" height="315" src="" frameborder="0" ></iframe>
                </div>
      </div>
    </div>
  </div>
</div>    
@include('template.footer')
<script>
$("#pop").on("click", function() {
  alert("hy");
   $('#imagepreview').attr('src', $('#imageresource').html()); // here asign the image to the modal when the user click the enlarge link
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
});
</script>