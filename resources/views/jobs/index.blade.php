@extends('layouts.app')
@section('title', 'Browse Jobs')
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .browse-wrap { font-family: 'DM Sans', sans-serif; max-width: 860px; margin: 0 auto; padding: 2.5rem 1.5rem 4rem; }

  /* ── Header ── */
  .browse-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; margin-bottom: 2rem; }
  .browse-header h1 { font-family: 'DM Serif Display', serif; font-size: 28px; font-weight: 400; letter-spacing: -0.5px; line-height: 1; }
  .browse-header h1 em { font-style: italic; color: #6B6A66; }
  .browse-header .sub { font-size: 13px; color: #6B6A66; margin-top: 5px; }
  .browse-header .sub strong { color: #1A1916; font-weight: 500; }
  .btn-post-job {
    display: inline-flex; align-items: center; gap: 6px;
    background: #1A1916; color: #fff; border: none;
    padding: 9px 18px; border-radius: 8px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
    text-decoration: none; white-space: nowrap; transition: opacity 0.15s;
  }
  .btn-post-job:hover { opacity: 0.82; color: #fff; }

  /* ── Search form ── */
  .search-card {
    background: #fff; border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 14px; padding: 16px 18px;
    margin-bottom: 12px;
    display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
    box-shadow: 0 1px 3px rgba(26,25,22,0.05);
  }
  .search-input {
    flex: 1; min-width: 200px;
    border: 0.5px solid rgba(26,25,22,0.15); border-radius: 8px;
    padding: 9px 13px; font-size: 13px; font-family: 'DM Sans', sans-serif;
    background: #F9F8F5; color: #1A1916; outline: none;
    transition: border-color 0.12s;
  }
  .search-input::placeholder { color: #A09E99; }
  .search-input:focus { border-color: #1A1916; background: #fff; }
  .search-select {
    border: 0.5px solid rgba(26,25,22,0.15); border-radius: 8px;
    padding: 9px 13px; font-size: 13px; font-family: 'DM Sans', sans-serif;
    background: #F9F8F5; color: #6B6A66; outline: none; cursor: pointer;
    appearance: none; transition: border-color 0.12s;
  }
  .search-select:focus { border-color: #1A1916; }
  .btn-search {
    background: #1A1916; color: #fff; border: none;
    padding: 9px 20px; border-radius: 8px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
    cursor: pointer; transition: opacity 0.15s;
  }
  .btn-search:hover { opacity: 0.82; }
  .btn-clear {
    font-size: 13px; color: #6B6A66;
    border: 0.5px solid rgba(26,25,22,0.15); padding: 9px 16px; border-radius: 8px;
    background: transparent; text-decoration: none; transition: background 0.12s;
  }
  .btn-clear:hover { background: #F5F4F0; color: #1A1916; }

  /* ── Results meta ── */
  .results-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
  .results-meta p { font-size: 12.5px; color: #A09E99; }
  .results-meta strong { color: #1A1916; font-weight: 500; }
  .sort-select {
    font-size: 12px; border: 0.5px solid rgba(26,25,22,0.12);
    border-radius: 8px; padding: 5px 11px;
    color: #6B6A66; background: #fff; font-family: 'DM Sans', sans-serif;
    outline: none; cursor: pointer;
  }

  /* ── Job list ── */
  .job-list { display: flex; flex-direction: column; gap: 8px; }

  .job-card {
    background: #fff; border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 14px; padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.05);
    transition: border-color 0.15s, box-shadow 0.15s;
    text-decoration: none; display: block; color: inherit;
  }
  .job-card:hover {
    border-color: rgba(26,25,22,0.20);
    box-shadow: 0 2px 10px rgba(26,25,22,0.08);
  }

  .job-top { display: flex; align-items: flex-start; gap: 12px; }

  .job-avatar {
    width: 44px; height: 44px; border-radius: 10px;
    border: 0.5px solid rgba(26,25,22,0.10);
    background: #F5F4F0; display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 500; color: #1A1916;
    flex-shrink: 0; user-select: none; font-family: 'DM Sans', sans-serif;
  }

  .job-info { flex: 1; min-width: 0; }
  .job-title-link {
    font-size: 14.5px; font-weight: 500; color: #1A1916;
    text-decoration: none; display: block;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    transition: color 0.12s;
  }
  .job-title-link:hover { color: #185FA5; }
  .job-company { font-size: 12px; color: #A09E99; margin-top: 2px; }
  .job-company .sep { margin: 0 5px; opacity: 0.4; }

  .type-badge {
    font-size: 11px; font-weight: 500;
    padding: 3px 10px; border-radius: 20px;
    white-space: nowrap; flex-shrink: 0; line-height: 1.6;
  }
  .type-full-time  { background: #E6F1FB; color: #185FA5; }
  .type-part-time  { background: #FAEEDA; color: #854F0B; }
  .type-contract   { background: #EAF3DE; color: #3B6D11; }
  .type-internship { background: #EEEDFE; color: #534AB7; }
  .type-default    { background: #EEEDE9; color: #5F5E5A; }

  .job-desc {
    font-size: 12.5px; color: #A09E99; line-height: 1.65;
    margin-top: 12px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  }

  .job-footer {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: 14px; padding-top: 12px;
    border-top: 0.5px solid rgba(26,25,22,0.06);
    flex-wrap: wrap; gap: 8px;
  }

  .job-tags { display: flex; gap: 6px; flex-wrap: wrap; }
  .tag {
    font-size: 11px; color: #6B6A66;
    background: #F5F4F0; border: 0.5px solid rgba(26,25,22,0.08);
    padding: 3px 10px; border-radius: 20px;
  }

  .job-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
  .salary-badge {
    font-size: 11.5px; font-weight: 500;
    background: #EAF3DE; color: #3B6D11;
    padding: 3px 10px; border-radius: 20px;
  }
  .deadline { font-size: 11.5px; color: #C4C2BC; }

  /* ── Empty state ── */
  .empty-card {
    background: #fff; border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 14px; padding: 4rem 1rem; text-align: center;
  }
  .empty-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: #F5F4F0; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
  }
  .empty-card h3 { font-family: 'DM Serif Display', serif; font-size: 19px; font-weight: 400; color: #1A1916; margin-bottom: 4px; }
  .empty-card p  { font-size: 13px; color: #A09E99; }
  .empty-card a  { font-size: 13px; color: #185FA5; text-decoration: none; display: inline-block; margin-top: 10px; }
  .empty-card a:hover { text-decoration: underline; }

  /* ── Pagination ── */
  .pagination-wrap { margin-top: 1.75rem; display: flex; justify-content: center; }
  .pagination-wrap nav { display: flex; gap: 5px; }
  .pagination-wrap span,
  .pagination-wrap a {
    display: flex; align-items: center; justify-content: center;
    width: 32px; height: 32px; border-radius: 8px;
    font-size: 12.5px; font-family: 'DM Sans', sans-serif;
    border: 0.5px solid rgba(26,25,22,0.12);
    background: #fff; color: #6B6A66; text-decoration: none;
    transition: background 0.12s;
  }
  .pagination-wrap a:hover { background: #F5F4F0; color: #1A1916; }
  .pagination-wrap [aria-current="page"] span,
  .pagination-wrap span[aria-current="page"] {
    background: #1A1916 !important; color: #fff !important; border-color: #1A1916;
  }

  @media (max-width: 540px) {
    .browse-header { flex-direction: column; align-items: flex-start; }
    .search-card   { flex-direction: column; }
    .search-input  { min-width: unset; width: 100%; }
  }
</style>

<div class="browse-wrap">

  {{-- Header --}}
  <div class="browse-header">
    <div>
      <h1>Browse <em>Jobs</em></h1>
      <p class="sub">
        Find your next opportunity
        <span style="margin:0 6px;opacity:.35">·</span>
        <strong>{{ $jobs->total() }}</strong> openings
      </p>
    </div>
    @auth
      @if(auth()->user()->isEmployer())
        <a href="{{ route('jobs.create') }}" class="btn-post-job">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M6 1v10M1 6h10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          Post a job
        </a>
      @endif
    @endauth
  </div>

  {{-- Search bar --}}
  <form method="GET" class="search-card">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search title, company, or location..."
           class="search-input">
    <select name="type" class="search-select">
      <option value="">All types</option>
      @foreach(['full-time','part-time','contract','internship'] as $t)
        <option value="{{ $t }}" @selected(request('type') == $t)>{{ ucfirst($t) }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn-search">Search</button>
    <a href="{{ route('home') }}" class="btn-clear">Clear</a>
  </form>

  {{-- Results meta --}}
  <div class="results-meta">
    <p>Showing <strong>{{ $jobs->count() }}</strong> of {{ $jobs->total() }} results</p>
    <select class="sort-select">
      <option>Newest first</option>
      <option>Salary: High to low</option>
      <option>Deadline: Soonest</option>
    </select>
  </div>

  {{-- Job cards --}}
  <div class="job-list">
    @forelse($jobs as $job)
      @php
        $initials  = strtoupper(substr($job->company ?? $job->title, 0, 2));
        $typeClass = match($job->type) {
          'full-time'  => 'type-full-time',
          'part-time'  => 'type-part-time',
          'contract'   => 'type-contract',
          'internship' => 'type-internship',
          default      => 'type-default',
        };
      @endphp

      <a href="{{ route('jobs.show', $job) }}" class="job-card">

        <div class="job-top">
          <div class="job-avatar">{{ $initials }}</div>
          <div class="job-info">
            <span class="job-title-link">{{ $job->title }}</span>
            <p class="job-company">
              {{ $job->company }}
              <span class="sep">·</span>
              {{ $job->location }}
            </p>
          </div>
          <span class="type-badge {{ $typeClass }}">{{ ucfirst($job->type) }}</span>
        </div>

        <p class="job-desc">{{ Str::limit($job->description, 150) }}</p>

        <div class="job-footer">
          <div class="job-tags">
            <span class="tag">{{ $job->location }}</span>
          </div>
          <div class="job-right">
            @if($job->salary_min)
              <span class="salary-badge">
                ₱{{ number_format($job->salary_min) }} – ₱{{ number_format($job->salary_max) }}
              </span>
            @endif
            <span class="deadline">Due {{ $job->deadline->format('M d') }}</span>
          </div>
        </div>

      </a>
    @empty
      <div class="empty-card">
        <div class="empty-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C4C2BC" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
          </svg>
        </div>
        <h3>No jobs found</h3>
        <p>Try adjusting your search or filters</p>
        <a href="{{ route('home') }}">Clear filters</a>
      </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  <div class="pagination-wrap">
    {{ $jobs->appends(request()->query())->links() }}
  </div>

</div>

@endsection