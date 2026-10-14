@if (Session::has('error'))
    <div class="alert alert-danger alert-block" id="flashMessage">
        {{ Session::get('error') }}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success alert-block" id="flashMessage">
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning alert-block" id="flashMessage">
        {{ Session::get('warning') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" id="flashMessage">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
