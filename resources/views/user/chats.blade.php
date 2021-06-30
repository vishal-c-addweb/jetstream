@include('template.header')

<div class="wrapper">
    <section class="chat-area mt-20">
      <header style="border: 2px solid black;padding: 10px;border-radius: 5px;">
        <a href="{{route('chats') }}" class="back-icon"><i class="fa fa-arrow-left" style="color:white;"></i></a>
        <input type="hidden" id="chatUserId">
        <img src="{{$user->user->profile_photo_url}}" alt="">
        <div class="details">
          <span style="color:white;">{{$user->user->name}}</span>
          @if(Carbon\Carbon::parse($user->time_8601)->format('H:i a') == Carbon\Carbon::parse(Carbon\Carbon::now())->format('H:i a'))
            <p style="color:white;">Active</p>
          @else
            @if(Carbon\Carbon::parse($user->time_8601)->format('Y-m-d') == Carbon\Carbon::parse(Carbon\Carbon::now())->format('Y-m-d'))
              <p style="color:white;">Last seen:{{Carbon\Carbon::parse($user->time)->format('H:i a')}}</p>
            @else
              <p style="color:white;">Last seen: {{Carbon\Carbon::parse($user->time_8601)->format('Y M D')}} {{Carbon\Carbon::parse($user->time)->format('H:i a')}}</p>
            @endif
          @endif
        </div>
      </header>
      <div class="container mt-20" id="app">
        
        <chat :user="{{auth()->user()}}" :id="{{$id}}"></chat> 
      </div>
    </section>
  </div>

@include('template.footer')
