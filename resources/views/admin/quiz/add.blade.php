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
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quiz Add</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.quiz.add') }}" method="post" id="questionForm" enctype="multipart/form-data">
                        @csrf
                        @include('admin.quiz._form')
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

        $('#start_date_time').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            startDate: new Date(),
            minDate: new Date(),
            singleClasses: "picker_2",
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        }, function (start, end, label) {
            $('#end_date_time').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                singleClasses: "picker_2",
                startDate: start,
                minDate: start,
                locale: {
                    format: 'YYYY/M/DD hh:mm:ss A'
                }});

        });

        $('#end_date_time').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            startDate: new Date(),
            minDate: new Date(),
            singleClasses: "picker_2",
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        });


        $("#questionForm").validate({
            rules: {

            },
            messages: {

            }
        });

    });
</script>
@endsection
