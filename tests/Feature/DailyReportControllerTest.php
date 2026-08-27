<?php

namespace Tests\Feature;

use App\Models\DailyReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailyReportControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 一覧画面に登録済みの日報が表示されることを確認
     */
    public function test_index_displays_daily_reports(): void
    {
        $dailyReport = DailyReport::factory()->create(['title' => 'テスト日報']);

        $response = $this->get(route('daily-reports.index'));

        $response->assertStatus(200);
        $response->assertSee('テスト日報');
    }

    /**
     * 新規作成フォームが表示されることを確認
     */
    public function test_create_displays_form(): void
    {
        $response = $this->get(route('daily-reports.create'));

        $response->assertStatus(200);
    }

    /**
     * 正常なデータで日報を新規作成できることを確認
     */
    public function test_store_creates_daily_report(): void
    {
        $response = $this->post(route('daily-reports.store'), [
            'date' => '2026-08-26',
            'title' => '日報タイトル',
            'content' => '本日の作業内容についての詳細な報告です。',
            'status' => 'draft',
        ]);

        $response->assertRedirect(route('daily-reports.index'));
        $this->assertDatabaseHas('daily_reports', [
            'title' => '日報タイトル',
            'status' => 'draft',
        ]);
    }

    /**
     * バリデーションエラー時は日報が作成されないことを確認
     */
    public function test_store_fails_with_invalid_data(): void
    {
        $response = $this->post(route('daily-reports.store'), [
            'date' => '',
            'title' => '',
            'content' => '',
            'status' => '',
        ]);

        $response->assertSessionHasErrors(['date', 'title', 'content', 'status']);
        $this->assertDatabaseCount('daily_reports', 0);
    }

    /**
     * 編集フォームに既存データが表示されることを確認
     */
    public function test_edit_displays_form_with_daily_report(): void
    {
        $dailyReport = DailyReport::factory()->create(['title' => '編集対象の日報']);

        $response = $this->get(route('daily-reports.edit', $dailyReport));

        $response->assertStatus(200);
        $response->assertSee('編集対象の日報');
    }

    /**
     * 正常なデータで日報を更新できることを確認
     */
    public function test_update_modifies_daily_report(): void
    {
        $dailyReport = DailyReport::factory()->create(['status' => 'draft']);

        $response = $this->put(route('daily-reports.update', $dailyReport), [
            'date' => '2026-08-27',
            'title' => '更新後のタイトル',
            'content' => '更新後の内容についての詳細な報告です。',
            'status' => 'submitted',
        ]);

        $response->assertRedirect(route('daily-reports.index'));
        $this->assertDatabaseHas('daily_reports', [
            'id' => $dailyReport->id,
            'title' => '更新後のタイトル',
            'status' => 'submitted',
        ]);
    }

    /**
     * 日報を削除できることを確認
     */
    public function test_destroy_deletes_daily_report(): void
    {
        $dailyReport = DailyReport::factory()->create();

        $response = $this->delete(route('daily-reports.destroy', $dailyReport));

        $response->assertRedirect(route('daily-reports.index'));
        $this->assertDatabaseMissing('daily_reports', ['id' => $dailyReport->id]);
    }
}
