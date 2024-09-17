<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MeetingController extends Controller
{
    public function index()
    {
        // APIからミーティングデータを取得
        $response = Http::get('https://mixtend.github.io/schedule.json');
        $data = $response->json();

        // 取得したデータをビューに渡す
        return view('meetings.index', ['data' => $data]);
    }
}
