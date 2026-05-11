@extends('layouts.app')
@section('title', 'Applicants — ' . $jobListing->title)
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');
  .wrap { font-family:'DM Sans',sans-serif; max-width:860px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }
  .back-link { display:inline-flex; align-items:center; gap:5px; font-size:13px; color:#6B6A66; text-decoration:none; margin-bottom:1.5rem; transition:color 0.12s; }
  .back-link:hover { color:#1A1916; }
  .page-header { margin-bottom:2rem; }
  .page-header h1 { font-family:'DM Serif Display',serif; font-size:26px; font-weight:400; letter-spacing:-0.4px; color:#1A1916; line-height:1; }
  .page-header h1 em { font-style:italic; color:#6B6A66; }
  .page-header p { font-size:13px; color:#A09E99; margin-top:5px; }
  .alert-success { background:#EAF3DE; color:#3B6D11; border-radius:10px; padding:11px 16px; font-size:13px; margin-bottom:16px; }

  .app-list { display:flex; flex-direction:column; gap:8px; }
  .app-card {
    background:#fff; border:0.5px solid rgba(26,25,22,0.10);
    border-radius:14px; padding:18px 20px;
    box-shadow:0 1px 3px rgba(26,25,22,0.05);
    display:grid; grid-template-columns:auto 1fr auto;
    gap:14px; align-items:start;
    transition:border-color 0.15s;
  }
  .app-card:hover { border-color:rgba(26,25,22,0.20); }

  .app-avatar {
    width:42px; height:42px; border-radius:10px;
    background:#F5F4F0; border:0.5px solid rgba(26,25,22,0.08);
    display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:500; color:#1A1916; flex-shrink:0;
  }

  .app-info { min-width:0; }
  .app-name { font-size:14.5px; font-weight:500; color:#1A1916; margin-bottom:3px; }
  .app-email { font-size:12px; color:#A09E99; margin-bottom:8px; }
  .app-meta { display:flex; flex-wrap:wrap; gap:8px; align-items:center; }

  .badge { font-size:11px; font-weight:500; padding:3px 9px; border-radius:20px; white-space:nowrap; line-height:1.6; }
  .badge-pending  { background:#EEEDE9; color:#5F5E5A; }
  .badge-reviewed { background:#FAEEDA; color:#854F0B; }
  .badge-accepted { background:#EAF3DE; color:#3B6D11; }
  .badge-rejected { background:#FCEBEB; color:#A32D2D; }

  .app-date { font-size:12px; color:#C4C2BC; }

  .cover-letter {
    font-size:13px; color:#6B6A66; line-height:1.65;
    background:#F9F8F5; border-radius:8px; padding:10px 12px;
    margin-top:10px; border:0.5px solid rgba(26,25,22,0.07);
    white-space:pre-line;
  }
  .cover-label { font-size:10.5px; font-weight:500; text-transform:uppercase; letter-spacing:0.08em; color:#A09E99; margin-bottom:4px; }

  .resume-link {
    display:inline-flex; align-items:center; gap:5px;
    font-size:12px; color:#185FA5; text-decoration:none;
    padding:4px 10px; border:0.5px solid #B8D4F0; border-radius:6px;
    background:#E6F1FB; transition:opacity 0.12s;
  }
  .resume-link:hover { opacity:0.8; }

  .action-form { display:flex; flex-direction:column; align-items:flex-end; gap:6px; flex-shrink:0; }
  .status-select {
    font-size:12px; padding:6px 10px;
    border:0.5px solid rgba(26,25,22,0.18); border-radius:8px;
    font-family:'DM Sans',sans-serif; color:#1A1916;
    background:#F9F8F5; outline:none; cursor:pointer; appearance:none;
  }
  .status-select:focus { border-color:#1A1916; background:#fff; }
  .btn-update {
    font-size:12px; font-weight:500; font-family:'DM Sans',sans-serif;
    padding:7px 14px; border-radius:8px; cursor:pointer;
    background:#1A1916; color:#fff; border:none; transition:opacity 0.15s;
    white-space:nowrap;
  }
  .btn-update:hover { opacity:0.82; }

  .empty-card {
    background:#fff; border:0.5px dashed rgba(26,25,22,0.15);
    border-radius:14px; padding:4rem 1rem; text-align:center;
  }
  .empty-card h3 { font-family:'DM Serif Display',serif; font-size:20px; font-weight:400; color:#1A1916; margin-bottom:4px; }
  .empty-card p { font-size:13px; color:#A09E99; }

  .pagination-wrap { margin-top:1.5rem; display:flex; justify-content:center; }
  .pagination-wrap nav { display:flex; gap:5px; }
  .pagination-wrap span, .pagination-wrap a {
    display:flex; align-items:center; justify-content:center;
    width:32px; height:32px; border-radius:8px; font-size:12.5px;
    font-family:'DM Sans',sans-serif; border:0.5px solid rgba(26,25,22,0.12);
    background:#fff; color:#6B6A66; text-decoration:none; transition:background 0.12s;
  }
  .pagination-wrap a:hover { background:#F5F4F0; }
  .pagination-wrap [aria-current="page"] span { background:#1A1916 !important; color:#fff !important; border-color:#1A1916; }

  @media(max-width:540px) {
    .app-card { grid-template-columns:auto 1fr; }
    .action-form { grid-column:1/-1; flex-direction:row; }
  }
</style>

<div class="wrap">

  <a href="{{ route('employer.dashboard') }}" class="back-link">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
      <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    Back to dashboard
  </a>

  <div class="page-header">
    <h1>Applicants for <em>{{ $jobListing->title }}</em></h1>
    <p>{{ $applications->total() }} {{ Str::plural('application', $applications->total()) }} &middot; {{ $jobListing->company }}</p>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="app-list">
    @forelse($applications as $app)
      @php
        $initials   = strtoupper(substr($app->applicant->name, 0, 2));
        $badgeClass = match($app->status) {
          'accepted' => 'badge-accepted',
          'rejected' => 'badge-rejected',
          'reviewed' => 'badge-reviewed',
          default    => 'badge-pending',
        };
      @endphp

      <div class="app-card">

        {{-- Avatar --}}
        <div class="app-avatar">{{ $initials }}</div>

        {{-- Info --}}
        <div class="app-info">
          <div class="app-name">{{ $app->applicant->name }}</div>
          <div class="app-email">{{ $app->applicant->email }}</div>
          <div class="app-meta">
            <span class="badge {{ $badgeClass }}">{{ ucfirst($app->status) }}</span>
            <span class="app-date">Applied {{ $app->created_at->diffForHumans() }}</span>
            @if($app->resume_path)
              <a href="{{ Storage::url($app->resume_path) }}" target="_blank" class="resume-link">
                <svg width="11" height="11" viewBox="0 0 12 12" fill="none">
                  <path d="M2 2h5l3 3v5H2V2z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                  <path d="M7 2v3h3" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
                Resume
              </a>
            @endif
          </div>

          @if($app->cover_letter)
            <div style="margin-top:10px;">
              <div class="cover-label">Cover letter</div>
              <div class="cover-letter">{{ $app->cover_letter }}</div>
            </div>
          @endif
        </div>

        {{-- Status update --}}
        <form method="POST" action="{{ route('applications.status', $app) }}" class="action-form">
          @csrf @method('PATCH')
          <select name="status" class="status-select">
            @foreach(['pending','reviewed','accepted','rejected'] as $s)
              <option value="{{ $s }}" @selected($app->status === $s)>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
          <button type="submit" class="btn-update">Update</button>
        </form>

      </div>
    @empty
      <div class="empty-card">
        <h3>No applications yet</h3>
        <p>Applications will appear here once candidates apply.</p>
      </div>
    @endforelse
  </div>

  @if($applications->hasPages())
    <div class="pagination-wrap">
      {{ $applications->links() }}
    </div>
  @endif

</div>

@endsection