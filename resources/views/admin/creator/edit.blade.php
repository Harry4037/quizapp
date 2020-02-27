@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Creator Management
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
                        <h3 class="box-title">Creator Edit</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.creator.edit', $user) }}" method="post" id="userForm" enctype="multipart/form-data">
                        @csrf
                        @include('admin.creator._form')
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
        $('#dob').daterangepicker({
            singleDatePicker: true,
            maxDate: new Date(),
            singleClasses: "picker_2",
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        $("#userForm").validate({
            rules: {
                profile_pic: {
                    accept: "image/*",
                },
                user_name: {
                    required: true,
                },
                user_email: {
                    email: true,
                    required: true,
                },
            },
            messages: {
                profile_pic: {
                    accept: "Not valid image type"
                }
            }
        });
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
