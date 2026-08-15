<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        // Database schema already exists in Supabase. This migration is intentionally lightweight.
        // Actor identity is set by application middleware/service before mutations using:
        // SELECT set_config('app.user_id', ?, true)
    }
    public function down(): void {}
};
