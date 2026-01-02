<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Ganti 'Message' dengan nama Model yang benar di aplikasi Anda (misal: Contact, Pesan, atau Message)
use App\Models\Message; 

class MessageController extends Controller
{
    public function index()
    {
        // Ambil semua pesan, urutkan dari yang terbaru
        $messages = Message::latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        
        // Opsional: Tandai sebagai sudah dibaca jika ada kolom 'is_read'
        // $message->update(['is_read' => true]);
        
        return view('admin.messages.show', compact('message'));
    }

    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}