<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
class AuditActor { public function set(?string $userId): void { if ($userId) DB::statement("select set_config('app.user_id', ?, true)", [$userId]); } }
