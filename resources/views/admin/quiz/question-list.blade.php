@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quiz Management
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
                        <h3 class="box-title">Question List</h3>
                        <div class="pull-right">
                            {{-- <a href="{{ route('admin.quiz.add-question', $quiz) }}" class="btn btn-block btn-primary">Add</a> --}}
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Question</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($questions)
                                @foreach($questions as $k => $question)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $question->description }}</td>
                                    <td>
                                        <a href="{{ route('admin.quiz.edit-question', $question->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                        &nbsp;&nbsp;<a href="javaScript:void(0);" id="{{ $question->id }}" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
                                    </td>
                                </tr>
                                @endforeach
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

@section('script')
<script>

    var t = $('#list').DataTable({
        lengthMenu: [[10, 25, 50], [10, 25, 50]],
        searching: true,
        sorting: false
    });

    $(document).ready(function () {

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            deletePopup(
                    "Deleting User",
                    "Are you sure want to delete this Question?",
                    record_id,
                    "{{route('admin.quiz.delete-question')}}",
                    );
        });
    });
</script>
@endsection
