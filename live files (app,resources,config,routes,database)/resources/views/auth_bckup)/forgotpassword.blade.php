@include('frontend.header');

<body class="login-bg-b">
    <div class="ad-auth-wrapper login-bg">
        <div class="ad-auth-box">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="position: relative;">
                    <h1 class="text-white welcome-text"><b>Welcome</b></h1>
                    <div class="ad-auth-img">
                        <img src="./images/login-logo.png" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="ad-auth-content">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <h2><span class="primary">Forgot Password</span></h2>
                            <div class="ad-auth-form">
                                <div class="ad-auth-feilds">
                                    <input type="text" name="email" placeholder="Enter your email id"
                                        class="ad-input login-input">
                                    <div class="ad-auth-icon">
                                        <!-- SVG icon -->
                                    </div>
                                </div>
                            </div>
                            <div class="ad-other-feilds" style="text-align: right; display: flow-root;">
                                <a class="forgot-pws-btn" href="{{ route('login') }}">Back</a>
                            </div>

                            <div class="ad-auth-btn" style="margin-top: 40px; margin-bottom: 40px;">
                                <button type="submit" style="padding: 12px 50px;"
                                    class="effect-btn btn btn-secondary pl-3 pr-3">Submit</button>
                            </div>
                            <a href=""><b>Terms of Use</b></a> | <a href=""><b>Privacy Policy</b></a><br>
                            <p class="ad-register-text">Copyright VNR Seeeds Pvt. Ltd. All Right Reserved.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>