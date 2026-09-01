<x-layouts.app title="日報集計">
    <div class="bg-white rounded-md shadow p-4 space-y-2">
        <p class="text-sm text-gray-700">下書き件数: {{ $draftCount }}</p>
        <p class="text-sm text-gray-700">提出済件数: {{ $submittedCount }}</p>
    </div>
</x-layouts.app>
