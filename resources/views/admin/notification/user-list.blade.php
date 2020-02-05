<p style="padding: 4px;">
    @if($users)
    @foreach($users as $key => $user)
    <input class="flat" type="checkbox" name="notify_user[]" value="{{ $user->id }}"> 
    {{ ucwords($user->user_name) }}
    @endforeach
    @endif
<p>