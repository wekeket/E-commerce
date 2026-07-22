<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>OG TECH — Sign In</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root{
        --navy:#142666;
        --green:#1BC49B;
        --green-dark:#159c7c;
        --panel-bg:#eef0f5;
        --text-muted:#c7cbe6;
        --red:#f16a6a;
    }
    *{ box-sizing:border-box; margin:0; padding:0; }
    body{
        font-family:'Poppins', sans-serif;
        background:var(--panel-bg);
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px;
    }
    .auth-card{
        width:100%;
        max-width:340px;
        background:var(--navy);
        border:2px solid var(--green);
        border-radius:14px;
        padding:34px 30px;
        color:#fff;
    }
    .brand{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        font-weight:800;
        font-size:16px;
        letter-spacing:.5px;
        margin-bottom:18px;
    }
    .brand .g-icon{
        width:22px;height:22px;border-radius:50%;
        border:2px solid var(--green);
        display:flex;align-items:center;justify-content:center;
        font-size:11px;font-weight:800;color:var(--green);
    }
    h1{
        text-align:center;
        font-size:19px;
        font-weight:800;
        letter-spacing:.5px;
        margin-bottom:22px;
    }
    label{
        display:block;
        font-size:11px;
        font-weight:700;
        letter-spacing:.5px;
        margin-bottom:6px;
    }
    .field{ margin-bottom:16px; }
    input[type=email], input[type=password]{
        width:100%;
        padding:10px 12px;
        border-radius:6px;
        border:none;
        background:#d9dbe4;
        font-family:inherit;
        font-size:12.5px;
        color:#33364a;
        outline:none;
    }
    input[type=email]:focus, input[type=password]:focus{
        box-shadow:0 0 0 2px var(--green);
    }
    .btn-submit{
        width:100%;
        background:var(--green);
        color:#fff;
        border:none;
        padding:11px;
        border-radius:7px;
        font-family:inherit;
        font-size:12.5px;
        font-weight:700;
        letter-spacing:.5px;
        cursor:pointer;
        margin-top:6px;
        transition:.15s;
    }
    .btn-submit:hover{ background:var(--green-dark); }
    .footer-link{
        text-align:center;
        font-size:11.5px;
        margin-top:16px;
        color:var(--text-muted);
    }
    .footer-link a{
        color:#fff;
        font-weight:700;
        text-decoration:underline;
    }
    .errors{
        background:rgba(241,106,106,0.15);
        border:1px solid var(--red);
        color:#ffd6d6;
        border-radius:6px;
        padding:8px 12px;
        font-size:11.5px;
        margin-bottom:16px;
    }
    .status-msg{
        background:rgba(27,196,155,0.15);
        border:1px solid var(--green);
        color:#c9fff0;
        border-radius:6px;
        padding:8px 12px;
        font-size:11.5px;
        margin-bottom:16px;
        text-align:center;
    }
</style>
</head>
<body>
<div class="auth-card">
    <div class="brand"><span class="g-icon">G</span> OG TECH</div>
    <h1>WELCOME BACK</h1>

    @if(session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="errors">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="field">
            <label for="email">EMAIL :</label>
            <input type="email" id="email" name="email" placeholder="Example123@gmail.com" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field">
            <label for="password">PASSWORD :</label>
            <input type="password" id="password" name="password" placeholder="••••••••••••" required>
        </div>

        <button type="submit" class="btn-submit">SIGN IN</button>
    </form>

    <div class="footer-link">
        Create account? <a href="{{ route('register') }}">Sign Up</a>
    </div>
</div>
</body>
</html>