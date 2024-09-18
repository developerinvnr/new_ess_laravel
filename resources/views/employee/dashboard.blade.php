<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"
        rel="stylesheet">

</head>

<body>
    <nav class="main-menu">

        <div>
            <a class="logo" href="">
            </a>
        </div>
        <div class="settings"></div>
        <div class="scrollbar" id="style-1">

            <ul>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto"></ul>
    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                        <!DOCTYPE html>
                        <html lang="en">
                        
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>@yield('title', 'Dashboard')</title>
                            <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
                            <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"
                                rel="stylesheet">
                        
                        </head>
                        
                        <body>
                            <nav class="main-menu">
                        
                                <div>
                                    <a class="logo" href="">
                                    </a>
                                </div>
                                <div class="settings"></div>
                                <div class="scrollbar" id="style-1">
                        
                                    <ul>
                        
                                        </li>
                                        <li class="darkerlishadow">
                                            <a href="">
                                                <i class="fa fa-clock-o fa-lg"></i>
                                                <span class="nav-text">xyz</span>
                                            </a>
                                        </li>
                        
                                        <li class="darkerli">
                                            <a href="">
                                                <i class="fa fa-desktop fa-lg"></i>
                                                <span class="nav-text">xyz</span>
                                            </a>
                                        </li>
                        
                                        <li class="darkerli">
                                            <a href="">
                                                <i class="fa fa-plane fa-lg"></i>
                                                <span class="nav-text">abc</span>
                                            </a>
                                        </li>
                        
                                        <li class="darkerli">
                                            <a href="">
                                                <i class="fa fa-shopping-cart"></i>
                                                <span class="nav-text">abc</span>
                                            </a>
                                        </li>
                        
                                        <li class="darkerli">
                                            <a href="">
                                                <i class="fa fa-microphone fa-lg"></i>
                                                <span class="nav-text">xyz</span>
                                            </a>
                                        </li>
                        
                                        <li class="darkerli">
                                            <a href="">
                                                <i class="fa fa-flask fa-lg"></i>
                                                <span class="nav-text">xyz</span>
                                            </a>
                                        </li>
                        
                                        <li class="darkerli">
                                            <a href="">
                                                <i class="fa fa-picture-o fa-lg"></i>
                                                <span class="nav-text">xyz</span>
                                            </a>
                                        </li>
                        
                                        <li class="darkerli">
                                            <a href="">
                                                <i class="fa fa-align-left fa-lg"></i>
                                                <span class="nav-text">xyz
                                                </span>
                                            </a>
                                        </li>
                        
                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <!-- Left Side Of Navbar -->
                                            <ul class="navbar-nav mr-auto"></ul>
                            
                                            <!-- Right Side Of Navbar -->
                                            <ul class="navbar-nav ml-auto">
                                                @guest
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                                                    </li>
                                                @else
                                                    <li class="nav-item dropdown">
                                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                            {{ Auth::user()->Fname . ' ' . Auth::user()->Sname .''. Auth::user()->Lname }}
                                                        </a>
                            
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                Logout
                                                            </a>
                            
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </li>
                                                @endguest
                                            </ul>
                                        </div>
                        
                                    </ul>
                            </nav>
                        </body>
                        
                        </html>
                        
                        @endguest
                    </ul>
                </div>

            </ul>
    </nav>
</body>

</html>
