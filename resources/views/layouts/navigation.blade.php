<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .hb-nav {
    font-family: 'DM Sans', sans-serif;
    background: #fff;
    border-bottom: 0.5px solid rgba(26,25,22,0.10);
    position: sticky;
    top: 0;
    z-index: 50;
  }
  .hb-nav-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
  }
  .hb-logo {
    font-family: 'DM Serif Display', serif;
    font-size: 20px;
    font-weight: 400;
    letter-spacing: -0.4px;
    color: #1A1916;
    text-decoration: none;
    line-height: 1;
  }
  .hb-logo em { font-style: italic; color: #6B6A66; }

  .hb-links { display: flex; align-items: center; gap: 2px; }
  .hb-link {
    font-size: 13px;
    color: #6B6A66;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 8px;
    transition: background 0.12s, color 0.12s;
  }
  .hb-link:hover { background: #F5F4F0; color: #1A1916; }
  .hb-link.active { background: #F5F4F0; color: #1A1916; font-weight: 500; }

  .hb-right { display: flex; align-items: center; gap: 8px; }

  .hb-dropdown { position: relative; }
  .hb-user-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 10px 5px 5px;
    border: 0.5px solid rgba(26,25,22,0.12);
    border-radius: 10px;
    background: transparent;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    color: #1A1916;
    transition: background 0.12s, border-color 0.12s;
  }
  .hb-user-btn:hover { background: #F5F4F0; border-color: rgba(26,25,22,0.20); }

  .hb-avatar {
    width: 28px; height: 28px;
    border-radius: 7px;
    background: #1A1916;
    color: #fff;
    font-size: 11px; font-weight: 500;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; user-select: none;
  }

  .hb-chevron { color: #A09E99; transition: transform 0.15s; }
  .hb-dropdown.open .hb-chevron { transform: rotate(180deg); }

  .hb-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 6px);
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.12);
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(26,25,22,0.10);
    min-width: 180px;
    overflow: hidden;
    z-index: 100;
  }
  .hb-dropdown.open .hb-menu { display: block; }

  .hb-menu-header {
    padding: 12px 14px 10px;
    border-bottom: 0.5px solid rgba(26,25,22,0.07);
  }
  .hb-menu-name  { font-size: 13px; font-weight: 500; color: #1A1916; }
  .hb-menu-email { font-size: 11px; color: #A09E99; margin-top: 1px; }

  .hb-menu-item {
    display: block;
    padding: 9px 14px;
    font-size: 13px;
    color: #6B6A66;
    text-decoration: none;
    transition: background 0.10s, color 0.10s;
    cursor: pointer;
    width: 100%;
    text-align: left;
    background: transparent;
    border: none;
    font-family: 'DM Sans', sans-serif;
  }
  .hb-menu-item:hover { background: #F5F4F0; color: #1A1916; }
  .hb-menu-item.danger:hover { background: #FCEBEB; color: #A32D2D; }
  .hb-menu-divider { border: none; border-top: 0.5px solid rgba(26,25,22,0.07); margin: 4px 0; }

  .hb-role {
    font-size: 10px; font-weight: 500;
    padding: 2px 7px; border-radius: 20px; text-transform: capitalize;
  }
  .hb-role-admin     { background: #EEEDFE; color: #534AB7; }
  .hb-role-employer  { background: #E6F1FB; color: #185FA5; }
  .hb-role-jobseeker { background: #EAF3DE; color: #3B6D11; }

  .hb-hamburger {
    display: none;
    padding: 6px;
    border: 0.5px solid rgba(26,25,22,0.12);
    border-radius: 8px;
    background: transparent;
    cursor: pointer;
    color: #6B6A66;
    transition: background 0.12s;
  }
  .hb-hamburger:hover { background: #F5F4F0; }

  .hb-mobile { display: none; border-top: 0.5px solid rgba(26,25,22,0.07); padding: 10px 1.5rem 14px; }
  .hb-mobile.open { display: block; }
  .hb-mobile-link {
    display: block;
    font-size: 14px; color: #6B6A66;
    text-decoration: none;
    padding: 9px 10px; border-radius: 8px;
    transition: background 0.12s, color 0.12s;
    width: 100%; text-align: left;
    border: none; background: transparent;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
  }
  .hb-mobile-link:hover { background: #F5F4F0; color: #1A1916; }
  .hb-mobile-divider { border: none; border-top: 0.5px solid rgba(26,25,22,0.07); margin: 8px 0; }
  .hb-mobile-user { display: flex; align-items: center; gap: 10px; padding: 8px 10px; margin-bottom: 4px; }
  .hb-mobile-name  { font-size: 13px; font-weight: 500; color: #1A1916; }
  .hb-mobile-email { font-size: 11px; color: #A09E99; }

  @media (max-width: 640px) {
    .hb-links    { display: none; }
    .hb-user-btn { display: none; }
    .hb-hamburger { display: flex; align-items: center; justify-content: center; }
  }
</style>

<nav class="hb-nav">
  <div class="hb-nav-inner">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="hb-logo">Hire<em>board</em></a>

    {{-- Desktop links --}}
    <div class="hb-links">
      <a href="{{ route('home') }}"
         class="hb-link {{ request()->routeIs('home') ? 'active' : '' }}">
        Browse jobs
      </a>
      @auth
        <a href="{{ route('dashboard') }}"
           class="hb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          Dashboard
        </a>
      @endauth
    </div>

    {{-- Desktop right --}}
    <div class="hb-right">
      @auth
        @php
          $initials  = strtoupper(substr(Auth::user()->name, 0, 2));
          $roleClass = match(Auth::user()->role) {
            'admin'    => 'hb-role-admin',
            'employer' => 'hb-role-employer',
            default    => 'hb-role-jobseeker',
          };
        @endphp

        <div class="hb-dropdown" id="hbDropdown">
          <button class="hb-user-btn" onclick="toggleDropdown()">
            <div class="hb-avatar">{{ $initials }}</div>
            <span>{{ Auth::user()->name }}</span>
            <span class="hb-role {{ $roleClass }}">{{ Auth::user()->role }}</span>
            <svg class="hb-chevron" width="14" height="14" viewBox="0 0 14 14" fill="none">
              <path d="M3 5l4 4 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>

          <div class="hb-menu">
            <div class="hb-menu-header">
              <div class="hb-menu-name">{{ Auth::user()->name }}</div>
              <div class="hb-menu-email">{{ Auth::user()->email }}</div>
            </div>
            <a href="{{ route('profile.edit') }}" class="hb-menu-item">Profile</a>
            <a href="{{ route('dashboard') }}" class="hb-menu-item">Dashboard</a>
            <hr class="hb-menu-divider">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="hb-menu-item danger">Log out</button>
            </form>
          </div>
        </div>

      @else
        <a href="{{ route('login') }}"
           style="font-size:13px;color:#6B6A66;text-decoration:none;padding:7px 14px;border:0.5px solid rgba(26,25,22,0.15);border-radius:8px;transition:background 0.12s;"
           onmouseover="this.style.background='#F5F4F0'" onmouseout="this.style.background='transparent'">
          Sign in
        </a>
        <a href="{{ route('register') }}"
           style="font-size:13px;color:#fff;text-decoration:none;padding:7px 14px;background:#1A1916;border-radius:8px;font-weight:500;transition:opacity 0.15s;"
           onmouseover="this.style.opacity='0.82'" onmouseout="this.style.opacity='1'">
          Register
        </a>
      @endauth

      {{-- Hamburger --}}
      <button class="hb-hamburger" onclick="toggleMobile()">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M2 4h14M2 9h14M2 14h14" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
        </svg>
      </button>
    </div>

  </div>

  {{-- Mobile menu --}}
  <div class="hb-mobile" id="hbMobile">
    @auth
      <div class="hb-mobile-user">
        <div class="hb-avatar" style="width:36px;height:36px;border-radius:9px;font-size:12px;">
          {{ $initials }}
        </div>
        <div>
          <div class="hb-mobile-name">{{ Auth::user()->name }}</div>
          <div class="hb-mobile-email">{{ Auth::user()->email }}</div>
        </div>
      </div>
      <hr class="hb-mobile-divider">
    @endauth

    <a href="{{ route('home') }}" class="hb-mobile-link">Browse jobs</a>

    @auth
      <a href="{{ route('dashboard') }}" class="hb-mobile-link">Dashboard</a>
      <a href="{{ route('profile.edit') }}" class="hb-mobile-link">Profile</a>
      <hr class="hb-mobile-divider">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="hb-mobile-link">Log out</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="hb-mobile-link">Sign in</a>
      <a href="{{ route('register') }}" class="hb-mobile-link">Register</a>
    @endauth
  </div>
</nav>

<script>
  function toggleDropdown() {
    document.getElementById('hbDropdown').classList.toggle('open');
  }
  function toggleMobile() {
    document.getElementById('hbMobile').classList.toggle('open');
  }
  document.addEventListener('click', function(e) {
    const d = document.getElementById('hbDropdown');
    if (d && !d.contains(e.target)) d.classList.remove('open');
  });
</script>