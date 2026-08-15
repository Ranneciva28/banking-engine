<?php
namespace App\Models;
class Sop extends BaseUuidModel
{
    protected $table = 'public.sops';
    protected $casts = ['effective_from'=>'date','effective_to'=>'date'];
}
