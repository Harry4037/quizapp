@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Exam Management
        </h1>
        @include('layout.admin.breadcrumbs')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('errors.errors-and-messages')
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Exam</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.exam.add') }}" method="post" id="addExamForm" enctype="multipart/form-data">
                        @csrf
                        @include('admin.exam._form')
                    </form>
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
    $(document).ready(function () {

        $("#addExamForm").validate({
            rules: {
                exam_name: {
                    required: true
                },
            },
            messages: {

            }
        });
        $(document).on('keydown', "#exam_name", function (e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        console.log(charCode);
        if (((charCode == 8) || (charCode == 48) || (charCode == 57) || (charCode == 32) || (charCode == 46) || (charCode >= 35 && charCode <= 40) || (charCode >= 65 && charCode <= 90))) {
            return true;
        } else {
            return false;
        }
    });

    });
</script>
@endsection
