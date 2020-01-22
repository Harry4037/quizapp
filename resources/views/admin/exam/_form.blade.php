    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Name <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Name" type="text" class="form-control" name="exam_name" id="exam_name" value="@if(isset($exam)){{$exam->name}}@endif">
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
</div>
