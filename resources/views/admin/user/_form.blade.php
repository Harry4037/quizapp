<div class="box-body">
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Mobile Number <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Mobile Number" type="text" class="form-control" name="mobile_number" id="mobile_number" @if(isset($user)){{'readonly'}}@endif value="@if(isset($user)){{$user->mobile_number}}@endif">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Select Profile Pic</label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input type="file" class="form-control" name="profile_pic" id="profile_pic">
        </div>
    </div>
    @if(isset($user))
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Profile Pic. Preview</label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <img class="img-circle" src="{{$user->profile_pic}}" style="width: 50%">
        </div>
    </div>
    @endif
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Name <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Name" type="text" class="form-control" name="user_name" id="user_name" value="@if(isset($user)){{$user->name}}@endif">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Email <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Email" type="text" class="form-control" name="user_email" id="user_email" value="@if(isset($user)){{$user->email}}@endif">
        </div>
    </div>
</div>
<!-- /.box-body -->
<div class="box-footer">
    <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
            <a class="btn btn-default" href="{{ route('admin.user.index') }}">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
<!-- /.box-footer -->
