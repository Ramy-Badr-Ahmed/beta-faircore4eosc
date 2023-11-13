@if (session()->has('success-message'))

<div class="alert alert-dismissible fade in" data-dismiss="alert" style="color: #157788">
    <div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="alert-heading">Success!</h5>
        {!! session('success-message') !!}
    </div>
</div>

@endif

@if (session()->has('warning-message'))
    <div class="alert alert-warning alert-dismissible  fade in"  role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="alert-heading">Warning!</h5>
        {!! session()->get('warning-message') !!}

    </div>
@endif

@if (session()->has('error-message'))
    <div class="alert alert-danger alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="alert-heading">Error!</h5>
        {!! session('error-message') !!}
        <div>
            {!! session('another-message') !!}
        </div>

    </div>
@endif
