<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\MeetingService;

class MeetingController extends Controller
{
    protected $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    public function index()
    {
        $data = $this->meetingService->getMeetingsData();
        $times = $data['times'];

        // 取得したデータをビューに渡す
        return view('meetings.index', ['data' => $data, 'times' => $times]);
    }
}
