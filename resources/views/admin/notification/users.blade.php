
@if($users)
<!--<div class="col-md-6 col-sm-6 col-xs-12" id="users_list" style="overflow-y: scroll;height: 200px;">-->
<p style="padding: 5px;">
    @foreach($users as $key => $user)
<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 4px;">
    <input class="flat" type="checkbox" name="notify_user[]" value="{{ $user->id }}"> 
    @if(strlen($user->name) > 0)
    <label>{{ $user->mobile_number.' ('.ucwords($user->name).')' }}</label>
    @else
    <label>{{ $user->mobile_number }}</label>
    @endif
</div>

@endforeach
</p>
<span id="users_list_div_error"></span>
<!--</div>-->
@endif
