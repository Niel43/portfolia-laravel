<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Supabase exposes every public table through its public API.
 * Turning on row level security (with no policies) blocks that API,
 * while Laravel keeps full access through its own database connection.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') return;

        foreach (['users', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks', 'jobs',
                  'job_batches', 'failed_jobs', 'migrations', 'portfolios'] as $table) {
            if (Schema::hasTable($table)) {
                DB::statement('ALTER TABLE "' . $table . '" ENABLE ROW LEVEL SECURITY');
            }
        }
    }

    public function down(): void
    {
        // Intentionally left empty.
    }
};
