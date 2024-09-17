<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ミーティングカレンダー</title>
    <style>
    </style>
    @vite('resources/css/app.css')
</head>
<body>
    <h1 class="p-12">カレンダーUI</h1>
    @php
        // working_hoursからstartとendを取得して、30分ごとの時間帯を生成
        $times = [];
        $start = $data['working_hours']['start'];
        $end = date('H:i', strtotime($data['working_hours']['end'] . '+1 hour')); // 19-20時の予定表示するため1時間後ろにずらす
        $time = $start;
        while($time < $end) {
            $times[] = $time;
            $time = date('H:i', strtotime($time . '+30 minutes'));
        }
    @endphp

    <div class="flex p-4">
        <ul class="time-slot-list w-1/6">
            <div class="h-12 border"></div>
            @for ($i = 0; $i < count($times); $i++)
                {{-- 1時間ごとの時間帯を表示 --}}
                @if ($i % 2 == 0)
                    <li class="h-24 border flex justify-center">
                        <span class="relative">{{$times[$i]}}</span>
                    </li>
                @endif
            @endfor
        </ul>
      
        <div class="flex-1 flex">
            @foreach($data['meetings'] as $date => $meetings)
            <ul class="w-1/3">
                <li class="h-12 border flex items-center justify-center">
                    <span>{{ \Carbon\Carbon::parse($date)->locale('ja')->isoFormat('M/D(ddd)') }}</span>
                </li>
                @foreach($times as $time)
                    @php
                    $meetingFound = false;
                    @endphp
                    @foreach($meetings as $meeting)
                        @php
                            // startとendを取得して差を整数に変換
                            $meetingStart = \Carbon\Carbon::parse($meeting['start']);
                            $meetingEnd = \Carbon\Carbon::parse($meeting['end']);
                            $duration = $meetingStart->diffInMinutes($meetingEnd);
                            $heightClass = 'h-' . ($duration / 30 * 12); // 30分ごとにh-12の高さに変換
                        @endphp
                        @if($meeting['start'] == $time)
                            <li class="hour relative h-12">
                                <div class="absolute bg-teal-400 text-white p-4 rounded h-full w-full {{ $heightClass }} absolute">
                                    {{ $meeting['summary'] }}
                                </div>
                            </li>
                            @php
                                $meetingFound = true; // 予定が見つかったらフラグを立ててループを抜ける
                                break;
                            @endphp
                        @endif
                    @endforeach
                    @if(!$meetingFound)
                        <li class="h-12 border"></li>
                    @endif
                @endforeach
            </ul>
            @endforeach
        </div>
      </div>
      
</body>
</html>
