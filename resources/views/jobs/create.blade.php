@extends('layouts.app')
@section('title', 'Post a Job')
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap');

  .create-wrap {
    font-family: 'DM Sans', sans-serif;
    max-width: 640px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 4rem;
  }

  .create-header { margin-bottom: 2rem; }
  .create-header h1 {
    font-family: 'DM Serif Display', serif;
    font-size: 28px; font-weight: 400;
    letter-spacing: -0.5px; line-height: 1; color: #1A1916;
  }
  .create-header h1 em { font-style: italic; color: #6B6A66; }
  .create-header p { font-size: 13px; color: #A09E99; margin-top: 5px; }

  .create-card {
    background: #fff;
    border: 0.5px solid rgba(26,25,22,0.10);
    border-radius: 16px;
    padding: 28px 28px 24px;
    box-shadow: 0 1px 3px rgba(26,25,22,0.05);
  }

  .section-label {
    font-size: 10.5px; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: #A09E99; margin-bottom: 14px;
  }
  .section-divider {
    border: none; border-top: 0.5px solid rgba(26,25,22,0.07);
    margin: 22px 0;
  }

  .field { margin-bottom: 16px; }
  .field label {
    display: block; font-size: 11px; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: #6B6A66; margin-bottom: 6px;
  }
  .field input,
  .field select,
  .field textarea {
    width: 100%; padding: 10px 13px;
    border: 0.5px solid rgba(26,25,22,0.18); border-radius: 8px;
    font-family: 'DM Sans', sans-serif; font-size: 14px;
    color: #1A1916; background: #F9F8F5; outline: none;
    transition: border-color 0.12s, background 0.12s;
    box-sizing: border-box; appearance: none;
  }
  .field input:focus,
  .field select:focus,
  .field textarea:focus { border-color: #1A1916; background: #fff; }
  .field textarea { resize: vertical; min-height: 110px; line-height: 1.6; }
  .field .error { font-size: 12px; color: #A32D2D; margin-top: 5px; }

  .form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

  .form-actions {
    display: flex; align-items: center;
    justify-content: space-between; gap: 10px;
    margin-top: 24px; padding-top: 20px;
    border-top: 0.5px solid rgba(26,25,22,0.07);
  }
  .btn-submit {
    padding: 10px 28px; background: #1A1916; color: #fff;
    border: none; border-radius: 8px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
    cursor: pointer; transition: opacity 0.15s;
  }
  .btn-submit:hover { opacity: 0.82; }
  .btn-cancel {
    font-size: 13px; color: #6B6A66; text-decoration: none;
    padding: 10px 16px; border: 0.5px solid rgba(26,25,22,0.15);
    border-radius: 8px; transition: background 0.12s;
  }
  .btn-cancel:hover { background: #F5F4F0; color: #1A1916; }

  .alert-error {
    background: #FCEBEB; color: #A32D2D;
    border-radius: 10px; padding: 11px 16px;
    font-size: 13px; margin-bottom: 20px;
  }

  @media (max-width: 540px) {
    .form-row, .form-row-3 { grid-template-columns: 1fr; }
    .create-card { padding: 20px 16px; }
  }
</style>

<div class="create-wrap">

  <div class="create-header">
    <h1>Post a <em>Job</em></h1>
    <p>Fill in the details below to publish a new listing</p>
  </div>

  @if($errors->any())
    <div class="alert-error">Please fix the errors below before submitting.</div>
  @endif

  <div class="create-card">
    <form method="POST" action="{{ route('jobs.store') }}">
      @csrf

      {{-- Basic info --}}
      <div class="section-label">Basic information</div>

      <div class="form-row">
        <div class="field">
          <label>Job title <span style="color:#A32D2D">*</span></label>
          <input type="text" name="title" value="{{ old('title') }}" placeholder="" />
          @error('title') <p class="error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
          <label>Company <span style="color:#A32D2D">*</span></label>
          <input type="text" name="company" value="{{ old('company') }}" placeholder="" />
          @error('company') <p class="error">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="form-row">
        <div class="field">
          <label>Location <span style="color:#A32D2D">*</span></label>
          <input type="text" name="location" value="{{ old('location') }}" placeholder="" />
          @error('location') <p class="error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
          <label>Job type <span style="color:#A32D2D">*</span></label>
          <select name="type">
            <option value="">Select type</option>
            @foreach(['full-time' => 'Full-time', 'part-time' => 'Part-time', 'contract' => 'Contract', 'internship' => 'Internship'] as $val => $label)
              <option value="{{ $val }}" @selected(old('type') == $val)>{{ $label }}</option>
            @endforeach
          </select>
          @error('type') <p class="error">{{ $message }}</p> @enderror
        </div>
      </div>

      <hr class="section-divider">

      {{-- Details --}}
      <div class="section-label">Job details</div>

      <div class="field">
        <label>Description <span style="color:#A32D2D">*</span></label>
        <textarea name="description" placeholder="Describe the role, responsibilities...">{{ old('description') }}</textarea>
        @error('description') <p class="error">{{ $message }}</p> @enderror
      </div>

      <div class="field">
        <label>Requirements</label>
        <textarea name="requirements" placeholder="Skills, experience, qualifications needed...">{{ old('requirements') }}</textarea>
        @error('requirements') <p class="error">{{ $message }}</p> @enderror
      </div>

      <hr class="section-divider">

      {{-- Compensation --}}
      <div class="section-label">
        Compensation
        <span style="color:#C4C2BC;text-transform:none;font-size:10px;letter-spacing:0;font-weight:400"> — optional</span>
      </div>

      <div class="form-row-3">
        <div class="field">
          <label>Min salary (₱)</label>
          <input type="number" name="salary_min" value="{{ old('salary_min') }}" placeholder="30000" min="0" />
          @error('salary_min') <p class="error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
          <label>Max salary (₱)</label>
          <input type="number" name="salary_max" value="{{ old('salary_max') }}" placeholder="60000" min="0" />
          @error('salary_max') <p class="error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
          <label>Deadline <span style="color:#A32D2D">*</span></label>
          <input type="date" name="deadline" value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" />
          @error('deadline') <p class="error">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Actions --}}
      <div class="form-actions">
        <a href="{{ route('employer.dashboard') }}" class="btn-cancel">Cancel</a>
        <button type="submit" class="btn-submit">Publish listing</button>
      </div>

    </form>
  </div>

</div>

@endsection