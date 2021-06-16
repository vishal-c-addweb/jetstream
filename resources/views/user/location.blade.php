@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
    
        <section class="template-cards" >
          <div class="card card_border">

            <div class="cards__heading">

                <h3>Project</h3>
                
                <div style="text-align:center;">
                    @if ($location == '')
                        <button type="button" onClick="getLocation()"  style="margin-left:45px;" data-bs-toggle="modal" data-bs-target="#projectModal" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 ml-3">Store Location</button>
                    @else
                        <button type="button" onClick="getLocation()"  style="margin-left:45px;" data-bs-toggle="modal" data-bs-target="#projectModal" class="bg-gray-700 text-white font-bold py-2 px-4 rounded my-3 ml-3" disabled>Location Stored</button>
                    @endif                                    
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
                        <div class="card card_border p-4" >
                            <div class="table-responsive">
                                <!-- Fetch Project Data -->  
                                @if(!empty($location))
                                    <input type="hidden" value="{{$location->latitude}}" id="latitude">
                                    <input type="hidden" value="{{$location->longitude}}" id="longitude">
                                @endif
                                <div id="map" style="width:100%; height:400px;"></div>
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