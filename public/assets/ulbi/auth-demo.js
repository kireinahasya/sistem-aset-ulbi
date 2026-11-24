(() => {
    const form = document.querySelector('[data-auth-form]');
    if (!form) return;

    const type = form.dataset.authForm;
    const submit = form.querySelector('[type="submit"]');
    const result = document.querySelector('[data-form-result]');
    const formError = form.querySelector('[data-form-error]');
    const demoAccounts = {
        peminjam: { email: 'peminjam@example.com', password: 'DemoUlbi2026!', label: 'Peminjam' },
        admin: { email: 'admin@example.com', password: 'DemoUlbi2026!', label: 'Admin Logistik' },
    };
    let selectedRole = 'peminjam';

    function clearFeedback() {
        for (const error of form.querySelectorAll('[data-error-for]')) {
            error.textContent = '';
        }
        for (const field of form.querySelectorAll('[aria-invalid]')) {
            field.removeAttribute('aria-invalid');
        }
        if (formError) formError.hidden = true;
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
            selectedRole = button.dataset.role;
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
            document.querySelector('[data-fill-demo]').textContent = 'Isi akun demo ' + demoAccounts[selectedRole].label;
        });
    }

    document.querySelector('[data-fill-demo]')?.addEventListener('click', () => {
        clearFeedback();
        form.elements.email.value = demoAccounts[selectedRole].email;
        form.elements.password.value = demoAccounts[selectedRole].password;
        submit.focus();
    });

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

        if (type === 'login') {
            const account = demoAccounts[selectedRole];
            if (form.elements.email.value.trim().toLowerCase() !== account.email || form.elements.password.value !== account.password) {
                formError.textContent = 'Gunakan akun demo sesuai peran. Klik tombol Isi akun demo untuk mengisinya.';
                formError.hidden = false;
                form.elements.email.focus();
                return;
            }
            result.querySelector('[data-result-title]').textContent = 'Demo masuk sebagai ' + account.label;
            result.querySelector('[data-result-message]').textContent = selectedRole === 'admin'
                ? 'Validasi akun demo berhasil. Dasbor Admin Logistik sedang disiapkan.'
                : 'Validasi akun demo berhasil. Kamu bisa melanjutkan menjelajahi ruangan dari beranda.';
        } else if (type === 'register') {
            result.querySelector('[data-result-title]').textContent = 'Isian registrasi sudah sesuai';
            result.querySelector('[data-result-message]').textContent = 'Simulasi registrasi berhasil. Pembuatan akun akan tersedia pada tahap backend. Gunakan akun demo untuk mencoba halaman masuk.';
        } else {
            result.querySelector('[data-result-title]').textContent = 'Isian email sudah sesuai';
            result.querySelector('[data-result-message]').textContent = 'Simulasi permintaan pemulihan berhasil. Pengiriman email akan tersedia pada tahap backend.';
        }

        for (const input of form.querySelectorAll('input[type="password"], input[autocomplete$="password"]')) {
            input.value = '';
        }
        result.hidden = false;
        result.focus();
    });

    submit.disabled = false;
})();
