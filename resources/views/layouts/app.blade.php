<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobBoard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />
</head>
<body style="background:#F5F4F0;color:#1A1916;min-height:100vh;margin:0;font-family:'DM Sans',sans-serif;">

{{-- Navbar --}}
<nav style="font-family:'DM Sans',sans-serif;background:#fff;border-bottom:0.5px solid rgba(26,25,22,0.10);position:sticky;top:0;z-index:50;">
  <div style="max-width:1100px;margin:0 auto;padding:0 1.5rem;height:56px;display:flex;align-items:center;justify-content:space-between;gap:1rem;">

    {{-- Logo --}}
    <a href="{{ route('home') }}" style="font-family:'DM Serif Display',serif;font-size:20px;font-weight:400;letter-spacing:-0.4px;color:#1A1916;text-decoration:none;line-height:1;flex-shrink:0;">
      Job<em style="font-style:italic;color:#6B6A66;">Board</em>
    </a>

    {{-- Desktop links --}}
    <div style="display:flex;align-items:center;gap:2px;">
      <a href="{{ route('home') }}"
         style="font-size:13px;color:{{ request()->routeIs('home') ? '#1A1916' : '#6B6A66' }};text-decoration:none;padding:6px 12px;border-radius:8px;background:{{ request()->routeIs('home') ? '#F5F4F0' : 'transparent' }};font-weight:{{ request()->routeIs('home') ? '500' : '400' }};"
         onmouseover="this.style.background='#F5F4F0';this.style.color='#1A1916'"
         onmouseout="this.style.background='{{ request()->routeIs('home') ? '#F5F4F0' : 'transparent' }}';this.style.color='{{ request()->routeIs('home') ? '#1A1916' : '#6B6A66' }}'">
        Browse jobs
      </a>
      @auth
        <a href="{{ route('dashboard') }}"
           style="font-size:13px;color:#6B6A66;text-decoration:none;padding:6px 12px;border-radius:8px;"
           onmouseover="this.style.background='#F5F4F0';this.style.color='#1A1916'"
           onmouseout="this.style.background='transparent';this.style.color='#6B6A66'">
          Dashboard
        </a>
      @endauth
    </div>

    {{-- Right side --}}
    <div style="display:flex;align-items:center;gap:8px;">
      @auth
        @php
          $initials   = strtoupper(substr(Auth::user()->name, 0, 2));
          $roleStyles = match(Auth::user()->role) {
            'admin'    => 'background:#EEEDFE;color:#534AB7;',
            'employer' => 'background:#E6F1FB;color:#185FA5;',
            default    => 'background:#EAF3DE;color:#3B6D11;',
          };
        @endphp

        <div style="position:relative;" id="hbDropdown">
          <button onclick="toggleDropdown()"
                  style="display:flex;align-items:center;gap:8px;padding:5px 10px 5px 5px;border:0.5px solid rgba(26,25,22,0.12);border-radius:10px;background:transparent;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;color:#1A1916;"
                  onmouseover="this.style.background='#F5F4F0'" onmouseout="this.style.background='transparent'">
            <div style="width:28px;height:28px;border-radius:7px;background:#1A1916;color:#fff;font-size:11px;font-weight:500;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $initials }}</div>
            <span>{{ Auth::user()->name }}</span>
            <span style="font-size:10px;font-weight:500;padding:2px 7px;border-radius:20px;text-transform:capitalize;{{ $roleStyles }}">{{ Auth::user()->role }}</span>
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
              <path d="M3 5l4 4 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>

          <div id="hbMenu" style="display:none;position:absolute;right:0;top:calc(100% + 6px);background:#fff;border:0.5px solid rgba(26,25,22,0.12);border-radius:12px;box-shadow:0 8px 30px rgba(26,25,22,0.10);min-width:180px;overflow:hidden;z-index:100;">
            <div style="padding:12px 14px 10px;border-bottom:0.5px solid rgba(26,25,22,0.07);">
              <div style="font-size:13px;font-weight:500;color:#1A1916;">{{ Auth::user()->name }}</div>
              <div style="font-size:11px;color:#A09E99;margin-top:1px;">{{ Auth::user()->email }}</div>
            </div>
            <a href="{{ route('profile.edit') }}"
               style="display:block;padding:9px 14px;font-size:13px;color:#6B6A66;text-decoration:none;"
               onmouseover="this.style.background='#F5F4F0';this.style.color='#1A1916'"
               onmouseout="this.style.background='transparent';this.style.color='#6B6A66'">
              Profile
            </a>
            <a href="{{ route('dashboard') }}"
               style="display:block;padding:9px 14px;font-size:13px;color:#6B6A66;text-decoration:none;"
               onmouseover="this.style.background='#F5F4F0';this.style.color='#1A1916'"
               onmouseout="this.style.background='transparent';this.style.color='#6B6A66'">
              Dashboard
            </a>
            <hr style="border:none;border-top:0.5px solid rgba(26,25,22,0.07);margin:4px 0;">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
              @csrf
              <button type="submit"
                      style="display:block;width:100%;padding:9px 14px;font-size:13px;color:#6B6A66;background:transparent;border:none;text-align:left;cursor:pointer;font-family:'DM Sans',sans-serif;"
                      onmouseover="this.style.background='#FCEBEB';this.style.color='#A32D2D'"
                      onmouseout="this.style.background='transparent';this.style.color='#6B6A66'">
                Log out
              </button>
            </form>
          </div>
        </div>

      @else
        <a href="{{ route('login') }}"
           style="font-size:13px;color:#6B6A66;text-decoration:none;padding:7px 14px;border:0.5px solid rgba(26,25,22,0.15);border-radius:8px;"
           onmouseover="this.style.background='#F5F4F0';this.style.color='#1A1916'"
           onmouseout="this.style.background='transparent';this.style.color='#6B6A66'">
          Sign in
        </a>
        <a href="{{ route('register') }}"
           style="font-size:13px;color:#fff;text-decoration:none;padding:7px 14px;background:#1A1916;border-radius:8px;font-weight:500;"
           onmouseover="this.style.opacity='0.82'" onmouseout="this.style.opacity='1'">
          Register
        </a>
      @endauth
    </div>

  </div>
