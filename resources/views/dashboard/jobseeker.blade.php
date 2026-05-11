@extends('layouts.app')
@section('title', 'My Applications')
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .apps-wrap {
    font-family: 'DM Sans', sans-serif;
    max-width: 860px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 4rem;
  }

  /* ── Header ── */
  .apps-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
  }
  .apps-header h1 {
    font-family: 'DM Serif Display', serif;
    font-size: 28px;
    font-weight: 400;
    letter-spacing: -0.5px;
    line-height: 1;
    color: #1A1916;
  }
  .apps-header h1 em { font-style: italic; color: #6B6A66; }
  .apps-header .sub { font-size: 13px; color: #A09E99; margin-top: 5px; }
  .btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #1A1916;
    color: #fff;
    border: none;
    padding: 9px 18px;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    white-space: nowrap;
    transition: opacity 0.15s;
  }
  .btn-browse:hover { opacity: 0.82; color: #fff; }

  /* ── Stats ── */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 10px;
    margin-bottom: 1.75rem;
  }
  .stat-card {
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 14px;
    padding: 16px 18px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.05);
  }
  .stat-card .s-label {
    font-size: 10.5px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.09em;
    color: #A09E99;
    margin-bottom: 8px;
  }
  .stat-card .s-value {
    font-family: 'DM Serif Display', serif;
    font-size: 32px;
    font-weight: 400;
    line-height: 1;
    color: #1A1916;
  }

  /* ── Filter tabs ── */
  .filter-tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
  }
  .filter-tab {
    font-size: 12px;
    font-family: 'DM Sans', sans-serif;
    padding: 5px 12px;
    border-radius: 20px;
    border: 0.5px solid rgba(26,25,22,0.12);
    background: transparent;
    color: #6B6A66;
    text-decoration: none;
    transition: background 0.12s, color 0.12s, border-color 0.12s;
  }
  .filter-tab:hover { background: #F5F4F0; color: #1A1916; }
  .filter-tab.active {
    background: #1A1916;
    color: #fff;
    border-color: #1A1916;
  }

  /* ── App cards ── */
  .app-list { display: flex; flex-direction: column; gap: 8px; }

  .app-card {
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.05);
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 14px;
    align-items: center;
    transition: border-color 0.15s, box-shadow 0.15s;
  }
  .app-card:hover {
    border-color: rgba(26,25,22,0.20);
    box-shadow: 0 2px 10px rgba(26,25,22,0.08);
  }

  .app-avatar {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #F5F4F0;
    border: 0.5px solid rgba(26,25,22,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 500;
    color: #1A1916;
    flex-shrink: 0;
    user-select: none;
  }

  .app-info { min-width: 0; }
  .app-top {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 5px;
    flex-wrap: wrap;
  }
  .app-title {
    font-size: 14.5px;
    font-weight: 500;
    color: #1A1916;
    text-decoration: none;
    transition: color 0.12s;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .app-title:hover { color: #185FA5; }

  .app-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    font-size: 12px;
    color: #A09E99;
  }
  .meta-item { display: flex; align-items: center; gap: 4px; }
  .meta-sep { width: 3px; height: 3px; border-radius: 50%; background: #C4C2BC; }

  /* ── Badges ── */
  .badge {
    font-size: 11px;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
    line-height: 1.6;
    flex-shrink: 0;
  }
  .badge-accepted { background: #EAF3DE; color: #3B6D11; }
  .badge-rejected { background: #FCEBEB; color: #A32D2D; }
  .badge-reviewed { background: #FAEEDA; color: #854F0B; }
  .badge-pending  { background: #EEEDE9; color: #5F5E5A; }

  /* ── Action ── */
  .btn-view {
    font-size: 12px;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    padding: 7px 14px;
    border-radius: 8px;
    border: 0.5px solid rgba(26,25,22,0.18);
    background: transparent;
    color: #6B6A66;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.12s, color 0.12s;
    flex-shrink: 0;
  }
  .btn-view:hover { background: #F5F4F0; color: #1A1916; }

  /* ── Empty state ── */
  .empty-card {
    background: #fff;
    border: 0.5px dashed rgba(26,25,22,0.15);
    border-radius: 14px;
    padding: 4rem 1rem;
    text-align: center;
  }
  .empty-icon {
    width: 48px; height: 48px;
    background: #F5F4F0; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
  }
  .empty-card h3 {
    font-family: 'DM Serif Display', serif;
    font-size: 19px; font-weight: 400;
    color: #1A1916; margin-bottom: 4px;
  }
  .empty-card p  { font-size: 13px; color: #A09E99; }
  .empty-card a  { font-size: 13px; color: #185FA5; text-decoration: none; display: inline-block; margin-top: 12px; }
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
  .pagination-wrap [aria-current="page"] span {
    background: #1A1916 !important; color: #fff !important; border-color: #1A1916;
  }

  @media (max-width: 540px) {
    .apps-header { flex-direction: column; align-items: flex-start; }
    .stats-grid  { grid-template-columns: repeat(2, 1fr); }
    .app-card    { grid-template-columns: auto 1fr; }
    .app-card .btn-view { display: none; }
  }
</style>

@php
  $counts = [
    'total'    => $applications->total(),
    'reviewed' => $applications->getCollection()->where('status', 'reviewed')->count(),
    'accepted' => $applications->getCollection()->where('status', 'accepted')->count(),
    'rejected' => $applications->getCollection()->where('status', 'rejected')->count(),
  ];
  $activeStatus = request('status', 'all');
@endphp

<div class="apps-wrap">

  {{-- Header --}}
  <div class="apps-header">
    <div>
      <h1>My <em>Applications</em></h1>
      <p class="sub">Track your career journey</p>
    </div>
    <a href="{{ route('home') }}" class="btn-browse">
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
        <path d="M6 1v10M1 6h10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
      Find jobs
    </a>
  </div>

  {{-- Stats --}}
  <div class="stats-grid">
    <div class="stat-card">
      <div class="s-label">Total</div>
      <div class="s-value">{{ $counts['total'] }}</div>
    </div>
    <div class="stat-card">
      <div class="s-label">In review</div>
      <div class="s-value">{{ $counts['reviewed'] }}</div>
    </div>
    <div class="stat-card">
      <div class="s-label">Accepted</div>
      <div class="s-value">{{ $counts['accepted'] }}</div>
    </div>
    <div class="stat-card">
      <div class="s-label">Rejected</div>
      <div class="s-value">{{ $counts['rejected'] }}</div>
    </div>
  </div>

  {{-- Filter tabs --}}
  <div class="filter-tabs">
    @foreach(['all' => 'All', 'pending' => 'Pending', 'reviewed' => 'Reviewed', 'accepted' => 'Accepted', 'rejected' => 'Rejected'] as $val => $label)
      <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
         class="filter-tab {{ $activeStatus === $val ? 'active' : '' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  {{-- Application cards --}}
  <div class="app-list">
    @forelse($applications as $app)
      @php
        $initials = strtoupper(substr($app->jobListing->company, 0, 2));
        $badgeClass = match($app->status) {
          'accepted' => 'badge-accepted',
          'rejected' => 'badge-rejected',
          'reviewed' => 'badge-reviewed',
          default    => 'badge-pending',
        };
      @endphp

      <div class="app-card">
        <div class="app-avatar">{{ $initials }}</div>

        <div class="app-info">
          <div class="app-top">
            <a href="{{ route('jobs.show', $app->jobListing) }}" class="app-title">
              {{ $app->jobListing->title }}
            </a>
            <span class="badge {{ $badgeClass }}">{{ ucfirst($app->status) }}</span>
          </div>
          <div class="app-meta">
            <span class="meta-item">
              <svg width="11" height="11" viewBox="0 0 12 12" fill="none">
                <rect x="1" y="2" width="10" height="9" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                <path d="M4 1v2M8 1v2M1 5h10" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              {{ $app->jobListing->company }}
            </span>
            <span class="meta-sep"></span>
            <span class="meta-item">
              <svg width="11" height="11" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="5" r="2.2" stroke="currentColor" stroke-width="1.2"/>
                <path d="M6 11.5C6 11.5 1.5 7.8 1.5 5a4.5 4.5 0 019 0C10.5 7.8 6 11.5 6 11.5z" stroke="currentColor" stroke-width="1.2"/>
              </svg>
              {{ $app->jobListing->location }}
            </span>
            <span class="meta-sep"></span>
            <span class="meta-item">
              <svg width="11" height="11" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="6" r="4.5" stroke="currentColor" stroke-width="1.2"/>
                <path d="M6 3.5v2.8l1.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              {{ $app->created_at->diffForHumans() }}
            </span>
          </div>
        </div>

        <a href="{{ route('jobs.show', $app->jobListing) }}" class="btn-view">View</a>
      </div>

    @empty
      <div class="empty-card">
        <div class="empty-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C4C2BC" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
          </svg>
        </div>
        <h3>No applications yet</h3>
        <p>Your dream job is just a search away</p>
        <a href="{{ route('home') }}">Browse listings &rarr;</a>
      </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  <div class="pagination-wrap">
    {{ $applications->appends(request()->query())->links() }}
  </div>

</div>

@endsection