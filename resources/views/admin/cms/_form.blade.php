<div class="box-body">
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Page Name <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input type="text" class="form-control" name="page_name" id="page_name" value="@if(isset($cms)){{$cms->page_name}}@endif" readonly="">
        </div>
    </div>

    @if($cms->id == 3)
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Email <span class="error">*</span></label>
        <div class="col-md-6 col-sm-8 col-xs-8">
            <input type="email" class="form-control" name="description" id="description" value="@if(isset($cms)){{$cms->title}}@endif" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Mobile <span class="error">*</span></label>
        <div class="col-md-6 col-sm-8 col-xs-8">
        <input type="text" class="form-control" name="mobile" id="mobile" value="@if(isset($cms)){{$cms->description}}@endif" >
        </div>
    </div>
    @else
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Title <span class="error">*</span></label>
        <div class="col-md-6 col-sm-8 col-xs-8">
        <input type="text" class="form-control" name="mobile" id="mobile" value="@if(isset($cms)){{$cms->title}}@endif" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Description <span class="error">*</span></label>
        <div class="col-md-6 col-sm-8 col-xs-8">
            <textarea class="form-control" name="description" id="description">@if(isset($cms)){{$cms->description}}@endif</textarea>
        </div>
    </div>
    @endif
</div>
<!-- /.box-body -->
<div class="box-footer">
    <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
            <a class="btn btn-default" href="{{ route('admin.cms.index') }}">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
<!-- /.box-footer -->
