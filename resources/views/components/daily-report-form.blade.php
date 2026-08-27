@props(['dailyReport' => null])

@php
    $dailyReport ??= new \App\Models\DailyReport();
    $isEdit = $dailyReport->exists;
@endphp

<form
    action="{{ $isEdit ? route('daily-reports.update', $dailyReport) : route('daily-reports.store') }}"
    method="POST"
    class="space-y-6 bg-white rounded-md shadow p-6"
>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div>
        <label for="date" class="block text-sm font-medium text-gray-700">日付</label>
        <input
            type="date"
            name="date"
            id="date"
            value="{{ old('date', optional($dailyReport->date)->format('Y-m-d')) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
        >
        @error('date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title', $dailyReport->title) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
        >
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">内容</label>
        <textarea
            name="content"
            id="content"
            rows="6"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
        >{{ old('content', $dailyReport->content) }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">ステータス</label>
        <select
            name="status"
            id="status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
        >
            <option value="draft" @selected(old('status', $dailyReport->status ?? 'draft') === 'draft')>下書き</option>
            <option value="submitted" @selected(old('status', $dailyReport->status ?? 'draft') === 'submitted')>提出済</option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
            {{ $isEdit ? '更新する' : '作成する' }}
        </button>
    </div>
</form>
