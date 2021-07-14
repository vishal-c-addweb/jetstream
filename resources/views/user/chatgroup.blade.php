@include('template.header')

@section('body')

<div class="wrapper" style="width:1770px;height:850px">
    <section class="chat-area mt-20">
    @if (session()->has('message'))
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
    role="alert">
        <div class="flex">
            <div>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        </div>
    </div>
    @endif
      <header style="border: 2px solid black;padding: 10px;border-radius: 5px;">
        <a href="{{route('chats') }}" class="back-icon"><i class="fa fa-arrow-left" style="color:white;"></i></a>
        <input type="hidden" id="chatUserId">
        <img src="{{asset ('assets/uploads/groupicon.png') }}" alt="">
        <div class="details">
            <span style="color:white;">{{$chatGroup->name}}</span>
            </br>
            <div style="width:500px;">
            @foreach($chatGroupUser as $c)
                @if($c->user_id != $chatGroup->created_by)
                    <h8 style="color:white;">{{$c->user->name}},</h8>
                @endif
            @endforeach
            <h8 style="color:white;">Created By:{{$chatGroup->user->name}}</h8>
            </div>
        </div>
        @if($chatGroup->created_by == auth()->user()->id){
        <div style="margin-left:1000px;">
            <button type="button" style="color:white;width:120px;border:1px solid white;border-radious:10%;" class="" data-toggle="modal" data-target="#groupModal">Add Member</button>    
        </div>
        @endif
      </header>
      <p id="appUrl" hidden>{{env('APP_URL')}}</p>
      <div class="container mt-2" id="app" style="margin-right:600px;">
        <groupmessage :user="{{auth()->user()}}" :group="{{$chatGroup}}" :usergroup="{{$chatGroupUser}}"></groupmessage>
      </div>
      
    </section>
  </div>

<!-- Modal -->
<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="groupModalLabel">Assign User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('groupmember.store') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <h5 style="text-align:center;">Create Group</h5>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="groupid" id="groupId" class="form-control" value="{{$chatGroup->id}}" hidden> 
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputUser" class="form-label">User</label>
                            <br/>
                            <select class="form-control" name="userid[]" multiple>
                                @foreach($user as $u)
                                    <option value="{{$u->id}}">{{$u->name}}</option> 
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Save</button>
                        </div>
                    </form>
                </div>
            
            </div>
        </div>
    </div>

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