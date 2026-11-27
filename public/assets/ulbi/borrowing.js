(() => {
    const form = document.getElementById('borrowing-form');
    if (!form) return;

    const availability = JSON.parse(document.getElementById('borrowing-data').textContent);
    const room = form.elements.ruangan;
    const participants = form.elements.jumlah_peserta;
    const summary = document.getElementById('booking-review');
    const errorSummary = document.getElementById('booking-errors');
    const equipment = Array.from(form.querySelectorAll('[data-equipment]'));
    let firstInvalid = null;

    function showError(field, message) {
        document.getElementById('error-' + field.id).textContent = message;
        field.setAttribute('aria-invalid', 'true');
        firstInvalid ??= field;
    }

    function resetErrors() {
        for (const field of form.querySelectorAll('[aria-invalid]')) field.removeAttribute('aria-invalid');
        for (const error of form.querySelectorAll('.auth-error')) error.textContent = '';
        errorSummary.hidden = true;
        firstInvalid = null;
    }

    function updateRoom() {
        const selected = room.selectedOptions[0];
        const hasRoom = room.value !== '';
        participants.required = hasRoom;
        participants.disabled = !hasRoom;
        document.getElementById('participant-field').hidden = !hasRoom;
        document.getElementById('room-info').textContent = hasRoom
            ? 'Fasilitas bawaan meliputi ' + selected.dataset.facilities
            : 'Pilih tanpa ruangan jika hanya memerlukan sarana tambahan.';
        const details = document.getElementById('room-details');
        details.hidden = !hasRoom;
        if (hasRoom) details.href = selected.dataset.details;
        else details.removeAttribute('href');
    }

    room.addEventListener('change', updateRoom);
    form.addEventListener('input', resetErrors);
    form.addEventListener('change', resetErrors);

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        resetErrors();
        const fields = form.querySelectorAll('input:not([type="hidden"]), textarea, select');
        for (const field of fields) {
            if (field.disabled) continue;
            if (field.validity.badInput || (field.required && !field.value.trim())) {
                showError(field, 'Lengkapi isian ini dengan nilai yang valid.');
            } else if (field.type === 'email' && field.validity.typeMismatch) {
                showError(field, 'Masukkan alamat email yang valid.');
            } else if (field.type === 'number' && (field.validity.stepMismatch || field.validity.rangeUnderflow)) {
                showError(field, 'Masukkan jumlah dalam bilangan bulat sesuai batas minimum.');
            } else if (field.hasAttribute('data-equipment') && field.validity.rangeOverflow) {
                showError(field, 'Stok tidak cukup. Tersedia ' + field.max + ' ' + field.dataset.unit + '.');
            }
        }

        const start = form.elements.jam_mulai;
        const end = form.elements.jam_selesai;
        if (start.value && start.value < availability.opensAt) showError(start, 'Jam mulai paling awal 08.00 WIB.');
        if (end.value && end.value > availability.closesAt) showError(end, 'Jam selesai paling akhir 17.00 WIB.');
        if (start.value && end.value && end.value <= start.value) showError(end, 'Jam selesai harus setelah jam mulai.');

        const selectedEquipment = equipment.filter(field => !field.disabled && Number(field.value) > 0);
        if (!room.value && selectedEquipment.length === 0) showError(room, 'Pilih ruangan atau tambahkan minimal satu sarana.');

        if (room.value && participants.value && Number(participants.value) > Number(room.selectedOptions[0].dataset.capacity)) {
            showError(participants, 'Kapasitas ruangan tidak cukup untuk jumlah peserta.');
        }

        const date = form.elements.tanggal;
        if (room.value && date.value && start.value && end.value && !firstInvalid) {
            const day = new Date(date.value + 'T00:00:00Z').getUTCDay() || 7;
            const selectedRoom = availability.weeklyRooms[day].find(entry => entry.slug === room.value);
            const fits = selectedRoom.slots.some(slot => start.value >= slot.start && end.value <= slot.end);
            if (!fits) showError(room, 'Jadwal bentrok. Pilih waktu atau ruangan lain.');
        }

        const file = form.elements.attachment.files[0];
        if (file && (!/\.pdf$/i.test(file.name) || (file.type && file.type !== 'application/pdf'))) {
            showError(form.elements.attachment, 'Pilih dokumen berformat PDF.');
        } else if (file && file.size > 5 * 1024 * 1024) {
            showError(form.elements.attachment, 'Ukuran dokumen maksimal 5 MB.');
        }

        if (firstInvalid) {
            errorSummary.hidden = false;
            firstInvalid.focus();
            return;
        }

        const details = document.getElementById('review-values');
        details.replaceChildren();
        const equipmentText = selectedEquipment.map(field => field.dataset.label + ' - ' + field.value + ' ' + field.dataset.unit).join('\n');
        const rows = [
            ['Penanggung jawab', form.elements.borrower_name.value],
            ['Program studi / unit / organisasi', form.elements.unit.value],
            ['Kontak', form.elements.email.value + ' / ' + form.elements.phone.value],
            ['Kegiatan', form.elements.event_name.value],
            ['Tujuan', form.elements.purpose.value],
            ['Tanggal', new Intl.DateTimeFormat('id-ID', { dateStyle: 'full', timeZone: 'UTC' }).format(new Date(date.value + 'T00:00:00Z'))],
            ['Waktu', start.value.replace(':', '.') + '-' + end.value.replace(':', '.') + ' WIB'],
            ['Ruangan', room.selectedOptions[0].textContent],
            ['Sarana tambahan', equipmentText || 'Tanpa sarana tambahan'],
            ['Lampiran', file ? file.name : 'Tanpa lampiran'],
            ['Catatan', form.elements.notes.value.trim() || '-'],
        ];
        if (room.value) rows.splice(8, 0, ['Peserta', participants.value + ' orang']);
        for (const [label, value] of rows) {
            const term = document.createElement('dt');
            const description = document.createElement('dd');
            term.textContent = label;
            description.textContent = value;
            details.append(term, description);
        }
        form.hidden = true;
        summary.hidden = false;
        summary.focus();
        summary.scrollIntoView({ block: 'start' });
    });

    document.getElementById('edit-booking').addEventListener('click', () => {
        summary.hidden = true;
        document.getElementById('review-values').replaceChildren();
        form.hidden = false;
        form.elements.borrower_name.focus();
    });

    updateRoom();
    form.querySelector('[type="submit"]').disabled = false;
})();
