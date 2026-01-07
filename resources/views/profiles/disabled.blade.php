@extends('layouts.app')

@section('content')
<section class="public-profile">
    <div class="container">
        <div class="alert alert-info mt-5 mb-5">
            <i class="fas fa-user-slash"></i> {{ __('Public profiles are currently disabled by the site administrator.') }}
        </div>
    </div>
</section>
@endsection
