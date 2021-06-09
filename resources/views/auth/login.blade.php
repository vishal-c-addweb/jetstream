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

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="login__header text-center mb-lg-5 mb-4">
                            <h3 class="login__title mb-2"> Login</h3>
                            <p>Welcome back, login to continue</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="input__label">Username</label>
                            <input type="text" class="form-control login_text_field_bg input-style"
                            id="email"  aria-describedby="emailHelp" placeholder="" type="email" name="email" :value="old('email')" required autofocus />

                            @error('email')
                            <span style="color: red;">{{$message}}</span>
                            @enderror

                        </div>


                        <div class="form-group">
                            <label for="exampleInputPassword1" class="input__label">Password</label>
                            <input type="password" class="form-control login_text_field_bg input-style"
                            id="password" placeholder="" type="password" name="password" required autocomplete="current-password" />


                            @error('password')
                            <span style="color: red;">{{$message}}</span>
                            @enderror

                        </div>
                        
                        <div class="form-check check-remember check-me-out">
                            <input type="checkbox" class="form-check-input checkbox" id="exampleCheck2" id="show" name="show" onclick="showPassword()"/>
                            <label class="form-check-label checkmark" for="exampleCheck2">Show
                            password</label>
                        </div>
                        
                        <br/>

                        <div class="form-check check-remember check-me-out">
                            <input type="checkbox" class="form-check-input checkbox" id="exampleCheck1" id="remember_me" name="remember" />
                            <label class="form-check-label checkmark" for="exampleCheck1">Remember
                                me</label>
                        </div>
                        
                        
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <button type="submit" class="btn btn-primary btn-style mt-4">Login now</button>
                            <p class="signup mt-4">Don’t have an account? <a href="{{ route('register') }}"
                                    class="signuplink">Sign
                                    up</a></p>
                        </div>
                    </form>
                    <!-- //form -->
                    <p class="backtohome mt-4"><a href="index.html" class="back">
                    @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                    </p>

                </div>
            </div>
        </section>

    </div>
    <!-- //content -->

</section>




<div id = "v-w3layouts"></div><script>(function(v,d,o,ai){ai=d.createElement('script');ai.defer=true;ai.async=true;ai.src=v.location.protocol+o;d.head.appendChild(ai);})(window, document, '//a.vdo.ai/core/v-w3layouts/vdo.ai.js');</script>

@include('template.footer')
