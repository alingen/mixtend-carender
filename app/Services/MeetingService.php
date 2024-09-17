<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MeetingService
{
    public function getMeetingsData()
    {
        // APIからデータを取得
        $response = Http::withHeaders([
            'User-Agent' => 'Mixtend Coding Test'
        ])->get('https://mixtend.github.io/schedule.json');
        $data = $response->json();

        // レスポンスをログに記録
        Log::info('API Response: ', $response->json());

        // 30分ごとの時間帯を生成
        $data['times'] = $this->generateTimeSlots($data['working_hours']['start'], $data['working_hours']['end']);

        return $data;
    }

    private function generateTimeSlots($start, $end)
    {
        // 30分ごとの時間帯を生成する処理を移動
        $times = [];
        $end = date('H:i', strtotime($end . '+1 hour')); // 19-20時の予定を表示するため1時間後ろにずらす
        $time = $start;
        while ($time < $end) {
            $times[] = $time;
            $time = date('H:i', strtotime($time . '+30 minutes'));
        }
        return $times;
    }
}
