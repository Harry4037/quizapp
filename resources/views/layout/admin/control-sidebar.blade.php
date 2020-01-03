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
            @if(Session::has('menus'))
            @foreach(Session::get('menus')[0] as $menu)
            @if(is_array($menu['child_menu']) && !empty($menu['child_menu']))
            <li class="treeview">
                <a href="#">
                    <i class="{{$menu['menu_icon']}}"></i> <span>{{$menu['menu_name']}}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @foreach($menu['child_menu'] as $child)
                    <li><a href="{{ route($child['menu_link'])}}"><i class="{{$child['menu_icon']}}"></i>{{$child['menu_name']}}</a></li>
                    @endforeach
                </ul>
            </li>
            @else
            <li>
                <a href="{{ route($menu['menu_link'])}}">
                    <i class="{{$menu['menu_icon']}}"></i> <span>{{$menu['menu_name']}}</span>
                </a>
            </li>
            @endif
            @endforeach
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
