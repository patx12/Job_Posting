@extends('layouts.app')
@section('title', $jobListing->title)
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .show-wrap {
    font-family: 'DM Sans', sans-serif;
    max-width: 700px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 4rem;
  }

  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #6B6A66;
    text-decoration: none;
    margin-bottom: 1.5rem;
    transition: color 0.12s;
  }
  .back-link:hover { color: #1A1916; }

  .show-card {
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 16px;
    padding: 28px 28px 24px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.05);
    margin-bottom: 12px;
  }

  /* ── Job header ── */
  .job-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 16px;
  }
  .job-avatar {
    width: 52px; height: 52px;
    border-radius: 12px;
    background: #F5F4F0;
    border: 0.5px solid rgba(26,25,22,0.08);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 500; color: #1A1916;
    flex-shrink: 0; user-select: none;
  }
  .job-title-block { flex: 1; min-width: 0; }
  .job-title {
    font-family: 'DM Serif Display', serif;
    font-size: 24px; font-weight: 400;
    letter-spacing: -0.4px; color: #1A1916; line-height: 1.15;
  }
  .job-company { font-size: 13px; color: #A09E99; margin-top: 4px; }
  .job-company .sep { margin: 0 6px; opacity: 0.4; }

  .type-badge {
    font-size: 11px; font-weight: 500;
    padding: 3px 10px; border-radius: 20px;
    white-space: nowrap; line-height: 1.6; flex-shrink: 0;
  }
  .type-full-time  { background: #E6F1FB; color: #185FA5; }
  .type-part-time  { background: #FAEEDA; color: #854F0B; }
  .type-contract   { background: #EAF3DE; color: #3B6D11; }
  .type-internship { background: #EEEDFE; color: #534AB7; }

  /* ── Meta row ── */
  .meta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 0.5px solid rgba(26,25,22,0.07);
  }
  .meta-chip {
    display: flex; align-items: center; gap: 5px;
    font-size: 12.5px; color: #6B6A66;
  }

  .salary-badge {
    font-size: 12px; font-weight: 500;
    background: #EAF3DE; color: #3B6D11;
    padding: 4px 12px; border-radius: 20px;
    display: inline-block; margin-bottom: 16px;
  }

  /* ── Sections ── */
  .content-section { margin-bottom: 22px; }
  .content-section h2 {
    font-size: 10.5px; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: #A09E99; margin-bottom: 10px;
  }
  .content-section p {
    font-size: 14px; color: #4A4946;
    line-height: 1.75; white-space: pre-line;
  }

  .section-divider { border: none; border-top: 0.5px solid rgba(26,25,22,0.07); margin: 20px 0; }

  .deadline-row {
    font-size: 12.5px; color: #A09E99;
    display: flex; align-items: center; gap: 6px;
  }
  .deadline-row strong { color: #1A1916; font-weight: 500; }

  /* ── Apply card ── */
  .apply-card {
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 16px;
    padding: 24px 28px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.05);
  }
  .apply-card h2 {
    font-family: 'DM Serif Display', serif;
    font-size: 20px; font-weight: 400;
    color: #1A1916; margin-bottom: 4px;
  }
  .apply-card .apply-sub { font-size: 13px; color: #A09E99; margin-bottom: 20px; }

  .field { margin-bottom: 16px; }
  .field label {
    display: block; font-size: 11px; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: #6B6A66; margin-bottom: 6px;
  }
  .field textarea,
  .field input[type="file"] {
    width: 100%; padding: 10px 13px;
    border: 0.5px solid rgba(26,25,22,0.18); border-radius: 8px;
    font-family: 'DM Sans', sans-serif; font-size: 14px;
    color: #1A1916; background: #F9F8F5; outline: none;
    transition: border-color 0.12s, background 0.12s;
    box-sizing: border-box;
  }
  .field textarea:focus { border-color: #1A1916; background: #fff; }
  .field textarea { resize: vertical; min-height: 120px; line-height: 1.6; }
  .field input[type="file"] { cursor: pointer; font-size: 13px; }

  .btn-submit {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 24px; background: #1A1916; color: #fff;
    border: none; border-radius: 8px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
    cursor: pointer; transition: opacity 0.15s;
  }
  .btn-submit:hover { opacity: 0.82; }

  .btn-login {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 24px; background: #1A1916; color: #fff;
    border-radius: 8px; text-decoration: none;
    font-size: 13px; font-weight: 500; transition: opacity 0.15s;
  }
  .btn-login:hover { opacity: 0.82; color: #fff; }

  /* ── Alert banners ── */
  .alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 14px 16px; border-radius: 10px; font-size: 13px;
  }
  .alert-success { background: #EAF3DE; color: #3B6D11; }
  .alert-danger  { background: #FCEBEB; color: #A32D2D; }
  .alert-info    { background: #E6F1FB; color: #185FA5; }

  @media (max-width: 540px) {
    .job-header { flex-direction: column; }
    .show-card, .apply-card { padding: 20px 16px; }
  }
</style>

<div class="show-wrap">

  <a href="{{ route('home') }}" class="back-link">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
      <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    Back to jobs
  </a>

  {{-- Main job card --}}
  <div class="show-card">

    {{-- Header --}}
    <div class="job-header">
      <div style="display:flex;align-items:flex-start;gap:14px;flex:1;min-width:0;">
        <div class="job-avatar">{{ strtoupper(substr($jobListing->company, 0, 2)) }}</div>
        <div class="job-title-block">
          <h1 class="job-title">{{ $jobListing->title }}</h1>
          <p class="job-company">
            {{ $jobListing->company }}
            <span class="sep">·</span>
            {{ $jobListing->location }}
          </p>
        </div>
      </div>
      @php
        $typeClass = match($jobListing->type) {
          'full-time'  => 'type-full-time',
          'part-time'  => 'type-part-time',
          'contract'   => 'type-contract',
          'internship' => 'type-internship',
          default      => 'type-full-time',
        };
      @endphp
      <span class="type-badge {{ $typeClass }}">{{ ucfirst($jobListing->type) }}</span>
    </div>

    {{-- Meta row --}}
    <div class="meta-row">
      <span class="meta-chip">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
          <circle cx="6" cy="5" r="2.2" stroke="currentColor" stroke-width="1.2"/>
          <path d="M6 11.5C6 11.5 1.5 7.8 1.5 5a4.5 4.5 0 019 0C10.5 7.8 6 11.5 6 11.5z" stroke="currentColor" stroke-width="1.2"/>
        </svg>
        {{ $jobListing->location }}
      </span>
      <span class="meta-chip">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
          <rect x="1" y="2" width="10" height="9" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
          <path d="M1 5h10M4 1v2M8 1v2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        Deadline: {{ $jobListing->deadline->format('M d, Y') }}
      </span>
      <span class="meta-chip">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
          <circle cx="6" cy="6" r="4.5" stroke="currentColor" stroke-width="1.2"/>
          <path d="M6 3.5v2.8l1.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        {{ $jobListing->status === 'open' ? 'Accepting applications' : 'Closed' }}
      </span>
    </div>

    {{-- Salary --}}
    @if($jobListing->salary_min)
      <div class="salary-badge">
        ₱{{ number_format($jobListing->salary_min) }} – ₱{{ number_format($jobListing->salary_max) }} / month
      </div>
    @endif

    {{-- Description --}}
    <div class="content-section">
      <h2>Job description</h2>
      <p>{{ $jobListing->description }}</p>
    </div>

    {{-- Requirements --}}
    @if($jobListing->requirements)
      <div class="content-section">
        <h2>Requirements</h2>
        <p>{{ $jobListing->requirements }}</p>
      </div>
    @endif

  </div>

  {{-- Apply section --}}
  @auth
    @if(auth()->user()->isJobSeeker())

      @if($hasApplied)
        <div class="apply-card">
          <div class="alert alert-success">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;margin-top:1px">
              <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.3"/>
              <path d="M5 8l2 2 4-4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            You have already applied for this position. We'll notify you of any updates.
          </div>
        </div>

      @elseif($jobListing->status === 'open')
        <div class="apply-card">
          <h2>Apply for this job</h2>
          <p class="apply-sub">Your application will be sent directly to the employer.</p>

          <form method="POST" action="{{ route('applications.store', $jobListing) }}"
                enctype="multipart/form-data">
            @csrf

            <div class="field">
              <label>Cover letter <span style="color:#C4C2BC;text-transform:none;font-size:10px;letter-spacing:0;font-weight:400"> — optional</span></label>
              <textarea name="cover_letter"
                        placeholder="Tell the employer why you're a great fit..."></textarea>
            </div>

            <div class="field">
              <label>Resume <span style="color:#C4C2BC;text-transform:none;font-size:10px;letter-spacing:0;font-weight:400"> — PDF or DOC, optional</span></label>
              <input type="file" name="resume" accept=".pdf,.doc,.docx" />
            </div>

            <button type="submit" class="btn-submit">
              <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path d="M1 6.5h11M7 1.5l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Submit application
            </button>
          </form>
        </div>

      @else
        <div class="apply-card">
          <div class="alert alert-danger">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;margin-top:1px">
              <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.3"/>
              <path d="M8 5v3M8 10.5v.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
            </svg>
            This job is no longer accepting applications.
          </div>
        </div>
      @endif

    @endif
  @else
    <div class="apply-card">
      <h2>Interested in this role?</h2>
      <p class="apply-sub">Sign in to submit your application.</p>
      <a href="{{ route('login') }}" class="btn-login">
        Sign in to apply
      </a>
    </div>
  @endauth

</div>

@endsection