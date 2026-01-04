@php
    /** @var \App\Models\ContactMessage $messageModel */
@endphp

<h2>New contact message</h2>

<p><strong>Name:</strong> {{ e($messageModel->name) }}</p>
<p><strong>Email:</strong> {{ e($messageModel->email) }}</p>
@if($messageModel->subject)
<p><strong>Subject:</strong> {{ e($messageModel->subject) }}</p>
@endif

<hr>

<p style="white-space: pre-wrap;">{{ e($messageModel->message) }}</p>

<hr>

<p>
    Admin inbox: <a href="{{ route('admin.contact.show', $messageModel) }}">View message #{{ $messageModel->id }}</a>
</p>
