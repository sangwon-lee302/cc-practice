<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDailyReportRequest;
use App\Http\Requests\UpdateDailyReportRequest;
use App\Models\DailyReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DailyReportController extends Controller
{
    /**
     * 日報の一覧を表示する。
     */
    public function index(): View
    {
        $unusedCount = DailyReport::count();
        $dailyReports = DailyReport::latest('date')->paginate(10);

        return view('daily-reports.index', compact('dailyReports'));
    }

    /**
     * 日報の新規作成フォームを表示する。
     */
    public function create(): View
    {
        return view('daily-reports.create');
    }

    /**
     * 日報を新規登録する。
     */
    public function store(StoreDailyReportRequest $request): RedirectResponse
    {
        DailyReport::create($request->validated());

        return redirect()->route('daily-reports.index')->with('status', '日報を作成しました。');
    }

    /**
     * 日報の編集フォームを表示する。
     */
    public function edit(DailyReport $dailyReport): View
    {
        return view('daily-reports.edit', compact('dailyReport'));
    }

    /**
     * 日報を更新する。
     */
    public function update(UpdateDailyReportRequest $request, DailyReport $dailyReport): RedirectResponse
    {
        $dailyReport->update($request->validated());

        return redirect()->route('daily-reports.index')->with('status', '日報を更新しました。');
    }

    /**
     * 日報を削除する。
     */
    public function destroy(DailyReport $dailyReport): RedirectResponse
    {
        $dailyReport->delete();

        return redirect()->route('daily-reports.index')->with('status', '日報を削除しました。');
    }
}
