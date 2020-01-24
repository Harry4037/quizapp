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
                        <h3 class="box-title">Quiz Edit</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.quiz.edit', $quiz) }}" method="post" id="quizForm" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Name <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input placeholder="Name" type="text" class="form-control" name="quiz_name" id="quiz_name" value="@if(isset($quiz)){{$quiz->name}}@endif">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Start Date Time <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="start_date_time" name="start_date_time">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">End Date Time <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="end_date_time" name="end_date_time">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Language <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <label class="radio-inline"><input type="radio" name="lang" value="1" @if($quiz->lang == 1){{ "checked" }}@endif>English</label>
                                    <label class="radio-inline"><input type="radio" name="lang" value="2" @if($quiz->lang == 2){{ "checked" }}@endif>Hindi</label>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
                                    <a class="btn btn-default" href="{{ route('admin.quiz.index') }}">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-footer -->

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
            minDate: new Date("{{ $quiz->start_date_time }}"),
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
            minDate: new Date("{{ $quiz->end_date_time }}"),
            singleClasses: "picker_2",
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        });

        $("#quizForm").validate({
            rules: {
                quiz_name: {
                    required: true
                },
                start_date_time: {
                    required: true
                },
                end_date_time: {
                    required: true
                },
                lang: {
                    required: true
                },
            },
            messages: {

            }
        });

    });
</script>
@endsection
