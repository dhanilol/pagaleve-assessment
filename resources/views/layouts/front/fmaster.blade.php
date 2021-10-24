<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">

        <!-- Bootstrap styles -->
        <link href="{{asset("site/bootstrap/css/style.css")}}" rel="stylesheet"/>
        <!-- Customize styles -->
        {{-- <link href="{{url('/')}}/assets/css/style.css" rel="stylesheet"/> --}}
        <!-- font awesome styles -->
        {{-- <link href="{{url('/')}}/assets/font-awesome/css/font-awesome.css" rel="stylesheet"> --}}

        <!-- Favicons -->
        {{-- <link rel="shortcut icon" href="assets/ico/favicon.ico"> --}}
    </head>

    <body>
        <!-- Upper Header Section -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="topNav">
                <div class="container">
                    <div class="alignR">
                        <div class="pull-left socialNw">
                            <a href="#"><span class="icon-twitter"></span></a>
                            <a href="#"><span class="icon-facebook"></span></a>
                            <a href="#"><span class="icon-youtube"></span></a>
                            <a href="#"><span class="icon-tumblr"></span></a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Lower Header Section -->
        <div class="container">
            <div id="gototop"> </div>
            <header id="header">
                <div class="row">
                    <div class="span4">
                        <h1>
                            <a class="logo" href="index.html"><span></span>
                                {{-- <img src="{{url('/')}}/assets/front/img/logo-bootstrap-shoping-cart.png" alt="bootstrap sexy shop"> --}}
                            </a>
                        </h1>
                    </div>
                </div>
            </header>

            <!-- Navigation Bar Section -->
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                    <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse">
                        <ul class="nav">
                            @if (Auth::check())
                                <li class=""><a href="{{url('/')}}/user">{{Auth::user()->name}}</a></li>
                            @endif
                        </ul>
                        
                        @if (!Auth::check())
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="icon-lock"></span> Login <b class="caret"></b></a>
                                    <div class="dropdown-menu">
                                        <form class="form-horizontal loginFrm" method="post" action="{{url('/')}}/login">
                                            @csrf
                                            <div class="control-group">
                                                <input type="email" name="email" class="span2" id="inputEmail" placeholder="Email" required>
                                            </div>
                                            
                                            <div class="control-group">
                                                <input type="password" name="password" class="span2" id="inputPassword" placeholder="Password" required>
                                            </div>

                                            <div class="control-group">					
                                                <button type="submit" class="shopBtn btn-block">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    </div>
                    </div>
                </div>
            </div>

            <!-- Body Section -->
                <div class="row">
                    
            <!--
            Side Bar
            -->
            @yield('fsidebar')

                <div class="span9">

            <!--
            Slider
            -->
            @yield('slider')

            <!-- content -->
            @yield('content')

            <!-- Footer -->

        </div><!-- /container -->

            <div class="copyright">
                <div class="container">
                    <p class="pull-right">
                        {{-- <a href="#"><img src="{{url('/')}}/assets/front/img/maestro.png" alt="payment"></a> --}}
                        {{-- <a href="#"><img src="{{url('/')}}/assets/front/img/mc.png" alt="payment"></a> --}}
                        {{-- <a href="#"><img src="{{url('/')}}/assets/front/img/pp.png" alt="payment"></a> --}}
                        {{-- <a href="#"><img src="{{url('/')}}/assets/front/img/visa.png" alt="payment"></a> --}}
                        {{-- <a href="#"><img src="{{url('/')}}/assets/front/img/disc.png" alt="payment"></a> --}}
                    </p>
                    {{-- <span>Copyright &copy; 2021</span> --}}
                </div>
            </div>
    </body>
</html>