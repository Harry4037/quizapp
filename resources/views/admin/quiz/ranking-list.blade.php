@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quiz Ranking List
        </h1>
        @include('layout.admin.breadcrumbs')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('errors.errors-and-messages')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Ranking List</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Mobile</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($comments)
                                @foreach($comments as $k => $comment)

                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$comment['mob']}}</td>
                                    <td>{{$comment['name']}}</td>
                                    <td><img class="img-bordered" height="60" width="100" src={{$comment['image']}}></td>
                                    <td>{{$comment['points']}}</td>

                                </tr>
                                @endforeach
                                @else
                                <tr>

                                    <td colspan="5">No User Found</td>

                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
