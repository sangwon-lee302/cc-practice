<?php

namespace Tests\Feature;

use App\Http\Requests\StoreDailyReportRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreDailyReportRequestTest extends TestCase
{
    /**
     * バリデーションルールに従い、渡されたデータの合否を判定する
     */
    private function validate(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = (new StoreDailyReportRequest())->rules();

        return Validator::make($data, $rules);
    }

    /**
     * 正常なデータの組み合わせではバリデーションが通ることを確認
     */
    public function test_valid_data_passes_validation(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => '日報タイトル',
            'content' => '本日の作業内容についての詳細な報告です。',
            'status' => 'draft',
        ]);

        $this->assertFalse($validator->fails());
    }

    /**
     * date が未指定の場合は required エラーになることを確認
     */
    public function test_date_is_required(): void
    {
        $validator = $this->validate([
            'title' => 'タイトル',
            'content' => '10文字以上の本文です。',
            'status' => 'draft',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('date', $validator->errors()->toArray());
    }

    /**
     * date が日付形式でない場合はエラーになることを確認
     */
    public function test_date_must_be_a_valid_date(): void
    {
        $validator = $this->validate([
            'date' => 'not-a-date',
            'title' => 'タイトル',
            'content' => '10文字以上の本文です。',
            'status' => 'draft',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('date', $validator->errors()->toArray());
    }

    /**
     * title が未指定の場合は required エラーになることを確認
     */
    public function test_title_is_required(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'content' => '10文字以上の本文です。',
            'status' => 'draft',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
    }

    /**
     * title が51文字以上の場合はエラーになることを確認
     */
    public function test_title_must_not_exceed_50_characters(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => str_repeat('あ', 51),
            'content' => '10文字以上の本文です。',
            'status' => 'draft',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
    }

    /**
     * title がちょうど50文字の場合はバリデーションが通ることを確認
     */
    public function test_title_with_exactly_50_characters_passes(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => str_repeat('あ', 50),
            'content' => '10文字以上の本文です。',
            'status' => 'draft',
        ]);

        $this->assertFalse($validator->fails());
    }

    /**
     * content が未指定の場合は required エラーになることを確認
     */
    public function test_content_is_required(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => 'タイトル',
            'status' => 'draft',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('content', $validator->errors()->toArray());
    }

    /**
     * content が10文字未満の場合はエラーになることを確認
     */
    public function test_content_must_be_at_least_10_characters(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => 'タイトル',
            'content' => str_repeat('あ', 9),
            'status' => 'draft',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('content', $validator->errors()->toArray());
    }

    /**
     * content がちょうど10文字の場合はバリデーションが通ることを確認
     */
    public function test_content_with_exactly_10_characters_passes(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => 'タイトル',
            'content' => str_repeat('あ', 10),
            'status' => 'draft',
        ]);

        $this->assertFalse($validator->fails());
    }

    /**
     * status が未指定の場合は required エラーになることを確認
     */
    public function test_status_is_required(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => 'タイトル',
            'content' => '10文字以上の本文です。',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    /**
     * status が draft でも submitted でもない場合はエラーになることを確認
     */
    public function test_status_must_be_draft_or_submitted(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => 'タイトル',
            'content' => '10文字以上の本文です。',
            'status' => 'invalid-status',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    /**
     * status が submitted の場合はバリデーションが通ることを確認
     */
    public function test_status_submitted_passes(): void
    {
        $validator = $this->validate([
            'date' => '2026-08-26',
            'title' => 'タイトル',
            'content' => '10文字以上の本文です。',
            'status' => 'submitted',
        ]);

        $this->assertFalse($validator->fails());
    }
}
