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
                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        

                        <div class="form-group">
                            <label for="exampleInputEmail1" class="input__label">Email</label>
                            <input  class="form-control login_text_field_bg input-style"
                            id="email"  aria-describedby="emailHelp" placeholder="" type="email" name="email" :value="old('email')" required autofocus />
                        </div>
                        
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <button type="submit" class="btn btn-primary btn-style mt-4">{{ __('Email Password Reset Link') }}</button>
                    
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
