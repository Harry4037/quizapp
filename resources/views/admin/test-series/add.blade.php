@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Test Series Management
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
                        <h3 class="box-title">Test Series Add</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.test-series.add') }}" method="post" id="testseriesForm" enctype="multipart/form-data">
                        @csrf
                        @include('admin.test-series._form')
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

        $("#testseriesForm").validate({
            rules: {
                exam_id: {
                    required: true
                },
                subject_id: {
                    required: true
                },
                total_question: {
                    required: true,
                    min: 1
                },
            },
        });
        $(document).on("keyup", "#total_question", function () {
            var days = parseInt($("#total_question").val());
            if (days < 0) {
                $("#total_question").val(0);
                return false;
            }
            var i;
            $("#question_div").html('');
            if (days > 0) {
                for (i = 0; i < days; i++) {
                    var quesNo = i + 1;
                    var day_html = '<div class="box-footer">'
                            + '<label class="control-label">Question ' + quesNo + ':-</label>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Question Name <span class="error">*</span></label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<textarea class="form-control" name="description[' + i + ']" ></textarea>'
                            + '</div>'
                            + '</div>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Select Question Image</label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<input type="file" class="form-control" name="ques_image[' + i + ']">'
                            + '</div>'
                            + '</div>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Question Time <span class="error">*</span></label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<select class="form-control" name="time[]">'
                            + '<option value="60" selected>1 Min</option>'
                            + '<option value="90">1 Min 30Sec</option>'
                            + '<option value="120">2 Min</option>'
                            + '<option value="150">2 Min 30Sec</option>'
                            + '<option value="180">3 Min</option>'
                            + '</select>'
                            + '</div>'
                            + '</div>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Option1 <span class="error">*</span></label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<input  type="text" class="form-control" name="ans1[' + i + ']" value="">'
                            + '</div>'
                            + '</div>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Option2 <span class="error">*</span></label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<input  type="text" class="form-control" name="ans2[' + i + ']" value="">'
                            + '</div>'
                            + '</div>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Option3 <span class="error">*</span></label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<input  type="text" class="form-control" name="ans3[' + i + ']" value="">'
                            + '</div>'
                            + '</div>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Option4 <span class="error">*</span></label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<input  type="text" class="form-control" name="ans4[' + i + ']" value="">'
                            + '</div>'
                            + '</div>'
                            + '<div class="form-group">'
                            + '<label class="control-label col-md-4 col-sm-4 col-xs-12">Correct Option <span class="error">*</span></label>'
                            + '<div class="col-md-4 col-sm-6 col-xs-6">'
                            + '<select class="form-control" name="correct_answer[' + i + ']">'
                            + '<option value="">Choose option</option>'
                            + '<option value="opt1">option1</option>'
                            + '<option value="opt2">option2</option>'
                            + '<option value="opt3">option3</option>'
                            + '<option value="opt4">option4</option>'
                            + '</select>'
                            + '</div>'
                            + '</div>'
                            + '</div>';
                    $("#question_div").append(day_html);
                    $("textarea[name='description[" + i + "]']").rules("add", {required: true});
                    $("input[name='ans1[" + i + "]']").rules("add", {required: true});
                    $("input[name='ans2[" + i + "]']").rules("add", {required: true});
                    $("input[name='ans3[" + i + "]']").rules("add", {required: true});
                    $("input[name='ans4[" + i + "]']").rules("add", {required: true});
                    $("select[name='correct_answer[" + i + "]']").rules("add", {required: true});
                }

            }

        });


    });
</script>
@endsection
