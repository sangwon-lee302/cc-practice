<x-layouts.app title="日報一覧">
    <div class="flex justify-end mb-4">
        <a href="{{ route('daily-reports.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
            新規作成
        </a>
    </div>

    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">日付</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">タイトル</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ステータス</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($dailyReports as $dailyReport)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $dailyReport->date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $dailyReport->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            @if ($dailyReport->status === 'submitted')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">提出済</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-700">下書き</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-right space-x-2">
                            <a href="{{ route('daily-reports.edit', $dailyReport) }}" class="text-gray-600 hover:text-gray-900">編集</a>
                            <form action="{{ route('daily-reports.destroy', $dailyReport) }}" method="POST" class="inline" onsubmit="return confirm('この日報を削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-sm text-center text-gray-500">日報がありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $dailyReports->links() }}
    </div>
</x-layouts.app>
