@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
    
        <section class="template-cards" >
          <div class="card card_border">

            <div class="cards__heading">

                <h3>Restricted Words</h3>
                
                <div style="text-align:center;">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ipModal">Add ChatWords</button>
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
                                <!-- Fetch Chatword Data -->  
                                <div class="card-body mt-5">
                                    <table class="table table-bordered " id="timesheet-table">
                                        <h4 style="text-align:center;color:gray;" >Restricted Words</h4>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>word</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($chatword2 as $c)
                                                <tr>
                                                    <td>{{ $c->id }}</td>
                                                    <td>{{ $c->word }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered " id="timesheet-table">
                                     <h4 style="text-align:center;color:gray;">Words by User</h4>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Sender</th>
                                                <th>Receiver</th>
                                                <th>word</th>
                                                <th>count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($chatword1 as $c)
                                                <tr>
                                                    <td>{{ $c->id }}</td>
                                                    <td>{{ $c->sender->name }}</td>
                                                    <td>{{ $c->receiver->name }}</td>
                                                    <td>{{ $c->word }}</td>
                                                    <td>{{ $c->count }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-20" >
                    </div>
                </div>
            </div>

          </div>
        </section>
    </div>
    <!-- main content end-->
  
    <!-- Modal -->
    <div class="modal fade" id="ipModal" tabindex="-1" role="dialog" aria-labelledby="ipModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="ipModalLabel">Add ChatWords</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('chatwords.store') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <h5 style="text-align:center;">ChatWords</h5>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputChatWords" class="form-label">ChatWord</label>
                            <br/>
                            <input type="text" class="form-control" name="chatword"> 
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


@endsection