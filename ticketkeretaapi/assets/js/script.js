// Validasi form registrasi dan login
document.addEventListener('DOMContentLoaded', function() {
    const formRegister = document.querySelector('.form-register');
    const formLogin = document.querySelector('.form-login');

    // Validasi form register
    if (formRegister) {
        formRegister.addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            if (password !== confirmPassword) {
                alert("Password dan Konfirmasi Password tidak cocok!");
                event.preventDefault();
            }
        });
    }

    // Validasi form login
    if (formLogin) {
        formLogin.addEventListener('submit', function(event) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            if (!username || !password) {
                alert("Username atau Password tidak boleh kosong!");
                event.preventDefault();
            }
        });
    }
});
