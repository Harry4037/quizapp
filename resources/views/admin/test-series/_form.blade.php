<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Test Series Name <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input type="text" class="form-control" required name="testseries_name" id="testseries_name" value="@if(isset($series)){{$series->name}}@endif">
    </div>
</div>
@if(isset($exams))
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Exams <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <select class="form-control" name="exam_id" id="exam_id">
                <option value="">Choose Option</option>
                @foreach($exams as $exam)
                <option value="{{$exam->id}}"
                        @if(isset($series))
                        @if($series->exam_id == $exam->id)
                        {{ 'selected' }}
                        @endif
                        @endif
                        >{{$exam->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

@endif
@if(isset($subjects))
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Subjects <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <select class="form-control" name="subject_id" id="subject_id">
                <option value="">Choose Option</option>
                @foreach($subjects as $subject)
                <option value="{{$subject->id}}"
                        @if(isset($series))
                        @if($series->subject_id == $subject->id)
                        {{ 'selected' }}
                        @endif
                        @endif
                        >{{$subject->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
    @if(isset($series))

@else
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Total Questions <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input type="number" class="form-control" required name="total_question" id="total_question" value="">
    </div>
</div>
@endif
<div id="question_div"></div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Language <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        @if(isset($series))
        <select class="form-control" id="lang_type" name="lang_type" required>
            <option value="">Choose option</option>
            <option value="1" @if($series->lang == "1"){{'selected'}}@endif>English</option>
            <option value="2" @if($series->lang == "2"){{'selected'}}@endif>Hindi</option>
        </select>
        @else
        <select class="form-control" id="lang_type" name="lang_type" required>
            <option value="">Choose option</option>
            <option value="1">English</option>
            <option value="2">Hindi</option>
        </select>
        @endif
    </div>
</div>
<!-- /.box-body -->
<div class="box-footer">
<div class="form-group">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
        <a class="btn btn-default" href="{{ route('admin.test-series.index') }}">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</div>
<!-- /.box-footer -->
</div>
