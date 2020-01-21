<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Select Question Image</label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input type="file" class="form-control" name="ques_image" id="ques_image">
    </div>
</div>
@if(isset($question))
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Question Img. Preview</label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <img class="img-circle" src="{{$question->ques_image}}" style="width: 50%">
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
                        @if(isset($question))
                        @if($question->subject_id == $subject->id)
                        {{ 'selected' }}
                        @endif
                        @endif
                        >{{$subject->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
@if(isset($exams))
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Exams <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <select class="form-control" name="exam_id" id="exam_id">
                <option value="">Choose Option</option>
                @foreach($exams as $exam)
                <option value="{{$exam->id}}"
                        @if(isset($question))
                        @if($question->exam_id == $exam->id)
                        {{ 'selected' }}
                        @endif
                        @endif
                        >{{$exam->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Description </label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input placeholder="Description" type="text" class="form-control" name="description" id="description" value="@if(isset($question)){{$question->description}}@endif">
    </div>
</div>

</div>
<!-- /.box-body -->
<div class="box-footer">
<div class="form-group">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
        <a class="btn btn-default" href="{{ route('admin.exam.index') }}">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</div>
<!-- /.box-footer -->
