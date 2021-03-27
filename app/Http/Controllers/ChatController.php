<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use App\Events\ChatStoredEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function discussChats()
    {
        $chats = Chat::with('users')->where('channel', 'chat-channel')->orderBy('created_at', 'asc')->get();

        $data['chats'] = $chats;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data chat berhasil diambil',
            'response_data' => $data
        ], 200);
    }

    public function storeDiscuss(Request $request)
    {
        $chat = Chat::create([
            "subject" => $request->subject,
            'user_id' => auth()->user()->user_id,
            "channel" => $request->channel
        ]);

        broadcast(new ChatStoredEvent($chat))->toOthers();

        $data['chat'] = $chat;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Pesan berhasil tersimpan.',
            'response_data' => $data
        ]);
    }

    public function adminChats($user_id)
    {
        $user = User::find($user_id);
        $chats = Chat::with('users')->where('channel', "admin-".$user_id)->orderBy('created_at', 'asc')->get();
        $data['chats'] = $chats;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data chat berhasil diambil',
            'response_data' => $data
        ], 200);
    }

    public function getAllUsers()
    {
        $users = User::all();
        $data['users'] = $users;

        return response()->json([
            "response_code" => "00",
            "response_message" => "Data users berhasil diambil.",
            "response_data" => $data
        ]);
    }
}
