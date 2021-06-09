@include('template.header1')

@section('body')
  <section>

    <!-- content -->
    <div class="">
        <!-- login form -->
        <section class="login-form py-md-5 py-3">
            <div class="card card_border p-md-4 ">
                <div class="card-body">
                    <!-- form -->
                    <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group">
                            <label for="exampleInputEmail1" class="input__label">Email</label>
                            <input  class="form-control login_text_field_bg input-style"
                            id="email"  aria-describedby="emailHelp" placeholder="" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1" class="input__label">Password</label>
                            <input  class="form-control login_text_field_bg input-style"
                            id="password" placeholder="" type="password" name="password" required autocomplete="new-password" />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1" class="input__label">Confirm Password</label>
                            <input type="password" class="form-control login_text_field_bg input-style"
                            id="password_confirmation" placeholder=""type="password" name="password_confirmation" required autocomplete="new-password" />
                        </div>
                        
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <button type="submit" class="btn btn-primary btn-style mt-4">{{ __('Reset Password') }}</button>
                    
                        </div>
                    </form>

                </div>
            </div>
        </section>

    </div>
    <!-- //content -->

</section>




<div id = "v-w3layouts"></div><script>(function(v,d,o,ai){ai=d.createElement('script');ai.defer=true;ai.async=true;ai.src=v.location.protocol+o;d.head.appendChild(ai);})(window, document, '//a.vdo.ai/core/v-w3layouts/vdo.ai.js');</script>

@include('template.footer')
