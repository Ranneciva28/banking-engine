<?php
namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasUuids, Notifiable;
    protected $table = 'laravel.users';
    protected $guarded = [];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed','is_active'=>'boolean']; }
    public function canAccessPanel(Panel $panel): bool { return $this->is_active && in_array($this->role, ['super_admin','admin','maker','checker','approver'], true); }
}
