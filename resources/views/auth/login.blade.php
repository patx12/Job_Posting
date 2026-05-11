<x-guest-layout>
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .login-wrap {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    background: #F5F4F0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
  }

  .login-card {
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 20px;
    padding: 40px 36px 36px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.06), 0 4px 24px rgba(26,25,22,0.05);
  }

  .login-brand {
    margin-bottom: 28px;
  }
  .login-brand h1 {
    font-family: 'DM Serif Display', serif;
    font-size: 26px;
    font-weight: 400;
    letter-spacing: -0.5px;
    line-height: 1;
    color: #1A1916;
  }
  .login-brand h1 em { font-style: italic; color: #6B6A66; }
  .login-brand p {
    font-size: 13px;
    color: #A09E99;
    margin-top: 5px;
  }

  .field { margin-bottom: 16px; }

  .field label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #6B6A66;
    margin-bottom: 6px;
  }

  .field input[type="email"],
  .field input[type="password"] {
    width: 100%;
    padding: 10px 13px;
    border: 0.5px solid rgba(26,25,22,0.18);
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: #1A1916;
    background: #F9F8F5;
    outline: none;
    transition: border-color 0.12s, background 0.12s;
    box-sizing: border-box;
  }
  .field input:focus {
    border-color: #1A1916;
    background: #fff;
  }

  .field .error {
    font-size: 12px;
    color: #A32D2D;
    margin-top: 5px;
  }

  .remember-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 22px;
  }
  .remember-row input[type="checkbox"] {
    width: 15px;
    height: 15px;
    border: 0.5px solid rgba(26,25,22,0.25);
    border-radius: 4px;
    accent-color: #1A1916;
    cursor: pointer;
  }
  .remember-row label {
    font-size: 13px;
    color: #6B6A66;
    cursor: pointer;
    user-select: none;
  }

  .btn-login {
    width: 100%;
    padding: 11px;
    background: #1A1916;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: opacity 0.15s;
    letter-spacing: 0.01em;
  }
  .btn-login:hover { opacity: 0.82; }

  .login-footer {
    text-align: center;
    margin-top: 18px;
  }
  .login-footer a {
    font-size: 13px;
    color: #A09E99;
    text-decoration: none;
    transition: color 0.12s;
  }
  .login-footer a:hover { color: #1A1916; }

  .divider {
    border: none;
    border-top: 0.5px solid rgba(26,25,22,0.08);
    margin: 24px 0;
  }

  .status-msg {
    font-size: 13px;
    color: #3B6D11;
    background: #EAF3DE;
    border-radius: 8px;
    padding: 10px 13px;
    margin-bottom: 20px;
  }
</style>

<div class="login-wrap">
  <div class="login-card">

    <div class="login-brand">
      <h1>Job<em>Board</em></h1>
      <p>Sign in to your account</p>
    </div>

    {{-- Session status --}}
    @if (session('status'))
      <div class="status-msg">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      {{-- Email --}}
      <div class="field">
        <label for="email">Email address</label>
        <input id="email" type="email" name="email"
               value="{{ old('email') }}"
               required autofocus autocomplete="username"
               placeholder="you@example.com" />
        @error('email')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password"
               required autocomplete="current-password"
               placeholder="••••••••" />
        @error('password')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      {{-- Remember me --}}
      <div class="remember-row">
        <input id="remember_me" type="checkbox" name="remember">
        <label for="remember_me">Remember me</label>
      </div>

      <button type="submit" class="btn-login">Sign in</button>

      @if (Route::has('password.request'))
        <div class="login-footer">
          <a href="{{ route('password.request') }}">Forgot your password?</a>
        </div>
      @endif

    </form>
  </div>
</div>

</x-guest-layout>