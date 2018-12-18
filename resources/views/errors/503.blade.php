@extends('layouts.app')

@section('content')
<div class="">
    <div class="col-middle">
        <div class="text-center text-center">
            <h1 class="error-number">500</h1>
            <h2>Internal Server Error</h2>
            <p>We track these errors automatically, but if the problem persists feel free to contact us. In the meantime, try refreshing.
                <a class="link" href="{{ url('/') }}">back</a>
            </p>
            <div class="mid_center">

            </div>
        </div>
    </div>
</div>
@endsection
