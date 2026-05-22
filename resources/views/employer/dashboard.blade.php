@extends('layouts.app')
@section('title', 'Employer Dashboard')
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .dash { font-family:'DM Sans',sans-serif; max-width:860px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }

  .topbar { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:2rem; gap:1rem; }
  .topbar h1 { font-family:'DM Serif Display',serif; font-size:28px; font-weight:400; letter-spacing:-0.5px; line-height:1; color:#1A1916; }
  .topbar h1 em { font-style:italic; color:#6B6A66; }
  .topbar .sub { font-size:13px; color:#A09E99; margin-top:5px; }
  .btn-post { display:inline-flex; align-items:center; gap:7px; background:#1A1916; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500; text-decoration:none; white-space:nowrap; transition:opacity 0.15s; }
  .btn-post:hover { opacity:0.82; color:#fff; }

  .stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:10px; margin-bottom:2rem; }
  .stat-card { background:#fff; border:0.5px solid rgba(26,25,22,0.10); border-radius:14px; padding:16px 18px; box-shadow:0 1px 3px rgba(26,25,22,0.05); }
  .stat-card .s-label { font-size:10.5px; font-weight:500; text-transform:uppercase; letter-spacing:0.09em; color:#A09E99; margin-bottom:8px; }
  .stat-card .s-value { font-family:'DM Serif Display',serif; font-size:32px; font-weight:400; color:#1A1916; line-height:1; }
  .stat-card .s-hint { font-size:11px; color:#C4C2BC; margin-top:4px; }

  .section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
  .section-label { font-size:10.5px; font-weight:500; text-transform:uppercase; letter-spacing:0.09em; color:#A09E99; }
  .filter-row { display:flex; gap:6px; }
  .filter-btn { font-size:12px; font-family:'DM Sans',sans-serif; padding:4px 12px; border-radius:20px; border:0.5px solid rgba(26,25,22,0.12); background:transparent; color:#6B6A66; text-decoration:none; transition:background 0.12s,color 0.12s; }
  .filter-btn:hover,.filter-btn.active { background:#1A1916; color:#fff; border-color:#1A1916; }

  .job-list { display:flex; flex-direction:column; gap:8px; }

  .job-card { background:#fff; border:0.5px solid rgba(26,25,22,0.10); border-radius:14px; padding:18px 20px; display:grid; grid-template-columns:1fr auto; gap:10px 20px; align-items:start; box-shadow:0 1px 3px rgba(26,25,22,0.05); transition:border-color 0.15s,box-shadow 0.15s; }
  .job-card:hover { border-color:rgba(26,25,22,0.20); box-shadow:0 2px 8px rgba(26,25,22,0.09); }
  .job-card.closed { opacity:0.55; }

  .job-header { display:flex; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px; }
  .job-title { font-size:15px; font-weight:500; color:#1A1916; }

  .badge { font-size:11px; font-weight:500; padding:2px 9px; border-radius:20px; white-space:nowrap; line-height:1.6; }
  .badge-open       { background:#EAF3DE; color:#3B6D11; }
  .badge-closed     { background:#EEEDE9; color:#5F5E5A; }
  .badge-fulltime   { background:#E6F1FB; color:#185FA5; }
  .badge-parttime   { background:#FAEEDA; color:#854F0B; }
  .badge-contract   { background:#EAF3DE; color:#3B6D11; }
  .badge-internship { background:#EEEDFE; color:#534AB7; }

  .job-meta { display:flex; flex-wrap:wrap; align-items:center; gap:10px; font-size:12.5px; color:#6B6A66; }
  .meta-item { display:flex; align-items:center; gap:4px; }
  .meta-sep { width:3px; height:3px; border-radius:50%; background:#C4C2BC; }
  .deadline-warn { font-size:11px; font-weight:500; background:#FAEEDA; color:#854F0B; padding:2px 8px; border-radius:20px; }

  .job-footer { display:flex; align-items:center; gap:16px; margin-top:12px; padding-top:12px; border-top:0.5px solid rgba(26,25,22,0.06); }
  .apps-num { font-family:'DM Serif Display',serif; font-size:22px; font-weight:400; line-height:1; color:#1A1916; }
  .apps-label { font-size:12px; color:#A09E99; }
  .apps-bar-wrap { flex:1; max-width:120px; height:4px; background:rgba(26,25,22,0.08); border-radius:2px; overflow:hidden; }
  .apps-bar { height:100%; background:#1A1916; border-radius:2px; }

  .job-actions { display:flex; flex-direction:column; align-items:flex-end; gap:6px; }
  .btn-applicants { font-size:12px; font-weight:500; font-family:'DM Sans',sans-serif; padding:7px 14px; border-radius:8px; cursor:pointer; background:#1A1916; color:#fff; border:none; text-decoration:none; white-space:nowrap; transition:opacity 0.15s; display:inline-flex; align-items:center; gap:5px; }
  .btn-applicants:hover { opacity:0.82; color:#fff; }
  .btn-edit { font-size:12px; font-weight:500; font-family:'DM Sans',sans-serif; padding:7px 14px; border-radius:8px; cursor:pointer; border:0.5px solid rgba(26,25,22,0.18); background:transparent; color:#6B6A66; text-decoration:none; transition:background 0.12s,color 0.12s; }
  .btn-edit:hover { background:#F5F4F0; color:#1A1916; }
  .btn-delete { font-size:12px; font-family:'DM Sans',sans-serif; padding:5px 10px; border-radius:8px; cursor:pointer; border:none; background:transparent; color:#C4C2BC; transition:background 0.12s,color 0.12s; }
  .btn-delete:hover { background:#FCEBEB; color:#A32D2D; }

  .alert-success { background:#EAF3DE; color:#3B6D11; border-radius:10px; padding:11px 16px; font-size:13px; margin-bottom:20px; }

  .empty-card { background:#fff; border:0.5px dashed rgba(26,25,22,0.15); border-radius:14px; padding:4rem 1rem; text-align:center; }
  .empty-card h3 { font-family:'DM Serif Display',serif; font-size:20px; font-weight:400; color:#1A1916; margin-bottom:6px; }
  .empty-card p { font-size:13px; color:#A09E99; margin-bottom:16px; }

  .pagination-wrap { margin-top:1.75rem; display:flex; justify-content:center; }
  .pagination-wrap nav { display:flex; gap:5px; }
  .pagination-wrap span, .pagination-wrap a { display:flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; font-size:12.5px; font-family:'DM Sans',sans-serif; border:0.5px solid rgba(26,25,22,0.12); background:#fff; color:#6B6A66; text-decoration:none; transition:background 0.12s; }
  .pagination-wrap a:hover { background:#F5F4F0; }
  .pagination-wrap [aria-current="page"] span { background:#1A1916 !important; color:#fff !important; border-color:#1A1916; }

  @media (max-width:540px) {
    .topbar { flex-direction:column; align-items:flex-start; }
    .stats-row { grid-template-columns:repeat(2,1fr); }
    .job-card { grid-template-columns:1fr; }
    .job-actions { flex-direction:row; flex-wrap:wrap; }
  }
</style>

@php
  $activeFilter = request('status', 'all');
  $totalJobs    = $jobs->total();
  $openJobs     = \App\Models\JobListing::where('user_id', auth()->id())->where('status','open')->count();
  $closedJobs   = \App\Models\JobListing::where('user_id', auth()->id())->where('status','closed')->count();
  $totalApps    = $jobs->sum('applications_count');
@endphp

<div class="dash">

  <div class="topbar">
    <div>
      <h1>Employer <em>Dashboard</em></h1>
      <p class="sub">{{ auth()->user()->name }} &mdash; manage your listings</p>
    </div>
    <a href="{{ route('jobs.create') }}" class="btn-post">
      <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
        <path d="M6.5 1v11M1 6.5h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
      Post a job
    </a>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <div class="stats-row">
    <div class="stat-card">
      <div class="s-label">Active listings</div>
      <div class="s-value">{{ $openJobs }}</div>
      <div class="s-hint">of {{ $totalJobs }} total</div>
    </div>
    <div class="stat-card">
      <div class="s-label">Total applications</div>
      <div class="s-value">{{ $totalApps }}</div>
      <div class="s-hint">across all jobs</div>
    </div>
    <div class="stat-card">
      <div class="s-label">Closing soon</div>
      <div class="s-value">
        {{ \App\Models\JobListing::where('user_id', auth()->id())->where('status','open')->whereBetween('deadline',[now(),now()->addDays(7)])->count() }}
      </div>
      <div class="s-hint">within 7 days</div>
    </div>
    <div class="stat-card">
      <div class="s-label">Closed listings</div>
      <div class="s-value">{{ $closedJobs }}</div>
      <div class="s-hint">this account</div>
    </div>
  </div>

  <div class="section-header">
    <span class="section-label">Your listings</span>
    <div class="filter-row">
      @foreach(['all'=>'All','open'=>'Open','closed'=>'Closed'] as $val=>$label)
        <a href="{{ request()->fullUrlWithQuery(['status'=>$val]) }}"
           class="filter-btn {{ $activeFilter===$val ? 'active' : '' }}">
          {{ $label }}
        </a>
      @endforeach
    </div>
  </div>

  <div class="job-list">
    @forelse($jobs as $job)
      @php
        $days = now()->diffInDays($job->deadline, false);
        $soon = $job->status==='open' && $days>=0 && $days<=7;
        $past = $days < 0;
        $typeClass = match($job->type) {
          'full-time'  => 'badge-fulltime',
          'part-time'  => 'badge-parttime',
          'contract'   => 'badge-contract',
          'internship' => 'badge-internship',
          default      => 'badge-fulltime',
        };
        $barPct = $job->applications_count > 0 ? min(100, round(($job->applications_count/20)*100)) : 0;
      @endphp

      <div class="job-card {{ $job->status==='closed' ? 'closed' : '' }}">
        <div>
          <div class="job-header">
            <span class="job-title">{{ $job->title }}</span>
            <span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span>
            <span class="badge {{ $typeClass }}">{{ ucfirst($job->type) }}</span>
            @if($soon)<span class="deadline-warn">Closing soon</span>@endif
          </div>

          <div class="job-meta">
            <span class="meta-item">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="5" r="2.2" stroke="currentColor" stroke-width="1.2"/>
                <path d="M6 11.5C6 11.5 1.5 7.8 1.5 5a4.5 4.5 0 019 0C10.5 7.8 6 11.5 6 11.5z" stroke="currentColor" stroke-width="1.2"/>
              </svg>
              {{ $job->location }}
            </span>
            <span class="meta-sep"></span>
            <span class="meta-item">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <rect x="1" y="2" width="10" height="9" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                <path d="M1 5h10M4 1v2M8 1v2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              {{ $past ? 'Expired' : 'Closes' }} {{ $job->deadline->format('M d, Y') }}
            </span>
          </div>

          <div class="job-footer">
            <span class="apps-num">{{ $job->applications_count }}</span>
            <span class="apps-label">{{ $job->applications_count===1 ? 'applicant' : 'applicants' }}</span>
            <div class="apps-bar-wrap">
              <div class="apps-bar" style="width:{{ $barPct }}%"></div>
            </div>
          </div>
        </div>

        <div class="job-actions">
          <a href="{{ route('jobs.applications', $job) }}" class="btn-applicants">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
              <circle cx="4.5" cy="3.5" r="2" stroke="currentColor" stroke-width="1.2"/>
              <path d="M1 10c0-2 1.6-3.5 3.5-3.5S8 8 8 10" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              <path d="M9 5v4M11 7H7" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            Applicants
            @if($job->applications_count > 0)
              <span style="background:rgba(255,255,255,0.2);padding:1px 6px;border-radius:10px;font-size:10px;">
                {{ $job->applications_count }}
              </span>
            @endif
          </a>

          <a href="{{ route('jobs.edit', $job) }}" class="btn-edit">Edit</a>

          <form method="POST" action="{{ route('jobs.destroy', $job) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete" onclick="return confirm('Delete this listing?')">Delete</button>
          </form>
        </div>
      </div>

    @empty
      <div class="empty-card">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" style="margin:0 auto 12px;display:block;opacity:0.25">
          <rect x="5" y="8" width="30" height="24" rx="3" stroke="#1A1916" stroke-width="1.5"/>
          <path d="M13 18h14M13 24h8" stroke="#1A1916" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        <h3>No listings yet</h3>
        <p>Post your first job to start receiving applications</p>
        <a href="{{ route('jobs.create') }}" class="btn-post" style="display:inline-flex;">
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path d="M6.5 1v11M1 6.5h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          Post a job
        </a>
      </div>
    @endforelse
  </div>

  @if($jobs->hasPages())
    <div class="pagination-wrap">
      {{ $jobs->appends(request()->query())->links() }}
    </div>
  @endif

</div>

@endsection