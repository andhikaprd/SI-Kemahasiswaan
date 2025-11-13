<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpkCriterion extends Model
{
    use HasFactory;

    protected $table = 'tpk_criteria';

    protected $fillable = ['code','name','weight','type','order'];

    public function scores()
    {
        return $this->hasMany(TpkScore::class, 'criterion_id');
    }
}

