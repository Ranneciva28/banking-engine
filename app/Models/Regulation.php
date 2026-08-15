<?php
namespace App\Models;
class Regulation extends BaseUuidModel
{
    protected $table = 'public.regulations';
    protected $casts = ['issued_date'=>'date','effective_from'=>'date','effective_to'=>'date'];
}
