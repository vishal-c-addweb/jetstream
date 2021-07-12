@include('template.header')

@section('body')

  <div class="wrapper">
    <section class="users">
    @if(auth()->user()->role == 1)
    <div style="text-align:center;">
        <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#chatModal">Assign User</button>              
    </div>
    @endif  
      <header style="border: 2px solid black;padding: 10px;border-radius: 10px;">
        <div class="content" >
          <img src="{{auth()->user()->profile_photo_url}}" alt="">
          <div class="details">
            <span style="color:white;">{{auth()->user()->name}}</span>
            <p>Active</p>
          </div>
          <div style="margin-left:860px;">
            <button type="button" style="color:white;width:120px;border:1px solid white;border-radious:10%;" class="" data-toggle="modal" data-target="#groupModal">Create Group</button>
          </div>
        </div>
      </header>
      
      <div class="mb-3 mt-3">
        <input type="text" id="searchBar" placeholder="Enter name to search..." style="width:1130px;border-radius: 10px;">
      </div>
      <div class="users-list" style="height:300px;">
      @foreach($chatgroupuser as $cg)
          <a href="chatgroups/{{ $cg->group_id }}">
            <div class="content">
              <img src="{{asset ('assets/uploads/groupicon.png') }}" alt="">
              <div class="details">
                  <span>{{ $cg->group->name }}</span>
                  <p id="groupmessage{{$cg->group_id}}"></p>
              </div>
            </div>
            <small id="msggroupcount{{$cg->group_id}}{{auth()->user()->id}}" ></small>
          </a>
      @endforeach
      @foreach($chatUser as $c)
      <div id="app">
        <chatuser :user="{{auth()->user()->id}}" receiver="{{$c->user_id}}"></chatuser>
        <chatgroup :user="{{auth()->user()->id}}" :group="{{$chatgroup}}"></chatgroup>
      </div>
        <a href="chats/{{ $c->user_id }}">
            <div class="content">
              <img src="{{ $c->user->profile_photo_url}}" alt="">
              <div class="details">
                  <span>{{ $c->user->name }}</span>
                  
                  <p id="msg{{$c->user_id}}{{auth()->user()->id}}"></p>
              </div>
            </div>
            <!-- @if(Carbon\Carbon::parse($c->time_8601)->format('H:i a') == Carbon\Carbon::parse(Carbon\Carbon::now())->format('H:i a'))
              <div class="status-dot . 'online'" ><i class="fa fa-circle"></i></div>
            @else
              <div class="status-dot . 'offline'" ></div>
            @endif -->
            <small id="msgcount{{$c->user_id}}{{auth()->user()->id}}" ></small>
        </a>
      @endforeach
      </div>
      <div class="search-users-list">
      </div>
    </section>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="chatModalLabel">Assign User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('chat.store') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <h5 style="text-align:center;">Assign User</h5>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputUser" class="form-label">User</label>
                            <br/>
                            <select class="form-control" name="userid">
                                <option value="select">Select User</option> 
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
                    <form method="POST" action="{{ route('chatgroup.store') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <h5 style="text-align:center;">Create Group</h5>
                        </div>

                        <div class="mb-3">
                          <label for="exampleInputGroupName" class="form-label">Group Name</label>
                            <br/>
                            <input type="text" name="groupname" id="groupName" class="form-control"> 
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputUser" class="form-label">User</label>
                            <br/>
                            <select class="form-control" name="userid[]" multiple>
                                @foreach($chatUser as $u)
                                    <option value="{{$u->user->id}}">{{$u->user->name}}</option> 
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
    
@include('template.footer') 
<script>
  $('.ul-display').click(function() {
    alert("hy");
    $('.li-display').attr('style','display:block')
  });
</script>