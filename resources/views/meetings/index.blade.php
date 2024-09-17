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
      
        <div class="flex-1 flex border">
            @foreach($data['meetings'] as $date => $meetings)
            <ul class="w-1/3 border">
                <li class="h-12 border-b flex items-center justify-center">
                    <span>{{ \Carbon\Carbon::parse($date)->locale('ja')->isoFormat('M/D(ddd)') }}</span>
                </li>
                @foreach($times as $index => $time)
                    @php
                    $meetingFound = false;
                    $isFullHour = $index % 2 !== 0;
                    @endphp
                    @foreach($meetings as $meeting)
                        @php
                            $heightClass = App\Helpers\MeetingHelper::calculateHeightClass($meeting['start'], $meeting['end']);
                        @endphp
                        @if($meeting['start'] == $time)
                            <li class="hour relative h-12">
                                <div class="absolute bg-teal-400 text-white p-4 rounded w-full {{ $heightClass }}">
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
                        <li class="h-12 {{ $isFullHour ? 'border-b' : '' }}"></li>
                    @endif
                @endforeach
            </ul>
            @endforeach
        </div>
      </div>
      
</body>
</html>
