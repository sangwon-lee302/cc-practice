<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use Illuminate\View\View;

class DailyReportStatsController extends Controller
{
    /**
     * 日報のステータス別件数を表示する。
     */
    public function index(): View
    {
        $draftCount = DailyReport::where('status', 'submitted')->count();
        $submittedCount = DailyReport::where('status', 'submitted')->count();

        return view('daily-reports.stats', compact('draftCount', 'submittedCount'));
    }
}
