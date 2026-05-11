@extends('layouts.app')
@section('title', 'Manage Applications')
@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');
  .admin-wrap { font-family:'DM Sans',sans-serif; max-width:960px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }
  .page-header { margin-bottom:1.5rem; }
  .page-header h1 { font-family:'DM Serif Display',serif; font-size:26px; font-weight:400; letter-spacing:-0.4px; color:#1A1916; line-height:1; }
  .page-header h1 em { font-style:italic; color:#6B6A66; }
  .admin-nav { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:1.5rem; }
  .admin-nav a { font-size:12.5px; color:#6B6A66; text-decoration:none; padding:7px 14px; border:0.5px solid rgba(26,25,22,0.12); border-radius:8px; background:#fff; transition:background 0.12s,color 0.12s; }
  .admin-nav a:hover, .admin-nav a.active { background:#1A1916; color:#fff; border-color:#1A1916; }
  .search-bar { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:1.25rem; }
  .search-bar input, .search-bar select { padding:9px 13px; border:0.5px solid rgba(26,25,22,0.18); border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1916; background:#F9F8F5; outline:none; appearance:none; }
  .search-bar input { flex:1; min-width:200px; }
  .search-bar input:focus, .search-bar select:focus { border-color:#1A1916; background:#fff; }
  .btn-search { padding:9px 18px; background:#1A1916; color:#fff; border:none; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500; cursor:pointer; }
  .btn-clear { font-size:13px; color:#6B6A66; text-decoration:none; padding:9px 14px; border:0.5px solid rgba(26,25,22,0.15); border-radius:8px; }
  .btn-clear:hover { background:#F5F4F0; }
  .table-card { background:#fff; border:0.5px solid rgba(26,25,22,0.10); border-radius:14px; overflow:hidden; box-shadow:0 1px 3px rgba(26,25,22,0.05); }
  table { width:100%; border-collapse:collapse; }
  thead th { font-size:10.5px; font-weight:500; text-transform:uppercase; letter-spacing:0.09em; color:#A09E99; padding:12px 16px; text-align:left; border-bottom:0.5px solid rgba(26,25,22,0.08); background:#FAFAF8; }
  tbody td { font-size:13px; color:#1A1916; padding:13px 16px; border-bottom:0.5px solid rgba(26,25,22,0.05); vertical-align:middle; }
  tbody tr:last-child td { border-bottom:none; }
  tbody tr:hover td { background:#FAFAF8; }
  .sub-text { font-size:11.5px; color:#A09E99; margin-top:2px; }
  .badge { font-size:11px; font-weight:500; padding:3px 9px; border-radius:20px; white-space:nowrap; line-height:1.6; }
  .badge-accepted { background:#EAF3DE; color:#3B6D11; }
  .badge-rejected { background:#FCEBEB; color:#A32D2D; }
  .badge-reviewed { background:#FAEEDA; color:#854F0B; }
  .badge-pending  { background:#EEEDE9; color:#5F5E5A; }
  .btn-del { font-size:11.5px; padding:5px 10px; border-radius:6px; border:none; background:transparent; color:#C4C2BC; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background 0.12s,color 0.12s; }
  .btn-del:hover { background:#FCEBEB; color:#A32D2D; }
  .alert-success { background:#EAF3DE; color:#3B6D11; border-radius:10px; padding:11px 16px; font-size:13px; margin-bottom:16px; }
  .pagination-wrap { margin-top:1.5rem; display:flex; justify-content:center; }
  .pagination-wrap nav { display:flex; gap:5px; }
  .pagination-wrap span, .pagination-wrap a { display:flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; font-size:12.5px; font-family:'DM Sans',sans-serif; border:0.5px solid rgba(26,25,22,0.12); background:#fff; color:#6B6A66; text-decoration:none; }
  .pagination-wrap a:hover { background:#F5F4F0; }
  .pagination-wrap [aria-current="page"] span { background:#1A1916 !important; color:#fff !important; border-color:#1A1916; }
</style>

<div class="admin-wrap">
  <div class="page-header">
    <h1>Manage <em>Applications</em></h1>
  </div>

  <div class="admin-nav">
    <a href="{{ route('admin.dashboard') }}">Overview</a>
    <a href="{{ route('admin.jobs') }}">All Jobs</a>
    <a href="{{ route('admin.users') }}">All Users</a>
    <a href="{{ route('admin.applications') }}" class="active">All Applications</a>
  </div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <form method="GET" class="search-bar">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search applicant name..." />
    <select name="status">
      <option value="">All statuses</option>
      @foreach(['pending','reviewed','accepted','rejected'] as $s)
        <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn-search">Search</button>
    <a href="{{ route('admin.applications') }}" class="btn-clear">Clear</a>
  </form>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>Applicant</th>
          <th>Job</th>
          <th>Status</th>
          <th>Applied</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($applications as $app)
          @php
            $bc = match($app->status) {
              'accepted' => 'badge-accepted',
              'rejected' => 'badge-rejected',
              'reviewed' => 'badge-reviewed',
              default    => 'badge-pending'
            };
          @endphp
          <tr>
            <td>
              <div style="font-weight:500">{{ $app->applicant->name }}</div>
              <div class="sub-text">{{ $app->applicant->email }}</div>
            </td>
            <td>
              <div>
                <a href="{{ route('jobs.show', $app->jobListing) }}"
                   style="color:#1A1916;text-decoration:none;font-weight:500"
                   onmouseover="this.style.color='#185FA5'"
                   onmouseout="this.style.color='#1A1916'">
                  {{ $app->jobListing->title }}
                </a>
              </div>
              <div class="sub-text">{{ $app->jobListing->company }}</div>
            </td>
            <td><span class="badge {{ $bc }}">{{ ucfirst($app->status) }}</span></td>
            <td><span style="font-size:12.5px;color:#6B6A66;">{{ $app->created_at->format('M d, Y') }}</span></td>
            <td>
              <form method="POST" action="{{ route('admin.applications.delete', $app) }}"
                    onsubmit="return confirm('Delete this application?')">
                @csrf @method('DELETE')
                <button class="btn-del">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="text-align:center;padding:2.5rem;color:#A09E99;font-size:13px;">
              No applications found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    {{ $applications->appends(request()->query())->links() }}
  </div>
</div>

@endsection