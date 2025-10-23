<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Admin Simpelsi</title>
    <!-- Supabase JS SDK (tanpa spasi berlebih!) -->
    <script type="module">
        import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js/+esm';
        // Ganti dengan project URL & anon key Anda yang valid
        window.supabase = createClient(
            'https://dpmsyciwqttdgbbqkmxt.supabase.co',
            'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRwbXN5Y2l3cXR0ZGdiYnFrbXh0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjExNjgxNTgsImV4cCI6MjA3Njc0NDE1OH0.8fiHzo0ePc8oS27W_BJUKYgoOwkTRlJN08QVHEvUskk'
        );
    </script>
    <style>
        /* --- SAMA PERSIS DENGAN CSS ANDA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #ffffff; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; position: relative; transition: background 0.5s ease; }
        .header { position: fixed; top: 0; left: 0; width: 100%; background: #1a8c1a; padding: 12px 30px; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); z-index: 10; }
        .header-logo { width: 40px; height: 40px; margin-right: 10px; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: transform 0.3s ease; }
        .header-logo:hover { transform: rotate(10deg) scale(1.05); }
        .header-title { color: white; font-size: 1.3em; font-weight: bold; }
        .login-card { background: #e6ffe6; padding: 35px 40px; border-radius: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; position: relative; margin-top: 80px; transition: all 0.4s ease; }
        .login-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .login-title { font-size: 26px; color: #1a8c1a; font-weight: bold; margin-bottom: 10px; line-height: 1.2; transition: color 0.3s ease; }
        .login-title:hover { color: #156b15; }
        .login-title span { display: block; font-size: 24px; font-weight: normal; color: #1a8c1a; }
        .form-group { text-align: left; margin-bottom: 20px; transition: transform 0.3s ease; }
        .form-group:hover { transform: translateX(3px); }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #333; font-size: 14px; }
        input[type="email"], input[type="password"] { width: 100%; padding: 12px 15px; border: none; border-radius: 10px; font-size: 16px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s ease; }
        input:focus { outline: none; box-shadow: 0 2px 12px rgba(26, 140, 26, 0.3); transform: scale(1.02); background: #f8fff8; }
        .btn-login { background: #1a8c1a; color: white; border: none; width: 100%; padding: 12px; border-radius: 10px; font-size: 18px; font-weight: 700; cursor: pointer; margin-bottom: 15px; transition: all 0.3s ease; position: relative; overflow: hidden; }
        .btn-login:before { content: ""; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.6s ease; }
        .btn-login:hover:before { left: 100%; }
        .btn-login:hover { background: #156b15; transform: scale(1.02); box-shadow: 0 4px 12px rgba(26, 140, 26, 0.3); }
        .btn-login:active { transform: scale(0.98); }
        .btn-reset { background: white; color: #555; border: 2px solid #ddd; width: 100%; padding: 10px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .btn-reset:hover { background: #f5f5f5; border-color: #1a8c1a; color: #1a8c1a; transform: scale(1.02); }
        .btn-reset:active { transform: scale(0.98); }
        .alert { padding: 10px; border-radius: 8px; margin-top: 20px; font-weight: 600; animation: fadeInUp 0.6s ease; position: relative; overflow: hidden; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        @media (max-width: 480px) { 
            .login-card { padding: 30px 25px; margin-top: 100px; } 
            .login-title { font-size: 22px; } 
            .login-title span { font-size: 20px; } 
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="/assets/logo.jpg" alt="Logo Simpelsi" class="header-logo">
        <div class="header-title">SIMPELSI</div>
    </div>

    <div class="login-card">
        <div class="login-title">LOGIN ADMIN<br><span>Simpelsi</span></div>
        <div id="alert-container"></div>

        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="admin@gmail.com" required autocomplete="off" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="admin123" required />
            </div>
            <button type="submit" class="btn-login">Login</button>
            <button type="button" class="btn-reset" onclick="resetForm()">Reset Form</button>
        </form>
    </div>

    <script>
        function showAlert(message, isError = true) {
            const container = document.getElementById('alert-container');
            container.innerHTML = `<div class="alert ${isError ? 'error' : 'success'}">${message}</div>`;
            if (isError) {
                document.body.style.background = '#ffebeb';
                setTimeout(() => { document.body.style.background = '#ffffff'; }, 800);
            }
        }

        function resetForm() {
            document.getElementById('loginForm').reset();
            document.getElementById('email').focus();
            document.getElementById('alert-container').innerHTML = '';
        }

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const btn = document.querySelector('.btn-login');

            btn.textContent = 'Logging in...';
            btn.style.opacity = '0.8';
            btn.style.cursor = 'wait';

            try {
                // Login via Supabase Auth (JavaScript)
                const { data, error } = await supabase.auth.signInWithPassword({ email, password });
                if (error) throw error;

                // Cek role di tabel profiles
                const { data: profile, error: profileError } = await supabase
                    .from('profiles')
                    .select('role')
                    .eq('id', data.user.id)
                    .single();

                if (profileError || !profile || profile.role !== 'admin') {
                    await supabase.auth.signOut();
                    throw new Error('Akun ini bukan admin. Akses ditolak.');
                }

                // Redirect ke dashboard (bisa .php atau .html)
                const card = document.querySelector(".login-card");
                card.style.transition = "transform 0.6s ease, opacity 0.6s ease";
                card.style.transform = "scale(0.95)";
                card.style.opacity = "0.8";
                setTimeout(() => {
                    window.location.href = "dashboard.php"; // 👈 tetap pakai .php jika dashboard Anda PHP
                }, 600);

            } catch (err) {
                console.error(err);
                showAlert('❌ ' + (err.message || 'Login gagal.'));
                btn.textContent = 'Login';
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            }
        });

        // Efek hover input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'translateX(5px)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'translateX(0)';
            });
        });
    </script>
</body>
</html>