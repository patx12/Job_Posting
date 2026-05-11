@extends('layouts.app')
@section('title', 'Edit Job')
@section('content')

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Job Listing</h1>

    <form method="POST" action="{{ route('jobs.update', $jobListing) }}"
          class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Job Title *</label>
                <input type="text" name="title" value="{{ old('title', $jobListing->title) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Company *</label>
                <input type="text" name="company" value="{{ old('company', $jobListing->company) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                <input type="text" name="location" value="{{ old('location', $jobListing->location) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Job Type *</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    @foreach(['full-time','part-time','contract','internship'] as $t)
                        <option value="{{ $t }}" @selected(old('type', $jobListing->type) == $t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
            <textarea name="description" rows="5"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('description', $jobListing->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Requirements *</label>
            <textarea name="requirements" rows="4"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('requirements', $jobListing->requirements) }}</textarea>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Min Salary (₱)</label>
                <input type="number" name="salary_min" value="{{ old('salary_min', $jobListing->salary_min) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Max Salary (₱)</label>
                <input type="number" name="salary_max" value="{{ old('salary_max', $jobListing->salary_max) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deadline *</label>
                <input type="date" name="deadline" value="{{ old('deadline', $jobListing->deadline->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="open"   @selected($jobListing->status == 'open')>Open</option>
                    <option value="closed" @selected($jobListing->status == 'closed')>Closed</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium">
                Update Job
            </button>
            <a href="{{ route('employer.dashboard') }}"
               class="flex-1 text-center border border-gray-300 text-gray-600 py-2 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection