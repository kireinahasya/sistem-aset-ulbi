<?php

namespace App\Http\Controllers;

use App\Services\DemoRoomSchedule;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class HomeController extends Controller
{
    public function __invoke(Request $request, DemoRoomSchedule $schedule): View
    {
        $isSearch = $request->boolean('cari');
        $input = $request->only(['tanggal', 'jam_mulai', 'jam_selesai', 'jumlah_peserta', 'fasilitas']);
        $rules = ['tanggal' => [$isSearch ? 'required' : 'nullable', 'date_format:Y-m-d']];
        $messages = [
            'tanggal.required' => 'Pilih tanggal penggunaan.',
            'tanggal.date_format' => 'Pilih tanggal yang valid.',
        ];

        if ($isSearch) {
            $rules += [
                'jam_mulai' => ['bail', 'required', 'date_format:H:i', 'after_or_equal:'.DemoRoomSchedule::OPENS_AT],
                'jam_selesai' => ['bail', 'required', 'date_format:H:i', 'before_or_equal:'.DemoRoomSchedule::CLOSES_AT],
                'jumlah_peserta' => ['required', 'integer', 'min:1'],
                'fasilitas' => ['sometimes', 'array'],
                'fasilitas.*' => ['string', Rule::in(array_keys(DemoRoomSchedule::FACILITIES))],
            ];
            $messages += [
                'jam_mulai.required' => 'Isi jam mulai.',
                'jam_mulai.date_format' => 'Masukkan jam mulai yang valid.',
                'jam_mulai.after_or_equal' => 'Jam mulai paling awal 08.00 WIB.',
                'jam_selesai.required' => 'Isi jam selesai.',
                'jam_selesai.date_format' => 'Masukkan jam selesai yang valid.',
                'jam_selesai.before_or_equal' => 'Jam selesai paling akhir 17.00 WIB.',
                'jumlah_peserta.required' => 'Isi jumlah peserta.',
                'jumlah_peserta.integer' => 'Masukkan jumlah peserta dalam bilangan bulat.',
                'jumlah_peserta.min' => 'Jumlah peserta minimal 1 orang.',
                'fasilitas.array' => 'Pilih fasilitas dari daftar.',
                'fasilitas.*.string' => 'Pilih fasilitas dari daftar.',
                'fasilitas.*.in' => 'Pilih fasilitas dari daftar.',
            ];
        }

        $validator = Validator::make($input, $rules, $messages);

        if ($isSearch) {
            $validator->after(function ($validator) use ($input): void {
                if (! $validator->errors()->hasAny(['jam_mulai', 'jam_selesai'])
                    && $input['jam_selesai'] <= $input['jam_mulai']) {
                    $validator->errors()->add('jam_selesai', 'Jam selesai harus setelah jam mulai.');
                }
            });
        }

        $errors = $validator->errors();
        $today = CarbonImmutable::today('Asia/Jakarta');
        $selectedDate = isset($input['tanggal']) && ! $errors->has('tanggal')
            ? CarbonImmutable::createFromFormat('!Y-m-d', $input['tanggal'], 'Asia/Jakarta')
            : $today;
        $selectedDate = $selectedDate->locale('id');
        $rooms = $schedule->roomsOn($selectedDate);
        $form = array_filter($input, 'is_string') + [
            'jam_mulai' => '09:00',
            'jam_selesai' => '10:00',
            'jumlah_peserta' => '',
        ];
        $facilities = is_array($input['fasilitas'] ?? null) ? array_filter($input['fasilitas'], 'is_string') : [];
        $recommendations = $isSearch && $errors->isEmpty()
            ? $schedule->recommendations($rooms, $input['jam_mulai'], $input['jam_selesai'], (int) $input['jumlah_peserta'], $facilities)
            : null;

        return view('home', [
            'calendar' => $this->calendar($selectedDate, $today, $schedule),
            'selectedDate' => $selectedDate,
            'availableRooms' => array_filter($rooms, fn (array $room): bool => $room['slots'] !== []),
            'facilityLabels' => DemoRoomSchedule::FACILITIES,
            'form' => $form,
            'selectedFacilities' => $facilities,
            'formErrors' => $errors,
            'recommendations' => $recommendations,
        ]);
    }

    private function calendar(CarbonImmutable $selectedDate, CarbonImmutable $today, DemoRoomSchedule $schedule): array
    {
        $firstDay = $selectedDate->startOfMonth();
        $days = array_fill(0, $firstDay->dayOfWeekIso - 1, null);

        for ($day = $firstDay; $day->isSameMonth($firstDay); $day = $day->addDay()) {
            $days[] = [
                'date' => $day->toDateString(),
                'label' => $day->translatedFormat('l, j F Y'),
                'number' => $day->day,
                'roomCount' => count(array_filter($schedule->roomsOn($day), fn (array $room): bool => $room['slots'] !== [])),
                'selected' => $day->isSameDay($selectedDate),
                'today' => $day->isSameDay($today),
            ];
        }

        $days = array_pad($days, (int) ceil(count($days) / 7) * 7, null);

        return [
            'month' => $firstDay->translatedFormat('F Y'),
            'previousMonth' => $firstDay->subMonth()->toDateString(),
            'nextMonth' => $firstDay->addMonth()->toDateString(),
            'weeks' => array_chunk($days, 7),
        ];
    }
}
