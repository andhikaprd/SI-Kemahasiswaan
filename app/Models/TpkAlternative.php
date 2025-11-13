<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpkAlternative extends Model
{
    use HasFactory;

    protected $table = 'tpk_alternatives';

    protected $fillable = ['code','name','note'];

    public function scores()
    {
        return $this->hasMany(TpkScore::class, 'alternative_id');
    }
}

