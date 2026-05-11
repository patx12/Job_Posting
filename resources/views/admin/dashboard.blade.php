@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');
  .admin-wrap { font-family:'DM Sans',sans-serif; max-width:900px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }
  .admin-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:2rem; gap:1rem; flex-wrap:wrap; }
  .admin-header h1 { font-family:'DM Serif Display',serif; font-size:28px; font-weight:400; letter-spacing:-0.5px; color:#1A1916; line-height:1; }
  .admin-header h1 em { font-style:italic; color:#6B6A66; }
  .admin-header p { font-size:13px; color:#A09E99; margin-top:5px; }
  .admin-nav { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:2rem; }
  .admin-nav a { font-size:12.5px; color:#6B6A66; text-decoration:none; padding:7px 14px; border:0.5px solid rgba(26,25,22,0.12); border-radius:8px; background:#fff; transition:background 0.12s,color 0.12s; }
  .admin-nav a:hover, .admin-nav a.active { background:#1A1916; color:#fff; border-color:#1A1916; }
  .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:10px; margin-bottom:2rem; }
  .stat-card { background:#fff; border:0.5px solid rgba(26,25,22,0.10); border-radius:14px; padding:16px 18px; box-shadow:0 1px 3px rgba(26,25,22,0.05); }
  .stat-card .s-label { font-size:10.5px; font-weight:500; text-transform:uppercase; letter-spacing:0.09em; color:#A09E99; margin-bottom:8px; }
  .stat-card .s-value { font-family:'DM Serif Display',serif; font-size:32px; font-weight:400; color:#1A1916; line-height:1; }
  .stat-card .s-hint { font-size:11px; color:#C4C2BC; margin-top:4px; }
  .panel { background:#fff; border:0.5px solid rgba(26,25,22,0.10); border-radius:14px; padding:20px 22px; box-shadow:0 1px 3px rgba(26,25,22,0.05); margin-bottom:12px; }
  .panel-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:12px; border-bottom:0.5px solid rgba(26,25,22,0.07); }
  .panel-title { font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:0.09em; color:#A09E99; }
  .panel-link { font-size:12px; color:#185FA5; text-decoration:none; }
  .panel-link:hover { text-decoration:underline; }
  .row-item { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:11px 0; border-bottom:0.5px solid rgba(26,25,22,0.05); }
  .row-item:last-child { border-bottom:none; }
  .row-avatar { width:36px; height:36px; border-radius:9px; background:#F5F4F0; border:0.5px solid rgba(26,25,22,0.08); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:500; color:#1A1916; flex-shrink:0; }
  .row-main { flex:1; min-width:0; }
  .row-title { font-size:13.5px; font-weight:500; color:#1A1916; text-decoration:none; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; transition:color 0.12s; }
  .row-title:hover { color:#185FA5; }
  .row-sub { font-size:11.5px; color:#A09E99; margin-top:2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .badge { font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px; white-space:nowrap; line-height:1.6; flex-shrink:0; }
  .badge-open { background:#EAF3DE; color:#3B6D11; }
  .badge-closed { background:#EEEDE9; color:#5F5E5A; }
  .badge-accepted { background:#EAF3DE; color:#3B6D11; }
  .badge-rejected { background:#FCEBEB; color:#A32D2D; }
  .badge-reviewed { background:#FAEEDA; color:#854F0B; }
  .badge-pending { background:#EEEDE9; color:#5F5E5A; }
</style>

<div class="admin-wrap">
  <div class="admin-header">
    <div>
      <h1>Admin <em>Dashboard</em></h1>
      <p>Platform overview</p>
    </div>
  </div>

  <div class="admin-nav">
    <a href="{{ route('admin.dashboard') }}" class="active">Overview</a>
    <a href="{{ route('admin.jobs') }}">All Jobs</a>
    <a href="{{ route('admin.users') }}">All Users</a>
    <a href="{{ route('admin.applications') }}">All Applications</a>
  </div>

  <div class="stats-grid">
    <div class="stat-card"><div class="s-label">Total jobs</div><div class="s-value">{{ $stats['total_jobs'] }}</div><div class="s-hint">all listings</div></div>
    <div class="stat-card"><div class="s-label">Open jobs</div><div class="s-value">{{ $stats['open_jobs'] }}</div><div class="s-hint">actively hiring</div></div>
    <div class="stat-card"><div class="s-label">Total users</div><div class="s-value">{{ $stats['total_users'] }}</div><div class="s-hint">registered</div></div>
    <div class="stat-card"><div class="s-label">Applications</div><div class="s-value">{{ $stats['total_apps'] }}</div><div class="s-hint">submitted</div></div>
  </div>

  <div class="panel">
    <div class="panel-header">
      <span class="panel-title">Recent job listings</span>
      <a href="{{ route('admin.jobs') }}" class="panel-link">View all →</a>
    </div>
    @foreach($recentJobs as $job)
      @php $initials = strtoupper(substr($job->company ?? $job->title, 0, 2)); @endphp
      <div class="row-item">
        <div class="row-avatar">{{ $initials }}</div>
        <div class="row-main">
          <a href="{{ route('jobs.show', $job) }}" class="row-title">{{ $job->title }}</a>
          <p class="row-sub">{{ $job->company }} · by {{ $job->employer->name }}</p>
        </div>
        <span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span>
      </div>
    @endforeach
  </div>

  <div class="panel">
    <div class="panel-header">
      <span class="panel-title">Recent applications</span>
      <a href="{{ route('admin.applications') }}" class="panel-link">View all →</a>
    </div>
    @foreach($recentApps as $app)
      @php $initials = strtoupper(substr($app->applicant->name, 0, 2)); @endphp
      <div class="row-item">
        <div class="row-avatar">{{ $initials }}</div>
        <div class="row-main">
          <span class="row-title" style="cursor:default">{{ $app->applicant->name }}</span>
          <p class="row-sub">applied for {{ $app->jobListing->title }}</p>
        </div>
        @php $bc = match($app->status) { 'accepted'=>'badge-accepted','rejected'=>'badge-rejected','reviewed'=>'badge-reviewed',default=>'badge-pending' }; @endphp
        <span class="badge {{ $bc }}">{{ ucfirst($app->status) }}</span>
      </div>
    @endforeach
  </div>
</div>
@endsection