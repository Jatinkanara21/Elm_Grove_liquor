<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message): View
    {
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message): RedirectResponse
    {
        $message->update(['status' => 'read']);
        return back()->with('success', 'Message marked as read.');
    }

    public function archive(ContactMessage $message): RedirectResponse
    {
        $message->update(['status' => 'archived']);
        return back()->with('success', 'Message archived.');
    }
}