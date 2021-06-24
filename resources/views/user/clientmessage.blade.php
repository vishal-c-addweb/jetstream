@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
    
        <section class="template-cards">

          <div class="card card_border">

            <div class="cards__heading">

                <h3>ClientMessage </h3>
                
                <div style="text-align:center;">
                    <a href="/laravel-websockets" class="btn btn-primary">Websocket Dashboard</a>
                </div>

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
            
            <div class="data-tables">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card card_border p-4">
                            <div class="table-responsive">
                                <!-- Fetch Employee Data -->  
                                <div class="card-body">
                                    <table class="table table-bordered data-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Channel Name</th>
                                                <th>Event Name</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eventMessage as $e)
                                                <tr>
                                                    <th>{{ $e->id }}</th>
                                                    <th>{{ $e->channel }}</th>
                                                    <th>{{ $e->event }}</th>
                                                    <th>
                                                    @foreach (json_decode($e->data) as $msg)
                                                        {{ $msg }},
                                                    @endforeach
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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