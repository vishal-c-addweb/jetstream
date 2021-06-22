@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
    
        <section class="template-cards" >
          <div class="card card_border">

            <div class="cards__heading">

                <h3>Chat</h3>
                @if(auth()->user()->role == 1)
                  <div style="text-align:center;">
                      <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chatModal">Assign User</button>              
                  </div>
                @endif

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

            </div>
            <div>
            <div class="main-section" style="margin-top:10px;">
                <div class="head-section">
                    <div class="headLeft-section" style="background-color:#109edb;">
                    <img class="ml-2 h-8 w-8 rounded-full object-cover" src="http://127.0.0.1:8000/storage/profile-photos/hVtJnwjJYS8q5QuRy0DwDom3eu0JajM6cCz5sl1w.jpg" >
                       
                        <div class="headLeft-sub ml-2" >
                            <input type="text" name="search" placeholder="Search...">
                            <button> <i class="fa fa-search"></i> </button>
                            
                        </div>
                        
                    </div>
                    <div class="headRight-section" style="background-color:#109edb; display:none" id="user">
                        <div class="headRight-sub">
                            <h3 id="userName"></h3>
                            <small>Lorem ipsum dolor sit amet...</small>
                        </div>
                    </div>
                </div>
                <div class="body-section">
                    <div class="left-section mCustomScrollbar" data-mcs-theme="minimal-dark">
                        <ul id="removeActive">
                          @foreach($chatUser as $c)
                            <li id="active{{ $c->user_id }}" class="">
                                <div class="chatList" onClick='userbox({{ $c->user_id }})'>
                                    <div class="img">
                                        <i class="fa fa-circle"></i>
                                        <img src="/demo/man01.png">
                                    </div>
                                    <div class="desc">
                                        <small class="time">05:30 am</small>
                                          <h5>{{ $c->user->name }}</h5>
                                        <small id='msg{{$c->user_id}}'></small>
                                    </div>
                                </div>
                            </li>
                          @endforeach
                        </ul> 
                    </div>
                    <div class="right-section" style="display:none" id="chat">
                        <div class="message mCustomScrollbar chatId" style="overflow: scroll;" data-mcs-theme="minimal-dark">
                            <ul id="message" >
                            </ul>
                        </div>
                        <div class="right-section-bottom">
                        <form action="javascript:void(0)" id="chatForm" name="chatForm" class="form-horizontal" method="POST">
                            <input type="text" id="ipId" name="ip" hidden>
                            
                            {{ csrf_field() }}
                            <p id="userId" name="userId" hidden></p>
                            <input type="text" name="content" placeholder="type here..." id="content">
                            <button type="submit" id="btn"><i class="fa fa-send"></i></button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          </div>
        </section>
    </div>
    <!-- main content end-->

@endsection