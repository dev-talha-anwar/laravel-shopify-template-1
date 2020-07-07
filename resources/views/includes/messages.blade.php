@if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <div class="close" data-dismiss="alert">
            &times;
        </div>
        <div>{{ session('success') }}</div>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible">
        <div class="close" data-dismiss="alert">
            &times;
        </div>
        <div>{{ session('error') }}</div>
    </div>
@endif
@if($errors)
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <div class="close" data-dismiss="alert">
                &times;
            </div>
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
@endif
