@include('template.header1')

@section('body')
  <section>

    <!-- content -->
    <div class="">
        <!-- Register form -->
        <section class="register-form py-md-5 py-3">
            <div class="card card_border p-md-4">
                <div class="card-body">
                    <!-- form -->
                    
                    <div class="mb-4">
                        @if ($errors->any())    
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li style="color:red">{{ $error }}</li>
                            @endforeach
                            </ul>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                    @csrf

                        <div class="register__header text-center mb-lg-5 mb-4">
                            <h3 class="register__title mb-2"> Signup</h3>
                            <p>Create your account here, and continue </p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName" class="input__label">Name</label>
                            <input id="name" class="form-control login_text_field_bg input-style"
                                aria-describedby="emailHelp" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            
                            @error('name')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="input__label">Email</label>
                            <input type="email" class="form-control login_text_field_bg input-style"
                                id="exampleInputEmail1" aria-describedby="emailHelp"  type="email" name="email" :value="old('email')" required />
                        
                            @error('email')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1" class="input__label">Password</label>
                            <input  class="form-control login_text_field_bg input-style"
                            id="password" placeholder="" type="password" type="password" name="password" required autocomplete="new-password" />
                        
                            @error('password')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1" class="input__label">Confirm Password</label>
                            <input  class="form-control login_text_field_bg input-style"
                            id="password_confirmation" placeholder="" type="password" name="password_confirmation" required autocomplete="new-password" />

                            @error('password_confirmation')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="form-check check-remember check-me-out">
                            <input type="checkbox" class="form-check-input checkbox" id="exampleCheck2" id="show" name="show" onclick="showBothPassword()"/>
                            <label class="form-check-label checkmark" for="exampleCheck2">Show
                            password</label>
                        </div>
                        
                        <br/>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="form-check check-remember check-me-out">
                            <input type="checkbox" class="form-check-input checkbox" id="exampleCheck1" id="terms" name="terms"/>
                            <label class="form-check-label checkmark" for="exampleCheck1">I agree to the
                                <a href="#terms">Terms of service</a> and <a href="#privacy">Privacy policy</a> </label>
                        </div>
                        <!-- <div class="form-check check-remember check-me-out">
                            <input type="checkbox" class="form-check-input checkbox">
                            <label class="form-check-label checkmark" for="exampleCheck1">I agree to the
                                <a target="_blank" href="{{ route('terms.show')}}">Terms of service</a> and <a target="_blank" href="{{ route('policy.show')}}" >Privacy policy</a> </label>
                        </div> -->
                        @endif

                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <button type="submit" class="btn btn-primary btn-style mt-4">Create Account</button>
                            <p class="signup mt-4">Already have an account? <a href="{{ route('login') }}"
                                    class="signuplink">Login </a>
                            </p>
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