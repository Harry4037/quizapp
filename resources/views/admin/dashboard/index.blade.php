@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        @include('layout.admin.breadcrumbs')
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            @include('errors.errors-and-messages')

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="{{ route('admin.question.index')}}"> <span class="info-box-icon bg-aqua"><i class="fa fa-question"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Questions</span></a>
                    <span class="info-box-number">{{$totalQuestionCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <a href="{{ route('admin.creator.index')}}"><span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Creator</span></a>
                <span class="info-box-number">{{$creatorCount}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
</div>
<!-- /.col -->

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <a href="{{ route('admin.user.index')}}"> <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Users</span></a>
        <span class="info-box-number">{{$usersCount}}</span>
    </div>
    <!-- /.info-box-content -->
</div>
<!-- /.info-box -->
</div>

</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-12">
        <!-- DIRECT CHAT -->
        <div class="box box-warning direct-chat direct-chat-warning">
            <div class="box-header with-border">
                <h3 class="box-title">User's Rank</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <table id="list" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>Rank No.</th>
                            <th>Profile Pic.</th>
                            <th>UserName</th>
                            <th>Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($rankingArray)
                        @foreach($rankingArray as $k=>$ranking)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td><img class="img-circle" width="50" src="{{ $ranking['profile_pic'] }}"></td>
                            <td>{{ $ranking['name'] }}</td>
                            <td>{{ $ranking['total_correct_answer'] }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

            </div>
            <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <!-- /.col -->

    <div class="col-md-6">
        <!-- USERS LIST -->
<!--        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Members</h3>

                <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
             /.box-header
            <div class="box-body no-padding">
                <ul class="users-list clearfix">
                    <li>
                        <img src="dist/img/user1-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander Pierce</a>
                        <span class="users-list-date">Today</span>
                    </li>
                    <li>
                        <img src="dist/img/user8-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Norman</a>
                        <span class="users-list-date">Yesterday</span>
                    </li>
                    <li>
                        <img src="dist/img/user7-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Jane</a>
                        <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                        <img src="dist/img/user6-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">John</a>
                        <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                        <img src="dist/img/user2-160x160.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander</a>
                        <span class="users-list-date">13 Jan</span>
                    </li>
                    <li>
                        <img src="dist/img/user5-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Sarah</a>
                        <span class="users-list-date">14 Jan</span>
                    </li>
                    <li>
                        <img src="dist/img/user4-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nora</a>
                        <span class="users-list-date">15 Jan</span>
                    </li>
                    <li>
                        <img src="dist/img/user3-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nadia</a>
                        <span class="users-list-date">15 Jan</span>
                    </li>
                </ul>
                 /.users-list
            </div>
             /.box-body
            <div class="box-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Users</a>
            </div>
             /.box-footer
        </div>-->
        <!--/.box -->
    </div>
    <!-- /.col -->
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
<script>

    var t = $('#list').DataTable({
        lengthMenu: [[10, 25, 50], [10, 25, 50]],
        searching: true,
        sorting: false
    });

</script>
@endsection
