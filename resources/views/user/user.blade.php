@extends('template.main')

@section('body')
    <!-- //header-ends -->
    <!-- main content start -->
    <div id="app" class="main-content" style="margin-top:50px;">
       
      <!-- modals -->
      <section class="template-cards" >
        
        <div class="card card_border">

          <div class="cards__heading">

            <h3>User</h3>

          </div>
          
          <div class="data-tables">

              <div class="row">

                <div class="col-lg-12 mb-4">

                    <div class="card card_border p-4">

                      <div class="table-responsive">

                          <!-- Fetch Employee Data -->  
                          <div class="card-body">

                              <livewire:user-datatables
                                  include="id,name,email"                           
                              />
                          </div>
                      </div>
                    </div>
                </div>
              </div>
          </div>

        </div>
      </section>
      <!-- //modals -->

      <!-- //content -->
    </div>
  <!-- main content end-->
 
@endsection
