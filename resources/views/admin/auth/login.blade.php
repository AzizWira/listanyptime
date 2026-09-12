<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#fff7fa"><title>Login Admin</title><link rel="stylesheet" href="/assets/css/admin.css?v=1.0.2"></head>
<body class="login-page"><main class="login-card"><div class="login-mark">🎀</div><span class="kicker">OWNER ACCESS</span><h1>Masuk ke Pinky Admin</h1><p>Kelola produk, harga, dan status langsung dari HP.</p>
@if($errors->any())<div class="flash error">{{ $errors->first() }}</div>@endif
@if(session('status'))<div class="flash success">{{ session('status') }}</div>@endif
<form method="post" action="{{ route('admin.login.store') }}" class="stack-form">@csrf
<label class="field"><span>Email</span><input type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus placeholder="admin@example.com"></label>
<label class="field"><span>Password</span><input type="password" name="password" autocomplete="current-password" required placeholder="••••••••"></label>
<label class="check-line"><input type="checkbox" name="remember" value="1"><span>Ingat saya di perangkat ini</span></label>
<button class="button primary full" type="submit">Masuk Admin</button></form><a class="back-store" href="{{ route('storefront') }}">← Kembali ke pricelist</a></main></body></html>
