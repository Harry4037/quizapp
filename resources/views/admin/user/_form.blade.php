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
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Email</label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Email" type="email" class="form-control" name="user_email" id="user_email" value="@if(isset($user)){{$user->email}}@endif">
        </div>
    </div>
    {{-- <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Dob <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input type="date" class="form-control valid" name="dob" id="dob" placeholder="Date Of Birth" value="@if(isset($user)){{$user->dob}}@endif">
        </div>
    </div> --}}
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Dob </label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="dob" name="dob" value="@if(isset($user)){{$user->dob}}@endif">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Designation </label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Designation" type="text" class="form-control" name="designation" id="designation" value="@if(isset($user)){{$user->designation}}@endif">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Qualification </label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="Qualification" type="text" class="form-control" name="qualification" id="qualification" value="@if(isset($user)){{$user->qualification}}@endif">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">About Us </label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <input placeholder="About Us" type="text" class="form-control" name="about" id="about" value="@if(isset($user)){{$user->into_line}}@endif">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Lang <span class="error">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-6">
            @if(isset($user))
            <select class="form-control" id="lang_type" name="lang_type">
                <option value="">Choose option</option>
                <option value="1" @if($user->lang == "1"){{'selected'}}@endif>English</option>
                <option value="2" @if($user->lang == "2"){{'selected'}}@endif>Hindi</option>
            </select>
            @else
            <select class="form-control" id="lang_type" name="lang_type">
                <option value="">Choose option</option>
                <option value="1">English</option>
                <option value="2">Hindi</option>
            </select>
            @endif
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
</div>
