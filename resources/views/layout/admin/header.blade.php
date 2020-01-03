<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Q</b>A</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Quiz</b> App</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ auth()->user()->profile_pic }}" class="user-image" alt="">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ auth()->user()->profile_pic }}" class="img-circle" alt="">

                            <p>
                                {{ auth()->user()->name }}
                                <!--<small>Member since Nov. 2012</small>-->
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="{{route('admin.change-password')}}"><u>Change Password</u></a>
                                </div>
                                <!--                                <div class="col-xs-4 text-center">
                                                                    <a href="#">Option2</a>
                                                                </div>
                                                                <div class="col-xs-4 text-center">
                                                                    <a href="#">Option3</a>
                                                                </div>-->
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>
@include('layout.admin.control-sidebar')
