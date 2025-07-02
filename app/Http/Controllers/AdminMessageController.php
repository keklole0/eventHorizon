<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderByDesc('created_at')->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function show($message)
    {
        $message = ContactMessage::findOrFail($message);
        return view('admin.messages.show', compact('message'));
    }

    public function destroy($message)
    {
        $message = ContactMessage::findOrFail($message);
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Сообщение удалено');
    }
} 