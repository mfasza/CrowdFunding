<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use App\Events\ChatStoredEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function allChats()
    {
        $chats = Chat::with('users')->orderBy('created_at', 'asc')->get();

        $data['chats'] = $chats;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data chat berhasil diambil',
            'response_data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $chat = Chat::create([
            "subject" => $request->subject,
            'user_id' => auth()->user()->user_id,
        ]);

        broadcast(new ChatStoredEvent($chat))->toOthers();

        $data['chat'] = $chat;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Pesan berhasil tersimpan.',
            'response_data' => $data
        ]);
    }
}
