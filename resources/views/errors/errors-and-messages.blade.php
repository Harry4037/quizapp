@if($errors->all())

<div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    @foreach($errors->all() as $message)
    {{ $message }}
    <br>
    @endforeach
</div>



@elseif(session()->has('message'))

<div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    {{ session()->get('message') }}
</div>

@elseif(session()->has('error'))

<div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    {{ session()->get('error') }}
</div>

@elseif(session()->has('status'))

<div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    {{ session()->get('status') }}
</div>

@endif
<div style="display: none;" class="alert msg" role="alert"></div>