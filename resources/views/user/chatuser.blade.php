@include('template.header')

@section('body')

  <div class="wrapper">
  @if(auth()->user()->role == 1)
    <div style="text-align:center;">
        <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chatModal">Assign User</button>              
    </div>
  @endif
    <section class="users" >
      <header style="border: 2px solid black;padding: 10px;border-radius: 10px;">
        <div class="content" >
          <img src="{{auth()->user()->profile_photo_url}}" alt="">
          <div class="details">
            <span style="color:white;">{{auth()->user()->name}}</span>
            <p>Active</p>
          </div>
        </div>
      </header>
      <div class="mb-3 mt-3">
        <input type="text" id="searchBar" placeholder="Enter name to search..." style="width:1130px;border-radius: 10px;">
      </div>
      <div class="users-list">
      @foreach($chatUser as $c)
        <a href="chats/{{ $c->user_id }}">
            <div class="content">
            <img src="{{ $c->user->profile_photo_url}}" alt="">
            <div class="details">
                <span>{{ $c->user->name }}</span>
                <p id="msg{{ $c->user_id }}"></p>
            </div>
            </div>
            <!-- {{$c->time_8601}} -->
            @if(Carbon\Carbon::parse($c->time_8601)->format('H:i a') == Carbon\Carbon::parse(Carbon\Carbon::now())->format('H:i a'))
              <div class="status-dot . 'online'" ><i class="fa fa-circle"></i></div>
            @else
              <div class="status-dot . 'offline'" ></div>
            @endif
            
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
@include('template.footer')
