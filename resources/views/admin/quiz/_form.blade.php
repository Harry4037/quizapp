<div class="box-body">
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Name <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Name" type="text" class="form-control" name="quiz_name" id="quiz_name" value="@if(isset($question)){{$question->description}}@endif">
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
            <label class="radio-inline"><input type="radio" name="lang" checked value="1">English</label>
            <label class="radio-inline"><input type="radio" name="lang" value="2">Hindi</label>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Total Questions <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Total Questions" type="number" class="form-control" name="total_question" id="total_question" value="0">
        </div>
    </div>
</div>

<div id="question_div"></div>

<!-- /.box-body -->
<div class="box-footer">
    <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
            <a class="btn btn-default" href="{{ route('admin.exam.index') }}">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
<!-- /.box-footer -->
