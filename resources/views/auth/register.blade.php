<x-guest-layout>
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .reg-wrap {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    background: #F5F4F0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
  }

  .reg-card {
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 20px;
    padding: 40px 36px 36px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.06), 0 4px 24px rgba(26,25,22,0.05);
  }

  .reg-brand { margin-bottom: 28px; }
  .reg-brand h1 {
    font-family: 'DM Serif Display', serif;
    font-size: 26px;
    font-weight: 400;
    letter-spacing: -0.5px;
    line-height: 1;
    color: #1A1916;
  }
  .reg-brand h1 em { font-style: italic; color: #6B6A66; }
  .reg-brand p { font-size: 13px; color: #A09E99; margin-top: 5px; }

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

  .field input[type="text"],
  .field input[type="email"],
  .field input[type="password"],
  .field select {
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
    appearance: none;
  }
  .field input:focus,
  .field select:focus {
    border-color: #1A1916;
    background: #fff;
  }
  .field .error {
    font-size: 12px;
    color: #A32D2D;
    margin-top: 5px;
  }

  /* Role toggle */
  .role-toggle {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-top: 2px;
  }
  .role-toggle input[type="radio"] { display: none; }
  .role-toggle label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 14px 10px;
    border: 0.5px solid rgba(26,25,22,0.15);
    border-radius: 10px;
    background: #F9F8F5;
    cursor: pointer;
    font-size: 13px;
    font-weight: 400;
    text-transform: none;
    letter-spacing: 0;
    color: #6B6A66;
    transition: border-color 0.12s, background 0.12s, color 0.12s;
  }
  .role-toggle label svg { opacity: 0.45; transition: opacity 0.12s; }
  .role-toggle input[type="radio"]:checked + label {
    border-color: #1A1916;
    background: #fff;
    color: #1A1916;
    font-weight: 500;
  }
  .role-toggle input[type="radio"]:checked + label svg { opacity: 1; }

  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

  .btn-register {
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
    margin-top: 6px;
  }
  .btn-register:hover { opacity: 0.82; }

  .reg-footer { text-align: center; margin-top: 16px; }
  .reg-footer a {
    font-size: 13px;
    color: #A09E99;
    text-decoration: none;
    transition: color 0.12s;
  }
  .reg-footer a:hover { color: #1A1916; }

  @media (max-width: 420px) {
    .reg-card { padding: 32px 22px 28px; }
    .form-row { grid-template-columns: 1fr; }
  }
</style>

<div class="reg-wrap">
  <div class="reg-card">

    <div class="reg-brand">
      <h1>Job<em>Board</em></h1>
      <p>Create your account</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      {{-- Name --}}
      <div class="field">
        <label for="name">Full name</label>
        <input id="name" type="text" name="name"
               value="{{ old('name') }}"
               required autofocus autocomplete="name"
               placeholder="" />
        @error('name') <p class="error">{{ $message }}</p> @enderror
      </div>

      {{-- Email --}}
      <div class="field">
        <label for="email">Email address</label>
        <input id="email" type="email" name="email"
               value="{{ old('email') }}"
               required autocomplete="username"
               placeholder="" />
        @error('email') <p class="error">{{ $message }}</p> @enderror
      </div>

      {{-- Role --}}
      <div class="field">
        <label>I am a</label>
        <div class="role-toggle">
          <input type="radio" id="role_seeker" name="role" value="jobseeker"
                 @checked(old('role', 'jobseeker') == 'jobseeker')>
          <label for="role_seeker">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke-linecap="round"/>
            </svg>
            Job seeker
          </label>
          <input type="radio" id="role_employer" name="role" value="employer"
                 @checked(old('role') == 'employer')>
          <label for="role_employer">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke-linecap="round"/>
            </svg>
            Employer
          </label>
        </div>
        @error('role') <p class="error">{{ $message }}</p> @enderror
      </div>

      {{-- Password row --}}
      <div class="form-row">
        <div class="field">
          <label for="password">Password</label>
          <input id="password" type="password" name="password"
                 required autocomplete="new-password"
                 placeholder="" />
          @error('password') <p class="error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
          <label for="password_confirmation">Confirm</label>
          <input id="password_confirmation" type="password" name="password_confirmation"
                 required autocomplete="new-password"
                 placeholder="" />
          @error('password_confirmation') <p class="error">{{ $message }}</p> @enderror
        </div>
      </div>

      <button type="submit" class="btn-register">Create account</button>

      <div class="reg-footer">
        <a href="{{ route('login') }}">Already have an account? Sign in</a>
      </div>

    </form>
  </div>
</div>

</x-guest-layout>