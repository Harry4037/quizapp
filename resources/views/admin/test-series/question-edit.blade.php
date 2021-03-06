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
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Add Question</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-horizontal form-label-left" action="{{ route('admin.test-series.edit-question', $question) }}" method="post" id="quizForm" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Question Name <span class="error">*</span></label>
                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                        <textarea class="form-control" name="description" id="description">{{ $question->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Select Question Image</label>
                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                        <input type="file" class="form-control" name="ques_image">
                                    </div>
                                </div>
                                @if(isset($question->ques_image))
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Question Img. Preview</label>
                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                        <img src="{{$question->ques_image}}" style="width: 50%">
                                    </div>
                                </div>
                                @endif
                                @if($answers)
                                @foreach($answers as $k=>$answer)
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Option{{$k+1}} <span class="error">*</span></label>
                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                        <input type="text" class="form-control" id="ans{{$k+1}}" name="ans{{$k+1}}" value="{{$answer->description}}">
                                        <input type="hidden" class="form-control" id="ansval{{$k+1}}" name="ansval{{$k+1}}" value="{{$answer->id}}">
                                    </div>
                                </div>
                                @endforeach
                                @endif

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Correct Option <span class="error">*</span></label>
                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                        @if(isset($answers))
                                        <select class="form-control" id="correct_answer" name="correct_answer">
                                            <option value="">Choose option</option>
                                            <option value="opt1" @if($answers[0]->is_answer == "1"){{'selected'}}@endif>option1</option>
                                            <option value="opt2" @if($answers[1]->is_answer == "1"){{'selected'}}@endif>option2</option>
                                            <option value="opt3" @if($answers[2]->is_answer == "1"){{'selected'}}@endif>option3</option>
                                            <option value="opt4" @if($answers[3]->is_answer == "1"){{'selected'}}@endif>option4</option>
                                        </select>
                                        @else
                                        <select class="form-control" id="correct_answer" name="correct_answer">
                                            <option value="">Choose option</option>
                                            <option value="opt1">option1</option>
                                            <option value="opt2">option2</option>
                                            <option value="opt3">option3</option>
                                            <option value="opt4">option4</option>
                                        </select>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
                                        <a class="btn btn-default" href="{{ route('admin.test-series.index') }}">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-footer -->

                        </form>
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

    $(document).ready(function () {

        $("#quizForm").validate({
            rules: {
                total_question: {
                    required: true,
                    min: 1
                },
            },
        });

    });
</script>
@endsection
