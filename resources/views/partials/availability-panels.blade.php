<div class="row g-4">
    <div class="col-lg-7">
        <section class="availability-panel" aria-labelledby="judul-jadwal">
            <h{{ $panelHeadingLevel }} class="panel-heading" id="judul-jadwal">Jadwal ruangan</h{{ $panelHeadingLevel }}>
            @foreach ($rooms as $room)
                <article class="asset-entry">
                    <div class="asset-heading">
                        <div>
                            <h{{ $panelHeadingLevel + 1 }} class="asset-name">{{ $room['name'] }}</h{{ $panelHeadingLevel + 1 }}>
                            <p class="asset-detail">Kapasitas {{ $room['capacity'] }} orang</p>
                        </div>
                        <span class="asset-status status-{{ $room['statusStyle'] }}">
                            {{ $room['status'] }}
                        </span>
                    </div>

                    <dl class="asset-values">
                        @foreach ($room['schedule'] as $label => $slot)
                            <div>
                                <dt>{{ $label }}</dt>
                                <dd>{{ $slot }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </article>
            @endforeach
        </section>
    </div>

    <div class="col-lg-5">
        <section class="availability-panel" aria-labelledby="judul-stok">
            <h{{ $panelHeadingLevel }} class="panel-heading" id="judul-stok">Stok sarana</h{{ $panelHeadingLevel }}>
            <article class="asset-entry">
                <div class="asset-heading">
                    <h{{ $panelHeadingLevel + 1 }} class="asset-name">{{ $equipment['name'] }}</h{{ $panelHeadingLevel + 1 }}>
                    <span class="asset-status status-low">Stok tidak cukup</span>
                </div>

                <dl class="asset-values">
                    <div>
                        <dt>Stok tersedia</dt>
                        <dd>{{ $equipment['available'] }} unit</dd>
                    </div>
                    <div>
                        <dt>Jumlah diminta</dt>
                        <dd>{{ $equipment['requested'] }} unit</dd>
                    </div>
                </dl>
            </article>
        </section>
    </div>
</div>
