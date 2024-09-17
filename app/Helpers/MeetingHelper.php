<?php

namespace App\Helpers;

use Carbon\Carbon;

class MeetingHelper
{
    public static function calculateHeightClass($start, $end)
    {
        // startとendを取得して差を整数に変換
        $meetingStart = Carbon::parse($start);
        $meetingEnd = Carbon::parse($end);
        $duration = $meetingStart->diffInMinutes($meetingEnd);

        // 30分ごとに高さクラスを計算
        return 'h-' . ($duration / 30 * 12); // 例: 60分なら h-24, 30分なら h-12
    }
}
