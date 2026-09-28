<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(StoreContactRequest $request)
    {
        $message = 'Thank you! Your message was sent. We will get back to you soon.';

        // Honeypot: bots fill the hidden field. Pretend success and store nothing.
        if ($request->filled('website')) {
            return redirect()->route('contact')->with('success', $message);
        }

        ContactMessage::create($request->validated() + [
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('contact')->with('success', $message);
    }
}