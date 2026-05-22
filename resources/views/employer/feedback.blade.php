@extends('layouts.app')
@section('title', 'Feedback — ' . $jobListing->title)
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');
  .wrap { font-family:'DM Sans',sans-serif; max-width:760px; margin:0 auto; padding:2.5rem 1.5rem 4rem; }
  .back-link { display:inline-flex; align-items:center; gap:5px; font-size:13px; color:#6B6A66; text-decoration:none; margin-bottom:1.5rem; }
  .back-link:hover { color:#1A1916; }
  .page-header { margin-bottom:2rem; }
  .page-header h1 { font-family:'DM Serif Display',serif; font-size:26px; font-weight:400; letter-spacing:-0.4px; color:#1A1916; line-height:1; }
  .page-header h1 em { font-style:italic; color:#6B6A66; }
  .page-header p { font-size:13px; color:#A09E99; margin-top:5px; }

  .avg-card {
    background:#fff; border:0.5px solid rgba(26,25,22,0.10);
    border-radius:14px; padding:20px 22px;
    box-shadow:0 1px 3px rgba(26,25,22,0.05);
    display:flex; align-items:center; gap:16px;
    margin-bottom:1.5rem;
  }
  .avg-num { font-family:'DM Serif Display',serif; font-size:48px; font-weight:400; color:#1A1916; line-height:1; }
  .avg-stars { display:flex; gap:3px; margin-bottom:4px; }
  .avg-stars svg { width:18px; height:18px; }
  .avg-label { font-size:12px; color:#A09E99; }

  .feedback-list { display:flex; flex-direction:column; gap:8px; }
  .feedback-card {
    background:#fff; border:0.5px solid rgba(26,25,22,0.10);
    border-radius:14px; padding:18px 20px;
    box-shadow:0 1px 3px rgba(26,25,22,0.05);
  }
  .fb-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; flex-wrap:wrap; gap:8px; }
  .fb-user { display:flex; align-items:center; gap:10px; }
  .fb-avatar {
    width:36px; height:36px; border-radius:9px;
    background:#F5F4F0; border:0.5px solid rgba(26,25,22,0.08);
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:500; color:#1A1916;
  }
  .fb-name { font-size:13.5px; font-weight:500; color:#1A1916; }
  .fb-date { font-size:11.5px; color:#C4C2BC; margin-top:1px; }
  .fb-stars { display:flex; gap:2px; }
  .fb-stars svg { width:14px; height:14px; }
  .fb-comment { font-size:13px; color:#6B6A66; line-height:1.65; margin-top:8px; }

  .empty-card { background:#fff; border:0.5px dashed rgba(26,25,22,0.15); border-radius:14px; padding:3rem 1rem; text-align:center; }
  .empty-card h3 { font-family:'DM Serif Display',serif; font-size:19px; font-weight:400; color:#1A1916; margin-bottom:4px; }
  .empty-card p { font-size:13px; color:#A09E99; }

  .pagination-wrap { margin-top:1.5rem; display:flex; justify-content:center; }
  .pagination-wrap nav { display:flex; gap:5px; }
  .pagination-wrap span, .pagination-wrap a { display:flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; font-size:12.5px; font-family:'DM Sans',sans-serif; border:0.5px solid rgba(26,25,22,0.12); background:#fff; color:#6B6A66; text-decoration:none; }
  .pagination-wrap a:hover { background:#F5F4F0; }
  .pagination-wrap [aria-current="page"] span { background:#1A1916 !important; color:#fff !important; border-color:#1A1916; }
</style>

<div class="wrap">

  <a href="{{ route('employer.dashboard') }}" class="back-link">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
      <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    Back to dashboard
  </a>

  <div class="page-header">
    <h1>Feedback for <em>{{ $jobListing->title }}</em></h1>
    <p>{{ $feedbacks->total() }} {{ Str::plural('review', $feedbacks->total()) }} &middot; {{ $jobListing->company }}</p>
  </div>

  {{-- Average rating --}}
  @if($feedbacks->total() > 0)
    <div class="avg-card">
      <div class="avg-num">{{ number_format($avgRating, 1) }}</div>
      <div>
        <div class="avg-stars">
          @for($i = 1; $i <= 5; $i++)
            <svg viewBox="0 0 20 20" fill="{{ $i <= round($avgRating) ? '#1A1916' : 'none' }}" stroke="#1A1916" stroke-width="1.2">
              <path d="M10 1l2.39 4.84 5.34.78-3.86 3.76.91 5.32L10 13.27l-4.78 2.51.91-5.32L2.27 6.62l5.34-.78L10 1z"/>
            </svg>
          @endfor
        </div>
        <div class="avg-label">Average rating from {{ $feedbacks->total() }} {{ Str::plural('review', $feedbacks->total()) }}</div>
      </div>
    </div>
  @endif

  {{-- Feedback list --}}
  <div class="feedback-list">
    @forelse($feedbacks as $fb)
      <div class="feedback-card">
        <div class="fb-header">
          <div class="fb-user">
            <div class="fb-avatar">{{ strtoupper(substr($fb->user->name, 0, 2)) }}</div>
            <div>
              <div class="fb-name">{{ $fb->user->name }}</div>
              <div class="fb-date">{{ $fb->created_at->format('M d, Y') }}</div>
            </div>
          </div>
          <div class="fb-stars">
            @for($i = 1; $i <= 5; $i++)
              <svg viewBox="0 0 20 20" fill="{{ $i <= $fb->rating ? '#1A1916' : 'none' }}" stroke="#1A1916" stroke-width="1.2">
                <path d="M10 1l2.39 4.84 5.34.78-3.86 3.76.91 5.32L10 13.27l-4.78 2.51.91-5.32L2.27 6.62l5.34-.78L10 1z"/>
              </svg>
            @endfor
          </div>
        </div>
        @if($fb->comment)
          <div class="fb-comment">{{ $fb->comment }}</div>
        @endif
      </div>
    @empty
      <div class="empty-card">
        <h3>No feedback yet</h3>
        <p>Feedback will appear here once applicants submit reviews.</p>
      </div>
    @endforelse
  </div>

  @if($feedbacks->hasPages())
    <div class="pagination-wrap">{{ $feedbacks->links() }}</div>
  @endif

</div>

@endsection