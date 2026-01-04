@php
    /** @var \App\Models\ContactMessage $messageModel */
@endphp

<p>Thanks for your message. Here is a reply from the admin:</p>

<hr>

<p style="white-space: pre-wrap;">{{ e($messageModel->admin_reply) }}</p>

<hr>

<p><strong>Your original message:</strong></p>
<p style="white-space: pre-wrap;">{{ e($messageModel->message) }}</p>
