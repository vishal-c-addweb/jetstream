@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
       
        <!-- modals -->
        <section class="template-cards" >
          <div class="card card_border">

            <div class="cards__heading">
                <div style="text-align:center;">
                    <!-- Button trigger modal -->
                    @foreach($attendance as $a)
                    <tr>
                        <td ><h3>Report :- {{$a->employeeid->fname}}</h3></td>
                        @break
                    </tr>
                    @endforeach
                </div>
            </div>
            
            <div class="data-tables">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card card_border p-4">
                            <div class="table-responsive">
                                <!-- Fetch report Data -->  
                                <div class="card-body">
                                    <table class="table table-bordered data-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Employee Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($attendance as $a)
                                            <tr>
                                                <td>{{$a->id}}</td>
                                                <td>{{$a->employeeid->fname}}</td>
                                                <td>{{$a->att_date}}</td>
                                                <td>
                                                @if ($a->att_status == 1)
                                                    Present
                                                @else 
                                                    Absent
                                                @endif
                                                </td>
                                                <td>{{$a->created_at->diffForHumans()}}</td>
                                                <td>{{$a->updated_at->diffForHumans()}}</td>
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
        <!-- //modals -->
    </div>
  <!-- main content end-->
  

@endsection
 