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
            field.removeAttribute('aria-invalid');
        }
        result.hidden = true;
    }

    for (const button of document.querySelectorAll('[data-toggle-password]')) {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.togglePassword);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            button.textContent = show ? 'Sembunyikan' : 'Tampilkan';
            button.setAttribute('aria-pressed', String(show));
        });
    }

    for (const button of document.querySelectorAll('[data-role]')) {
        button.addEventListener('click', () => {
            for (const option of document.querySelectorAll('[data-role]')) {
                option.setAttribute('aria-pressed', String(option === button));
            }
            form.reset();
            for (const toggle of document.querySelectorAll('[data-toggle-password]')) {
                document.getElementById(toggle.dataset.togglePassword).type = 'password';
                toggle.textContent = 'Tampilkan';
                toggle.setAttribute('aria-pressed', 'false');
            }
            clearFeedback();
        });
    }

    form.elements.user_type?.addEventListener('change', () => {
        const label = document.querySelector('[data-identity-label]');
        label.textContent = form.elements.user_type.value === 'mahasiswa' ? 'NPM' : 'Nomor identitas kampus';
    });

    form.addEventListener('input', clearFeedback);
    form.addEventListener('change', clearFeedback);
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        clearFeedback();
        const fields = Array.from(form.querySelectorAll('input[required], select[required]'));
        let firstInvalid = null;

        for (const field of fields) {
            let message = '';
            if (!field.value.trim()) {
                message = field.tagName === 'SELECT' ? 'Pilih jenis pengguna.' : 'Lengkapi isian ini.';
            } else if (field.type === 'email' && field.validity.typeMismatch) {
                message = 'Masukkan alamat email yang valid.';
            } else if (type === 'register' && field.name === 'password' && field.value.length < 8) {
                message = 'Gunakan minimal 8 karakter.';
            } else if (field.name === 'password_confirmation' && field.value !== form.elements.password.value) {
                message = 'Konfirmasi kata sandi belum sama.';
            }

            if (message) {
                form.querySelector('[data-error-for="' + field.name + '"]').textContent = message;
                field.setAttribute('aria-invalid', 'true');
                firstInvalid ??= field;
            }
        }

        if (firstInvalid) {
            firstInvalid.focus();
            return;
        }

        const messages = {
            login: 'Layanan masuk belum tersedia. Silakan kembali ke halaman ini nanti.',
            register: 'Pendaftaran akun belum tersedia. Silakan kembali ke halaman ini nanti.',
            forgot: 'Pemulihan kata sandi belum tersedia. Silakan kembali ke halaman ini nanti.',
        };
        result.querySelector('[data-result-title]').textContent = 'Layanan belum tersedia';
        result.querySelector('[data-result-message]').textContent = messages[type];

        for (const input of form.querySelectorAll('input[type="password"], input[autocomplete$="password"]')) {
            input.value = '';
        }
        result.hidden = false;
        result.focus();
    });

    submit.disabled = false;
})();
