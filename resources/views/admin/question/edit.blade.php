@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Question Management
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
                        <h3 class="box-title">Question Edit</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.question.edit', $question) }}" method="post" id="userForm" enctype="multipart/form-data">
                        @csrf
                        @include('admin.question._form')
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

        $("#userForm").validate({
            rules: {

            },
            messages: {
                profile_pic: {
                    accept: "Not valid image type"
                }
            }
        });

        $("#exam_id").select2();

        $(document).on('keydown', "#user_name", function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (((charCode == 8) || (charCode == 32) || (charCode == 46) || (charCode == 9) || (charCode >= 35 && charCode <= 40) || (charCode >= 65 && charCode <= 90))) {
                return true;
            } else {
                return false;
            }
        });

    });
</script>
@endsection
