<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function send($sesiId)
    {
        // logic kirim WA
        return back()->with('success', 'ZZZ Notifikasi WhatsApp dikirim');
    }
}
