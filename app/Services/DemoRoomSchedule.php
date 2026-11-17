<?php

namespace App\Services;

use Carbon\CarbonImmutable;

final class DemoRoomSchedule
{
    public const OPENS_AT = '08:00';

    public const CLOSES_AT = '17:00';

    public const FACILITIES = [
        'ac' => 'AC',
        'proyektor' => 'Proyektor',
        'papan-tulis' => 'Papan tulis',
        'sound-system' => 'Sound system',
    ];

    private const ROOMS = [
        ['name' => 'Ruang A', 'capacity' => 40, 'facilities' => ['ac', 'proyektor']],
        ['name' => 'Ruang B', 'capacity' => 50, 'facilities' => ['ac', 'proyektor', 'papan-tulis']],
        ['name' => 'Ruang C', 'capacity' => 24, 'facilities' => ['ac', 'papan-tulis']],
        ['name' => 'Ruang D', 'capacity' => 80, 'facilities' => ['ac', 'proyektor', 'sound-system']],
        ['name' => 'Ruang E', 'capacity' => 60, 'facilities' => ['ac', 'papan-tulis']],
    ];

    private const WEEKLY_BOOKINGS = [
        1 => [
            'Ruang A' => [['09:00', '11:00']],
            'Ruang B' => [['08:00', '17:00']],
            'Ruang C' => [['13:00', '15:00']],
        ],
        2 => [
            'Ruang A' => [['09:00', '11:00']],
            'Ruang B' => [['08:00', '12:00']],
            'Ruang C' => [['08:00', '17:00']],
            'Ruang D' => [['12:00', '14:00'], ['15:00', '16:00']],
        ],
        3 => [
            'Ruang A' => [['08:00', '10:00']],
            'Ruang B' => [['10:00', '12:00']],
            'Ruang E' => [['08:00', '17:00']],
        ],
        4 => [
            'Ruang D' => [['08:00', '17:00']],
            'Ruang E' => [['09:00', '12:00']],
        ],
        5 => [
            'Ruang B' => [['08:00', '17:00']],
            'Ruang D' => [['10:00', '12:00']],
            'Ruang E' => [['13:00', '16:00']],
        ],
    ];

    public function roomsOn(CarbonImmutable $date): array
    {
        $bookings = self::WEEKLY_BOOKINGS[$date->dayOfWeekIso] ?? [];

        return array_map(
            fn (array $room): array => $room + ['slots' => $this->availableSlots($bookings[$room['name']] ?? [])],
            self::ROOMS,
        );
    }

    public function recommendations(array $rooms, string $start, string $end, int $participants, array $facilities): array
    {
        $matches = [];

        foreach ($rooms as $room) {
            if ($room['capacity'] < $participants || array_diff($facilities, $room['facilities']) !== []) {
                continue;
            }

            foreach ($room['slots'] as $slot) {
                if ($start >= $slot['start'] && $end <= $slot['end']) {
                    $matches[] = $room + ['spareSeats' => $room['capacity'] - $participants];
                    break;
                }
            }
        }

        usort($matches, fn (array $a, array $b): int => [$a['spareSeats'], $a['name']] <=> [$b['spareSeats'], $b['name']]);

        return $matches;
    }

    private function availableSlots(array $bookings): array
    {
        sort($bookings);
        $slots = [];
        $cursor = self::OPENS_AT;

        foreach ($bookings as [$start, $end]) {
            if ($cursor < $start) {
                $slots[] = ['start' => $cursor, 'end' => $start];
            }

            $cursor = max($cursor, $end);
        }

        if ($cursor < self::CLOSES_AT) {
            $slots[] = ['start' => $cursor, 'end' => self::CLOSES_AT];
        }

        return $slots;
    }
}
