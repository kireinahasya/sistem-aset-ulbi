<?php

namespace App\Http\Controllers;

use App\Services\DemoEquipmentCatalog;
use App\Services\DemoRoomSchedule;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class BorrowingController extends Controller
{
    public function create(Request $request, DemoRoomSchedule $schedule, DemoEquipmentCatalog $catalog): View
    {
        $weeklyRooms = [];
        $monday = CarbonImmutable::parse('2026-11-23', 'Asia/Jakarta');

        for ($day = 1; $day <= 7; $day++) {
            $weeklyRooms[$day] = $schedule->roomsOn($monday->addDays($day - 1));
        }

        return view('borrowings.create', [
            'rooms' => $schedule->rooms(),
            'equipment' => $catalog->items(),
            'facilityLabels' => DemoRoomSchedule::FACILITIES,
            'initial' => array_filter($request->only(['ruangan', 'sarana', 'tanggal', 'jam_mulai', 'jam_selesai', 'jumlah_peserta']), 'is_string'),
            'availability' => [
                'weeklyRooms' => $weeklyRooms,
                'opensAt' => DemoRoomSchedule::OPENS_AT,
                'closesAt' => DemoRoomSchedule::CLOSES_AT,
            ],
        ]);
    }
}
