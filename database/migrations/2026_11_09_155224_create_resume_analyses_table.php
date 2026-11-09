<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(<<<'SQL'
            CREATE TABLE resume_analyses (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                candidate_name VARCHAR(255) NOT NULL,
                match_score TINYINT UNSIGNED NOT NULL CHECK (match_score BETWEEN 0 AND 100),
                matching_skills JSON NOT NULL,
                skill_gaps JSON NOT NULL,
                interview_questions JSON NOT NULL,
                created_at DATETIME,
                updated_at DATETIME
            )
        SQL);

        DB::statement('CREATE INDEX resume_analyses_candidate_name_index ON resume_analyses (candidate_name)');
        DB::statement('CREATE INDEX resume_analyses_match_score_index ON resume_analyses (match_score)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_analyses');
    }
};
