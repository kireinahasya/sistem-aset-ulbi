<section class="availability-panel finder-panel" aria-labelledby="cari-ruangan">
    <h3 id="cari-ruangan" tabindex="-1">Cari ruangan</h3>

    @if ($formErrors->isNotEmpty())
        <div class="search-errors" role="alert">
            <ul>
                @foreach (array_unique($formErrors->all()) as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('home') }}#cari-ruangan" method="get" class="room-search">
        <input type="hidden" name="cari" value="1">

        <div class="search-fields">
            <div>
                <label class="form-label" for="tanggal">Tanggal penggunaan</label>
                <input class="form-control" id="tanggal" name="tanggal" type="date"
                    value="{{ $selectedDate->toDateString() }}" required @if ($formErrors->has('tanggal')) aria-invalid="true" @endif>
            </div>
            <div>
                <label class="form-label" for="jumlah-peserta">Jumlah peserta</label>
                <input class="form-control" id="jumlah-peserta" name="jumlah_peserta" type="number"
                    min="1" step="1" value="{{ $form['jumlah_peserta'] }}" required
                    @if ($formErrors->has('jumlah_peserta')) aria-invalid="true" @endif>
            </div>
            <div>
                <label class="form-label" for="jam-mulai">Jam mulai (WIB)</label>
                <input class="form-control" id="jam-mulai" name="jam_mulai" type="time"
                    min="08:00" max="17:00" value="{{ $form['jam_mulai'] }}" required
                    @if ($formErrors->has('jam_mulai')) aria-invalid="true" @endif>
            </div>
            <div>
                <label class="form-label" for="jam-selesai">Jam selesai (WIB)</label>
                <input class="form-control" id="jam-selesai" name="jam_selesai" type="time"
                    min="08:00" max="17:00" value="{{ $form['jam_selesai'] }}" required
                    @if ($formErrors->has('jam_selesai')) aria-invalid="true" @endif>
            </div>
        </div>

        <fieldset>
            <legend>Fasilitas yang diperlukan</legend>
            <div class="facility-options">
                @foreach ($facilityLabels as $code => $label)
                    <label>
                        <input class="form-check-input" type="checkbox" name="fasilitas[]" value="{{ $code }}"
                            @checked(in_array($code, $selectedFacilities, true))>
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </fieldset>

        <button class="btn btn-primary" type="submit">Cari rekomendasi</button>
    </form>

    @if ($recommendations !== null)
        <section class="recommendation-results" aria-labelledby="judul-rekomendasi">
            <h4 id="judul-rekomendasi">Hasil pencarian</h4>
            @if ($recommendations === [])
                <p class="asset-detail">Tidak ada ruangan yang cocok. Coba ganti jam, jumlah peserta, atau fasilitas.</p>
            @else
                <p class="asset-detail">Diurutkan dari sisa kursi paling sedikit.</p>
                <ol>
                    @foreach ($recommendations as $room)
                        <li>
                            <strong><a class="room-detail-link" href="{{ route('rooms.show', $room['slug']) }}">{{ $room['name'] }}</a></strong>
                            <span>Kapasitas {{ $room['capacity'] }} orang · Sisa {{ $room['spareSeats'] }} kursi</span>
                            <span class="asset-detail">{{ implode(' · ', array_map(fn ($code) => $facilityLabels[$code], $room['facilities'])) }}</span>
                            <a class="back-link" href="{{ route('borrowings.create', [
                                'ruangan' => $room['slug'],
                                'tanggal' => $selectedDate->toDateString(),
                                'jam_mulai' => $form['jam_mulai'],
                                'jam_selesai' => $form['jam_selesai'],
                                'jumlah_peserta' => $form['jumlah_peserta'],
                            ]) }}">Pilih ruangan ini</a>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>
    @endif
</section>
