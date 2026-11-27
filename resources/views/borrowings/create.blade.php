@extends('layouts.app')

@section('title', 'Formulir peminjaman | Sistem Aset ULBI')

@section('content')
    <div class="container-xl availability-page">
        <header class="availability-heading availability-page-heading">
            <h1>Formulir peminjaman</h1>
        </header>
        <p class="catalog-intro">Lengkapi jadwal dan kebutuhan aset untuk meninjau pengajuan.</p>

        <div class="booking-layout">
            <div>
                <form id="borrowing-form" class="availability-panel booking-form" method="post"
                    action="{{ route('borrowings.create') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <p class="search-errors" id="booking-errors" role="alert" hidden>Periksa kembali isian yang ditandai.</p>
                    <fieldset class="booking-section">
                        <legend>Penanggung jawab</legend>
                        <div class="booking-fields">
                            <div>
                                <label class="form-label" for="borrower_name">Nama lengkap</label>
                                <input class="form-control" id="borrower_name" name="borrower_name" autocomplete="name" required aria-describedby="error-borrower_name">
                                <span class="auth-error" id="error-borrower_name"></span>
                            </div>
                            <div>
                                <label class="form-label" for="unit">Program studi / unit / organisasi</label>
                                <input class="form-control" id="unit" name="unit" required aria-describedby="error-unit">
                                <span class="auth-error" id="error-unit"></span>
                            </div>
                            <div>
                                <label class="form-label" for="email">Email aktif</label>
                                <input class="form-control" id="email" name="email" type="email" autocomplete="email" required aria-describedby="error-email">
                                <span class="auth-error" id="error-email"></span>
                            </div>
                            <div>
                                <label class="form-label" for="phone">Nomor telepon</label>
                                <input class="form-control" id="phone" name="phone" type="tel" autocomplete="tel" required aria-describedby="error-phone">
                                <span class="auth-error" id="error-phone"></span>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="booking-section">
                        <legend>Kegiatan dan waktu</legend>
                        <div class="mb-3">
                            <label class="form-label" for="event_name">Nama kegiatan</label>
                            <input class="form-control" id="event_name" name="event_name" required aria-describedby="error-event_name">
                            <span class="auth-error" id="error-event_name"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="purpose">Tujuan penggunaan</label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="3" required aria-describedby="error-purpose"></textarea>
                            <span class="auth-error" id="error-purpose"></span>
                        </div>
                        <div class="booking-fields">
                            <div>
                                <label class="form-label" for="tanggal">Tanggal penggunaan</label>
                                <input class="form-control" id="tanggal" name="tanggal" type="date" required
                                    value="{{ $initial['tanggal'] ?? '' }}" aria-describedby="error-tanggal">
                                <span class="auth-error" id="error-tanggal"></span>
                            </div>
                            <div id="participant-field">
                                <label class="form-label" for="jumlah_peserta">Jumlah peserta</label>
                                <input class="form-control" id="jumlah_peserta" name="jumlah_peserta" type="number"
                                    min="1" step="1" value="{{ $initial['jumlah_peserta'] ?? '' }}" aria-describedby="error-jumlah_peserta">
                                <span class="auth-error" id="error-jumlah_peserta"></span>
                            </div>
                            <div>
                                <label class="form-label" for="jam_mulai">Jam mulai (WIB)</label>
                                <input class="form-control" id="jam_mulai" name="jam_mulai" type="time" required min="08:00" max="17:00"
                                    value="{{ $initial['jam_mulai'] ?? '' }}" aria-describedby="error-jam_mulai">
                                <span class="auth-error" id="error-jam_mulai"></span>
                            </div>
                            <div>
                                <label class="form-label" for="jam_selesai">Jam selesai (WIB)</label>
                                <input class="form-control" id="jam_selesai" name="jam_selesai" type="time" required min="08:00" max="17:00"
                                    value="{{ $initial['jam_selesai'] ?? '' }}" aria-describedby="error-jam_selesai">
                                <span class="auth-error" id="error-jam_selesai"></span>
                            </div>
                        </div>
                        <p class="auth-caption">Cantumkan waktu persiapan dan pemberesan. Penggunaan tersedia pukul 08.00-17.00 WIB.</p>
                    </fieldset>

                    <fieldset class="booking-section">
                        <legend>Ruangan</legend>
                        <label class="form-label" for="ruangan">Pilihan ruangan</label>
                        <select class="form-select" id="ruangan" name="ruangan" aria-describedby="room-info error-ruangan">
                            <option value="">Tanpa ruangan</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room['slug'] }}" @selected(($initial['ruangan'] ?? '') === $room['slug'])
                                    data-capacity="{{ $room['capacity'] }}"
                                    data-facilities="{{ implode(' · ', array_map(fn ($code) => $facilityLabels[$code], $room['facilities'])) }}"
                                    data-details="{{ route('rooms.show', $room['slug']) }}">{{ $room['name'] }} - {{ $room['capacity'] }} orang</option>
                            @endforeach
                        </select>
                        <p class="asset-detail" id="room-info"></p>
                        <span class="auth-error" id="error-ruangan"></span>
                        <a class="back-link" id="room-details" hidden>Lihat fasilitas ruangan</a>
                    </fieldset>

                    <fieldset class="booking-section">
                        <legend>Sarana tambahan</legend>
                        <p class="asset-detail mb-2">Isi jumlah unit yang diperlukan. Pilih ruangan dan/atau minimal satu sarana.</p>
                        <div class="equipment-quantities">
                            @foreach ($equipment as $item)
                                <div class="equipment-quantity">
                                    <div>
                                        <label class="form-label" for="sarana-{{ $item['slug'] }}">{{ $item['name'] }}</label>
                                        <p class="asset-detail">{{ $item['available'] }} {{ $item['unit'] }} tersedia</p>
                                    </div>
                                    <div>
                                        <input class="form-control" id="sarana-{{ $item['slug'] }}" name="sarana[{{ $item['slug'] }}]"
                                            type="number" min="0" max="{{ $item['available'] }}" step="1"
                                            data-equipment data-label="{{ $item['name'] }}" data-unit="{{ $item['unit'] }}"
                                            aria-describedby="error-sarana-{{ $item['slug'] }}"
                                            value="{{ ($initial['sarana'] ?? '') === $item['slug'] && $item['available'] > 0 ? 1 : 0 }}"
                                            @disabled($item['available'] === 0)>
                                        <span class="auth-error" id="error-sarana-{{ $item['slug'] }}"></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    <fieldset class="booking-section">
                        <legend>Dokumen dan catatan</legend>
                        <label class="form-label" for="attachment">Surat permohonan / izin kegiatan (opsional)</label>
                        <input class="form-control" id="attachment" name="attachment" type="file" accept=".pdf,application/pdf"
                            aria-describedby="attachment-help error-attachment">
                        <p class="auth-caption" id="attachment-help">Format PDF, maksimal 5 MB.</p>
                        <span class="auth-error" id="error-attachment"></span>
                        <label class="form-label mt-3" for="notes">Catatan tambahan (opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </fieldset>

                    <button class="btn btn-primary booking-button" type="submit" disabled>Periksa pengajuan</button>
                    <noscript><p class="search-errors">Aktifkan JavaScript agar formulir dapat diperiksa.</p></noscript>
                </form>

                <section class="availability-panel booking-form" id="booking-review" aria-labelledby="review-title" tabindex="-1" hidden>
                    <h2 id="review-title">Ringkasan pengajuan</h2>
                    <p class="asset-detail">Periksa kembali jadwal, aset, dan jumlah yang Anda pilih.</p>
                    <dl class="review-values" id="review-values"></dl>
                    <p class="booking-review-notice">Masuk ke akun untuk melanjutkan pengiriman pengajuan kepada Admin Logistik.</p>
                    <div class="booking-actions">
                        <button class="btn btn-outline-primary booking-button" type="button" id="edit-booking">Ubah isian</button>
                        <a class="btn btn-primary booking-button" href="{{ route('login') }}">Masuk untuk mengirim</a>
                    </div>
                </section>
            </div>

            <aside class="booking-help" aria-label="Informasi peminjaman">
                <h2>Sebelum mengajukan</h2>
                <ul>
                    <li>Sesuaikan kapasitas ruang dengan jumlah peserta.</li>
                    <li>Fasilitas bawaan mengikuti ruangan yang dipilih.</li>
                    <li>Tambahkan sarana sesuai jumlah yang diperlukan.</li>
                    <li>Pengajuan memerlukan persetujuan Admin Logistik.</li>
                </ul>
                <a class="back-link" href="{{ route('equipment.index') }}">Lihat katalog sarana</a>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script id="borrowing-data" type="application/json">@json($availability)</script>
    <script src="{{ asset('assets/ulbi/borrowing.js') }}" defer></script>
@endpush
