(() => {
    const form = document.querySelector('[data-auth-form]');
    if (!form) return;

    const type = form.dataset.authForm;
    const submit = form.querySelector('[type="submit"]');
    const result = document.querySelector('[data-form-result]');

    function clearFeedback() {
        for (const error of form.querySelectorAll('[data-error-for]')) {
            error.textContent = '';
        }
        for (const field of form.querySelectorAll('[aria-invalid]')) {
            field.setAttribute('aria-invalid', 'false');
        }
        for (const field of form.querySelectorAll('.is-invalid')) {
            field.classList.remove('is-invalid');
        }
        if (result) result.hidden = true;
    }

    for (const button of document.querySelectorAll('[data-toggle-password]')) {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.togglePassword);
            if (!input) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            button.textContent = show ? 'Sembunyikan' : 'Tampilkan';
            button.setAttribute('aria-pressed', String(show));
        });
    }

    form.addEventListener('input', clearFeedback);
    form.addEventListener('change', clearFeedback);
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        clearFeedback();
        const fields = Array.from(form.querySelectorAll('input[required], select[required]'));
        let firstInvalid = null;

        for (const field of fields) {
            let message = '';
            const value = (field.value || '').trim();

            if (!value) {
                message = field.tagName === 'SELECT' ? 'Pilih salah satu pilihan.' : 'Lengkapi isian ini.';
            } else if (field.type === 'email' && field.validity.typeMismatch) {
                message = 'Masukkan alamat email yang valid.';
            } else if (field.name === 'nim' && !/^\d{9}$/.test(value)) {
                message = 'NIM harus 9 angka.';
            } else if (
                (type === 'register' || type === 'reset') &&
                field.name === 'password' &&
                field.value.length < 8
            ) {
                message = 'Gunakan minimal 8 karakter.';
            } else if (field.name === 'password_confirmation' && field.value !== form.elements.password.value) {
                message = 'Konfirmasi kata sandi belum sama.';
            }

            if (message) {
                const errorTarget = form.querySelector('[data-error-for="' + field.name + '"]');
                if (errorTarget) errorTarget.textContent = message;
                field.setAttribute('aria-invalid', 'true');
                field.classList.add('is-invalid');
                firstInvalid ??= field;
            }
        }

        if (firstInvalid) {
            firstInvalid.focus();
            return;
        }

        if (result) {
            const messages = {
                login: 'Layanan masuk belum tersedia. Silakan kembali ke halaman ini nanti.',
                register: 'Pendaftaran akun belum tersedia. Silakan kembali ke halaman ini nanti.',
                forgot: 'Pemulihan kata sandi belum tersedia. Silakan kembali ke halaman ini nanti.',
                reset: 'Pengaturan ulang kata sandi belum tersedia. Silakan kembali ke halaman ini nanti.',
            };
            const title = result.querySelector('[data-result-title]');
            const messageEl = result.querySelector('[data-result-message]');
            if (title) title.textContent = 'Layanan belum tersedia';
            if (messageEl) messageEl.textContent = messages[type] || 'Layanan belum tersedia.';

            for (const input of form.querySelectorAll('input[type="password"], input[autocomplete$="password"]')) {
                input.value = '';
            }
            result.hidden = false;
            result.focus();
        }
    });

    submit.disabled = false;
})();
