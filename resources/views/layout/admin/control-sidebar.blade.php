<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img style="height: 35px;" src="{{ auth()->user()->profile_pic ? auth()->user()->profile_pic : asset('img/no-image.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ route('admin.dashboard')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.user.index')}}"><i class="fa fa-user"></i>User</a></li>
                    <li><a href="{{ route('admin.creator.index')}}"><i class="fa fa-user"></i>Creator</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.subject.index')}}">
                    <i class="fa fa-map-o"></i> <span>Subject</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.exam.index')}}">
                    <i class="fa fa-list"></i> <span>Exam</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.quiz.index')}}">
                    <i class="fa fa-question"></i> <span>Daily Quiz Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.question.index')}}">
                    <i class="fa fa-question-circle"></i> <span>Question Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.test-series.index')}}">
                    <i class="fa fa-question-circle"></i> <span>TestSeries Management</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
