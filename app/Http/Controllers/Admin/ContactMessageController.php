<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminContactReplyMail;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->string('filter')->toString(); // unread | replied | all

        $query = ContactMessage::query()->orderByDesc('created_at');

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'replied') {
            $query->whereNotNull('replied_at');
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.contact.index', compact('messages', 'filter'));
    }

    public function show(ContactMessage $message): View
    {
        $message->markRead();

        return view('admin.contact.show', compact('message'));
    }

    public function markUnread(ContactMessage $message): RedirectResponse
    {
        $message->markUnread();

        return redirect()->route('admin.contact.show', $message)->with('status', 'contact-marked-unread');
    }

    public function reply(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'reply' => ['required', 'string', 'min:2'],
        ]);

        $message->markReplied($validated['reply']);

        // Send reply to the user
        Mail::to($message->email)->send(new AdminContactReplyMail($message));

        ActivityLog::log('replied', "Replied to contact message from: {$message->name} ({$message->email})", $message);

        return redirect()->route('admin.contact.show', $message)->with('status', 'contact-replied');
    }
}
