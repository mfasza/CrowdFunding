<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function allChats()
    {
        $chats = Chat::with('users')->where('user_id', auth()->user()->user_id)->orderBy('created_at', 'asc')->get();

        $data['chats'] = $chats;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data chat berhasil diambil',
            'response_data' => $data
        ], 200);
    }
}
