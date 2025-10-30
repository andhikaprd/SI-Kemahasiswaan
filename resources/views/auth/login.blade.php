<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Masuk ke Akun</title>
    <style>
        :root { --blue:#1f6feb; --text:#0f172a; --muted:#64748b; --bg:#dbe6ff; --card:#ffffff; --ring:#d1d5db; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background: var(--bg); color:var(--text); }
        .container { max-width: 760px; margin: 56px auto; padding: 0 16px; text-align:center; }
        .icon { width:78px; height:78px; margin: 0 auto 12px; display:grid; place-items:center; background:#2b5dd9; color:#fff; border-radius:999px; box-shadow: 0 10px 25px rgba(37, 99, 235, .25); }
        .title { font-size: 32px; font-weight: 800; margin: 4px 0 4px; letter-spacing:.2px; }
        .subtitle { color: var(--muted); margin: 0 0 22px; font-size: 16px; }
        .card { background: var(--card); border-radius: 16px; margin: 0 auto; padding: 26px; max-width: 620px; text-align:left; box-shadow: 0 12px 40px rgba(0,0,0,.08); }
        .label { font-weight: 700; font-size: 20px; margin: 12px 0 8px; }
        .input { width: 100%; padding: 12px 14px; border:1px solid var(--ring); border-radius:10px; outline: none; font-size: 15px; background:#fff; }
        .input:focus { border-color: var(--blue); box-shadow: 0 0 0 4px rgba(31, 111, 235, .12); }
        .field { position: relative; }
        .toggle-pass { position:absolute; right:10px; top:50%; transform: translateY(-50%); border:none; background:transparent; color:#374151; cursor:pointer; padding:6px; display:grid; place-items:center; }
        .toggle-pass svg { width:20px; height:20px; }
        .toggle-pass:hover { color:#111827; }
        .row { display:flex; align-items:center; justify-content:space-between; gap: 10px; margin: 8px 0 16px; }
        .muted { color: var(--muted); font-size: 14px; }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:10px; width:100%; border:none; background: var(--blue); color:#fff; padding:12px 16px; border-radius:10px; font-weight:700; cursor:pointer; font-size:16px; }
        .btn:hover { filter: brightness(0.96); }
        .btn-outline { background:#fff; color:#111827; border:1px solid var(--ring); }
        .btn-outline:hover { background:#f8fafc; }
        .hr { display:flex; align-items:center; gap:12px; margin: 18px 0; }
        .hr::before, .hr::after { content:""; height:1px; flex:1; background:#e5e7eb; }
        .error { color:#dc2626; font-size: 13px; margin-top: 6px; }
        .foot { text-align:center; margin-top: 10px; color: var(--muted); font-size: 14px; }
        a { color:#2563eb; text-decoration:none; }
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>
<div class="container">
    <div class="icon" aria-hidden="true">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 10V8a6 6 0 1 1 12 0v2" stroke="#fff" stroke-width="2" stroke-linecap="round"/><rect x="4" y="10" width="16" height="10" rx="2" stroke="#fff" stroke-width="2"/></svg>
    </div>
    <div class="title">Masuk ke Akun</div>
    <div class="subtitle">Sistem Informasi Kemahasiswaan HIMA TI</div>

    <div class="card">
        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <label class="label" for="email">Email</label>
            <input class="input" id="email" name="email" type="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus />
            @error('email')<div class="error">{{ $message }}</div>@enderror

            <label class="label" for="password">Password</label>
            <div class="field">
                <input class="input" id="password" name="password" type="password" placeholder="Masukkan password Anda" required />
                <button id="togglePass" class="toggle-pass" type="button" aria-label="Tampilkan password" title="Tampilkan/Sembunyikan">
                    <!-- eye icon default -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                </button>
            </div>

            <div class="row">
                <label class="muted" style="display:flex;align-items:center;gap:8px">
                    <input type="checkbox" name="remember" value="1" /> Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a class="muted" href="{{ route('password.request') }}">Lupa Password?</a>
                @else
                    <span></span>
                @endif
            </div>

            <button type="submit" class="btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12h14M13 5l7 7-7 7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Masuk
            </button>
        </form>

        <div class="hr"><span class="muted" style="white-space:nowrap">Atau masuk dengan</span></div>

        <a class="btn btn-outline" href="{{ route('auth.google.redirect') }}" style="text-decoration:none">
            <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="#FFC107" d="M43.611 20.083h-1.611V20H24v8h11.303C33.594 32.311 29.223 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.957 3.043l5.657-5.657C33.846 6.053 29.134 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.651-.389-3.917z"/><path fill="#FF3D00" d="M6.306 14.691l6.571 4.817C14.464 16.122 18.839 12 24 12c3.059 0 5.842 1.154 7.957 3.043l5.657-5.657C33.846 6.053 29.134 4 24 4 16.318 4 9.661 8.337 6.306 14.691z"/><path fill="#4CAF50" d="M24 44c5.166 0 9.83-1.977 13.363-5.197l-6.166-5.223C29.111 35.488 26.707 36 24 36c-5.202 0-9.561-3.664-11.088-8.602l-6.519 5.02C9.707 39.556 16.318 44 24 44z"/><path fill="#1976D2" d="M43.611 20.083h-1.611V20H24v8h11.303a12.02 12.02 0 01-4.091 5.58l.003-.002 6.166 5.223C35.06 39.098 40 32 40 24c0-1.341-.138-2.651-.389-3.917z"/></svg>
            Masuk dengan Google
        </a>

        <div class="foot">
            Belum punya akun?
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Daftar sekarang</a>
            @else
                <span>Hubungi admin untuk pembuatan akun.</span>
            @endif
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const inp = document.getElementById('password');
  const btn = document.getElementById('togglePass');
  if (!inp || !btn) return;

  const eye = '\n<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/></svg>';
  const eyeOff = '\n<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M10.58 10.59A3 3 0 0012 15a3 3 0 002.41-4.41M9.88 5.09C10.56 5.03 11.27 5 12 5c6.5 0 10 7 10 7a18.71 18.71 0 01-4.17 5.15M6.17 6.17A18.77 18.77 0 002 12s3.5 7 10 7c1.33 0 2.57-.21 3.71-.58" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

  function sync() {
    btn.innerHTML = inp.type === 'password' ? eye : eyeOff;
    btn.setAttribute('aria-label', inp.type === 'password' ? 'Tampilkan password' : 'Sembunyikan password');
  }

  btn.addEventListener('click', function(){
    inp.type = inp.type === 'password' ? 'text' : 'password';
    sync();
  });

  sync();
});
</script>
</body>
</html>
