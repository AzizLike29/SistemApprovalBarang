@if (session('success'))
    <div class="alert alert-success alert-dismissible float_end">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Success!</strong> {{ session('success') }}
    </div>
@endif

@if (session('failed'))
    <div class="alert alert-danger alert-dismissible float_end">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Failed!</strong> {{ session('failed') }}
    </div>
@endif