</nav>

{{-- Main content --}}
<main style="max-width:1100px;margin:0 auto;padding:2rem 1.5rem;">
    @if(session('success'))
        <div style="margin-bottom:1rem;padding:11px 16px;background:#EAF3DE;color:#3B6D11;border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="margin-bottom:1rem;padding:11px 16px;background:#FCEBEB;color:#A32D2D;border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;">
            {{ session('error') }}
        </div>
    @endif
    @yield('content')
</main>

{{-- Footer --}}
<footer style="font-family:'DM Sans',sans-serif;background:#fff;border-top:0.5px solid rgba(26,25,22,0.10);margin-top:4rem;padding:3rem 1.5rem 2rem;">
  <div style="max-width:1100px;margin:0 auto;">

    <div style="margin-bottom:2.5rem;">
      <a href="{{ route('home') }}" style="font-family:'DM Serif Display',serif;font-size:20px;font-weight:400;color:#1A1916;text-decoration:none;letter-spacing:-0.4px;">
        Job<em style="font-style:italic;color:#6B6A66;">Board</em>
      </a>
      <p style="font-size:12.5px;color:#A09E99;margin-top:5px;">Find your next opportunity.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:2rem;margin-bottom:2.5rem;">

      <div>
        <p style="font-size:10.5px;font-weight:500;text-transform:uppercase;letter-spacing:0.09em;color:#A09E99;margin-bottom:14px;">Job seekers</p>
        <div style="display:flex;flex-direction:column;gap:9px;">
          <a href="{{ route('home') }}"
             style="font-size:13px;color:#6B6A66;text-decoration:none;"
             onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Browse jobs</a>
          <a href="{{ route('register') }}"
             style="font-size:13px;color:#6B6A66;text-decoration:none;"
             onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Create account</a>
          @auth
            <a href="{{ route('jobseeker.dashboard') }}"
               style="font-size:13px;color:#6B6A66;text-decoration:none;"
               onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">My applications</a>
            <a href="{{ route('profile.edit') }}"
               style="font-size:13px;color:#6B6A66;text-decoration:none;"
               onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Profile</a>
          @endauth
        </div>
      </div>

      <div>
        <p style="font-size:10.5px;font-weight:500;text-transform:uppercase;letter-spacing:0.09em;color:#A09E99;margin-bottom:14px;">Employers</p>
        <div style="display:flex;flex-direction:column;gap:9px;">
          <a href="{{ route('register') }}"
             style="font-size:13px;color:#6B6A66;text-decoration:none;"
             onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Register for free</a>
          @auth
            @if(auth()->user()->isEmployer())
              <a href="{{ route('jobs.create') }}"
                 style="font-size:13px;color:#6B6A66;text-decoration:none;"
                 onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Post a job</a>
              <a href="{{ route('employer.dashboard') }}"
                 style="font-size:13px;color:#6B6A66;text-decoration:none;"
                 onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Dashboard</a>
            @endif
          @endauth
        </div>
      </div>

      <div>
        <p style="font-size:10.5px;font-weight:500;text-transform:uppercase;letter-spacing:0.09em;color:#A09E99;margin-bottom:14px;">Account</p>
        <div style="display:flex;flex-direction:column;gap:9px;">
          @guest
            <a href="{{ route('login') }}"
               style="font-size:13px;color:#6B6A66;text-decoration:none;"
               onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Sign in</a>
            <a href="{{ route('register') }}"
               style="font-size:13px;color:#6B6A66;text-decoration:none;"
               onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Register</a>
          @else
            <a href="{{ route('profile.edit') }}"
               style="font-size:13px;color:#6B6A66;text-decoration:none;"
               onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Profile settings</a>
          @endguest
        </div>
      </div>

      <div>
        <p style="font-size:10.5px;font-weight:500;text-transform:uppercase;letter-spacing:0.09em;color:#A09E99;margin-bottom:14px;">Platform</p>
        <div style="display:flex;flex-direction:column;gap:9px;">
          <a href="{{ route('home') }}"
             style="font-size:13px;color:#6B6A66;text-decoration:none;"
             onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Browse all jobs</a>
          @auth
            @if(auth()->user()->isAdmin())
              <a href="{{ route('admin.dashboard') }}"
                 style="font-size:13px;color:#6B6A66;text-decoration:none;"
                 onmouseover="this.style.color='#1A1916'" onmouseout="this.style.color='#6B6A66'">Admin panel</a>
            @endif
          @endauth
        </div>
      </div>

    </div>

    <div style="border-top:0.5px solid rgba(26,25,22,0.08);padding-top:1.25rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
      <p style="font-size:12px;color:#C4C2BC;margin:0;">&copy; {{ date('Y') }} JobBoard. All rights reserved.</p>
      <div style="display:flex;gap:16px;">
        <a href="#" style="font-size:12px;color:#C4C2BC;text-decoration:none;" onmouseover="this.style.color='#6B6A66'" onmouseout="this.style.color='#C4C2BC'">Privacy</a>
        <a href="#" style="font-size:12px;color:#C4C2BC;text-decoration:none;" onmouseover="this.style.color='#6B6A66'" onmouseout="this.style.color='#C4C2BC'">Terms</a>
        <a href="#" style="font-size:12px;color:#C4C2BC;text-decoration:none;" onmouseover="this.style.color='#6B6A66'" onmouseout="this.style.color='#C4C2BC'">Contact</a>
      </div>
    </div>

  </div>
</footer>

<script>
  function toggleDropdown() {
    const m = document.getElementById('hbMenu');
    if (m) m.style.display = m.style.display === 'block' ? 'none' : 'block';
  }
  document.addEventListener('click', function(e) {
    const d = document.getElementById('hbDropdown');
    const m = document.getElementById('hbMenu');
    if (!d || !m) return;
    if (!d.contains(e.target)) m.style.display = 'none';
  });
</script>

</body>
</html>