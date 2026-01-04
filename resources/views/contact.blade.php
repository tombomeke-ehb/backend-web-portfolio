{{--
  Source attribution:
  - Original portfolio page derived from https://tombomeke.com (author: Tom Dekoning).
  - Modified/adapted for this Laravel Backend Web course project.
--}}

@extends('layouts.app')

@section('content')
<section class="contact">
    <div class="container">
        <h1><i class="fas fa-envelope"></i> <span data-translate="contact_title"></span></h1>
        <p class="section-intro" data-translate="contact_intro"></p>
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        <div class="contact-content">
            <div class="contact-form-wrapper">
                <h2 data-translate="contact_send_message"></h2>
                <form method="POST" action="{{ route('contact.submit') }}" class="contact-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i> <span data-translate="contact_name"></span> *
                        </label>
                        <input type="text" id="name" name="name" required minlength="2" placeholder="" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> <span data-translate="contact_email"></span> *
                        </label>
                        <input type="email" id="email" name="email" required placeholder="" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="subject">
                            <i class="fas fa-tag"></i> {{ __('Subject') }}
                        </label>
                        <input type="text" id="subject" name="subject" maxlength="150" placeholder="" value="{{ old('subject') }}">
                    </div>
                    <div class="form-group">
                        <label for="message">
                            <i class="fas fa-comment"></i> <span data-translate="contact_message"></span> *
                        </label>
                        <textarea id="message" name="message" rows="6" required minlength="10" placeholder="">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-paper-plane"></i> <span data-translate="contact_send"></span>
                    </button>
                </form>
            </div>
            <div class="contact-info-wrapper">
                <h2 data-translate="contact_direct"></h2>
                <p data-translate="contact_methods_intro"></p>
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="contact-method-icon"><i class="fas fa-envelope"></i></div>
                        <div class="contact-method-content">
                            <h3>E-mail</h3>
                            <a href="mailto:tom1dekoning@gmail.com">tom1dekoning@gmail.com</a>
                        </div>
                    </div>
                    <div class="contact-method">
                        <div class="contact-method-icon"><i class="fab fa-linkedin"></i></div>
                        <div class="contact-method-content">
                            <h3>LinkedIn</h3>
                            <a href="https://www.linkedin.com/in/tom-dekoning-567523352/" target="_blank">
                                <span data-translate="contact_view_profile"></span>
                            </a>
                        </div>
                    </div>
                    <div class="contact-method">
                        <div class="contact-method-icon"><i class="fab fa-github"></i></div>
                        <div class="contact-method-content">
                            <h3>GitHub</h3>
                            <a href="https://github.com/tombomeke" target="_blank">
                                <span data-translate="contact_view_repositories"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="cv-download-section">
                    <h3 data-translate="contact_view_cv"></h3>
                    <p data-translate="contact_cv_description"></p>
                    <a href="{{ route('cv.download') }}" class="btn btn-secondary btn-large">
                        <i class="fas fa-download"></i> <span data-translate="hero_download_cv"></span> (PDF)
                    </a>
                </div>
                <div class="availability-info">
                    <h3 data-translate="contact_availability"></h3>
                    <p><i class="fas fa-check-circle"></i> <span data-translate="contact_availability_freelance"></span></p>
                    <p><i class="fas fa-check-circle"></i> <span data-translate="contact_availability_collaboration"></span></p>
                    <p><i class="fas fa-clock"></i> <span data-translate="contact_availability_response"></span></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
