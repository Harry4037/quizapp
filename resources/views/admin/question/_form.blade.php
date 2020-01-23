<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Select Question Image</label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input type="file" class="form-control" name="ques_image" id="ques_image">
    </div>
</div>
@if(isset($question->ques_image))
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Question Img. Preview</label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <img class="img-circle" src="{{$question->ques_image}}" style="width: 50%">
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
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Question Name <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input placeholder="Description" type="text" required class="form-control" name="description" id="description" value="@if(isset($question)){{$question->description}}@endif">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Question Time <span class="error">*(in second)</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        @if(isset($question))
        <select class="form-control" id="time" name="time" required>
            <option value="">Choose option</option>
            <option value="10" @if($question->ques_time == "10"){{'selected'}}@endif>10 Sec</option>
            <option value="20" @if($question->ques_time == "20"){{'selected'}}@endif>20 Sec</option>
            <option value="30" @if($question->ques_time == "30"){{'selected'}}@endif>30 Sec</option>
            <option value="40" @if($question->ques_time == "40"){{'selected'}}@endif>40 Sec</option>
            <option value="50" @if($question->ques_time == "50"){{'selected'}}@endif>50 Sec</option>
            <option value="60" @if($question->ques_time == "60"){{'selected'}}@endif>60 Sec</option>
        </select>
        @else
        <select class="form-control" id="time" name="time" required>
            <option value="">Choose option</option>
            <option value="10">10 Sec</option>
            <option value="20">20 Sec</option>
            <option value="30">30 Sec</option>
            <option value="40">40 Sec</option>
            <option value="50">50 Sec</option>
            <option value="60">60 Sec</option>
        </select>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Option1 <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input  type="text" class="form-control" required name="ans1" id="ans1" value="@if(isset($answers)){{$answers[0]->description}}@endif">
        <input type="hidden" id="custId" name="answer1" value="@if(isset($answers)){{$answers[0]->id}}@endif">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Option2 <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input  type="text" class="form-control" required name="ans2" id="ans2" value="@if(isset($answers)){{$answers[1]->description}}@endif">
        <input type="hidden" id="custId" name="answer2" value="@if(isset($answers)){{$answers[1]->id}}@endif">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Option3 <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input  type="text" class="form-control" required name="ans3" id="ans3" value="@if(isset($answers)){{$answers[2]->description}}@endif">
        <input type="hidden" id="custId" name="answer3" value="@if(isset($answers)){{$answers[2]->id}}@endif">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Option4 <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input  type="text" class="form-control"required  name="ans4" id="ans4" value="@if(isset($answers)){{$answers[3]->description}}@endif">
        <input type="hidden" id="custId" name="answer4" value="@if(isset($answers)){{$answers[3]->id}}@endif">
    </div>
</div>
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

<!-- /.box-body -->
<div class="box-footer">
<div class="form-group">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
        <a class="btn btn-default" href="{{ route('admin.question.index') }}">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</div>
<!-- /.box-footer -->
</div>
