@extends('layouts.app')

@section('content')
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Welkom op mijn portfolio!</h1>
                <p class="lead">Dit is de centrale plek voor mijn projecten, skills, nieuws en meer. Ontdek wie ik ben, wat ik doe en neem gerust contact op!</p>
                <div class="hero-actions">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                    @endguest
                </div>
            </div>
            <img src="{{ asset('images/profile.png') }}" alt="Profiel" class="profile-img">
        </div>
    </div>
</section>
@endsection