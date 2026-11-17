<?php

namespace App\Http\Controllers;

use App\Services\DemoRoomSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

final class RoomCatalogController extends Controller
{
    public function index(DemoRoomSchedule $schedule): View
    {
        return view('rooms.index', [
            'rooms' => $schedule->rooms(),
            'facilityLabels' => DemoRoomSchedule::FACILITIES,
        ]);
    }

    public function show(DemoRoomSchedule $schedule, string $room): View
    {
        $detail = Arr::first($schedule->rooms(), fn (array $entry): bool => $entry['slug'] === $room);
        abort_if($detail === null, 404);

        return view('rooms.show', [
            'room' => $detail,
            'facilityLabels' => DemoRoomSchedule::FACILITIES,
        ]);
    }
}
