<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::when(request()->filled('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view('admin.messages.index', [
            'messages' => $messages,
            'unread' => ContactMessage::unread()->count(),
        ]);
    }

    public function show(ContactMessage $message)
    {
        $message->update(['status' => 'read']);

        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['status' => 'read']);

        return back()->with('success', 'Marked as read.');
    }

    public function archive(ContactMessage $message)
    {
        $message->update(['status' => 'archived']);

        return back()->with('success', 'Message archived.');
    }
}