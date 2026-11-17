<section class="availability-panel finder-panel" aria-labelledby="ketersediaan">
    <h3 id="ketersediaan" tabindex="-1">Kalender ketersediaan</h3>

    <div class="calendar-nav">
        <a class="calendar-arrow" href="{{ route('home', ['tanggal' => $calendar['previousMonth']]) }}#ketersediaan"
            aria-label="Bulan sebelumnya">&lsaquo;</a>
        <span>{{ $calendar['month'] }}</span>
        <a class="calendar-arrow" href="{{ route('home', ['tanggal' => $calendar['nextMonth']]) }}#ketersediaan"
            aria-label="Bulan berikutnya">&rsaquo;</a>
    </div>

    <table class="room-calendar" aria-labelledby="ketersediaan" aria-describedby="keterangan-kalender">
        <thead>
            <tr>
                @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $weekday)
                    <th scope="col">{{ $weekday }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($calendar['weeks'] as $week)
                <tr>
                    @foreach ($week as $day)
                        <td>
                            @if ($day)
                                <a class="calendar-day" href="{{ route('home', ['tanggal' => $day['date']]) }}#ketersediaan"
                                    aria-label="{{ $day['label'] }}{{ $day['today'] ? ', hari ini' : '' }}, {{ $day['roomCount'] }} ruang dengan slot kosong"
                                    @if ($day['selected']) aria-current="date" @endif>
                                    <span>{{ $day['number'] }}</span>
                                    <small>{{ $day['roomCount'] }}<span class="calendar-room-label"> ruang</span></small>
                                </a>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="calendar-caption" id="keterangan-kalender">Angka di bawah tanggal menunjukkan jumlah ruang dengan slot kosong.</p>

    <h4 class="day-heading">{{ $selectedDate->translatedFormat('l, j F Y') }}</h4>

    <ul class="day-rooms">
        @forelse ($availableRooms as $room)
            <li>
                <div>
                    <strong>{{ $room['name'] }}</strong>
                    <span class="asset-detail">{{ $room['capacity'] }} orang</span>
                </div>
                <ul class="room-slots" aria-label="Slot kosong {{ $room['name'] }}">
                    @foreach ($room['slots'] as $slot)
                        <li>{{ str_replace(':', '.', $slot['start']) }}–{{ str_replace(':', '.', $slot['end']) }} WIB</li>
                    @endforeach
                </ul>
            </li>
        @empty
            <li>Tidak ada slot kosong pada tanggal ini.</li>
        @endforelse
    </ul>
</section>
