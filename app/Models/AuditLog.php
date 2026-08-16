<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AuditLog extends Model
{
    protected $table = 'public.audit_logs';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['old_data'=>'array','new_data'=>'array','created_at'=>'datetime'];
}
