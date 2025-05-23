@include('frontend.header');

<body class="login-bg-b">
    <div class="ad-auth-wrapper login-bg">
        <div class="ad-auth-box">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="position: relative;">
                    <h1 class="text-white welcome-text"><b>Welcome</b></h1>
                    <div class="ad-auth-img">
                        <img src="{{asset('../images/login-logo.png')}}" alt="">
                    </div>
                    
                <!--                 
                @if(session('status'))
                    <div class="alert alert-warning">
                        {{ session('status') }}
                    </div>
                @endif -->
                </div>
            
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="ad-auth-content">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{route('login')}}">
                            @csrf
                            <img style="width: 150px;" src="{{asset('../images/peepal-logo-final.png')}}" alt="">
                            <div class="ad-auth-form" style="margin-top:0px;">
                                <div class="ad-auth-feilds mb-30" style="margin-top:0px;">
                                    <input type="text" placeholder="Employee ID" id="employeeid" name="employeeid"
                                        value="{{ old('employeeid') }}" class="ad-input login-input"
                                        fdprocessedid="fnt9d">
                                    <div class="ad-auth-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 483.3 483.3">
                                            <path
                                                d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1    v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5    c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                            <path
                                                d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3    c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95    c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4    c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ad-auth-feilds " >
                                    <input type="password" placeholder="Password" id="password" name="password"
                                        class="ad-input login-input" fdprocessedid="lyjstq">
                                    <div class="ad-auth-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 482.8 482.8">
                                            <path
                                                d="M395.95,210.4h-7.1v-62.9c0-81.3-66.1-147.5-147.5-147.5c-81.3,0-147.5,66.1-147.5,147.5c0,7.5,6,13.5,13.5,13.5    s13.5-6,13.5-13.5c0-66.4,54-120.5,120.5-120.5c66.4,0,120.5,54,120.5,120.5v62.9h-275c-14.4,0-26.1,11.7-26.1,26.1v168.1    c0,43.1,35.1,78.2,78.2,78.2h204.9c43.1,0,78.2-35.1,78.2-78.2V236.5C422.05,222.1,410.35,210.4,395.95,210.4z M395.05,404.6    c0,28.2-22.9,51.2-51.2,51.2h-204.8c-28.2,0-51.2-22.9-51.2-51.2V237.4h307.2L395.05,404.6L395.05,404.6z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                            <path
                                                d="M241.45,399.1c27.9,0,50.5-22.7,50.5-50.5c0-27.9-22.7-50.5-50.5-50.5c-27.9,0-50.5,22.7-50.5,50.5    S213.55,399.1,241.45,399.1z M241.45,325c13,0,23.5,10.6,23.5,23.5s-10.5,23.6-23.5,23.6s-23.5-10.6-23.5-23.5    S228.45,325,241.45,325z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="ad-other-feilds d-none">
                                <div class="ad-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" class="ad-checkbox">
                                        <!--<span>Remember Me</span>-->
                                    </label>
                                </div>
                                <!-- <a class="forgot-pws-btn" href="{{ route('forgotpasscode') }}">Forgot Password?</a> -->

                            </div>
                            <div class="ad-auth-btn" STYLE="margin-top: 40PX;margin-bottom: 40PX;">
                                <button style="padding: 12px 50px;" type="submit"
                                    class="effect-btn btn btn-secondary pl-3 pr-3">Login</button>
                            </div>
                            <a href=""><b>Terms of Use</b></a> | <a href=""><b>Privacy Policy</b></a><br>
                            <p class="ad-register-text">&#169; Copyright {{date('Y')}} VNR Seeds Private Limited India</p>
                        </form>
                    </div>

                </div>
                </form>
            </div>

        </div>
        <div class="web-url-section">
            <div class="web-icon-section"><i class="fa fa-globe"></i></div>
            <div style="float: left;margin-left: 11px;">
                <b><a style="color:#2c4d57;font-size:12px;" title="VNR Seeds Private Limited" target="_blank"
                        href="https://www.vnrseeds.com/">www.vnrseeds.com</a><br>
                    <a style="color:#2c4d57;font-size:12px;" title="VNR Nursery" target="_blank" href="https://www.vnrnursery.in/">www.vnrnursery.in</a></b>
            </div>
        </div>
    </div>
</body>

</html>