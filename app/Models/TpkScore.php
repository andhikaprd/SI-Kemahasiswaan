<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpkScore extends Model
{
    use HasFactory;

    protected $table = 'tpk_scores';

    protected $fillable = ['alternative_id','criterion_id','value'];

    public function alternative()
    {
        return $this->belongsTo(TpkAlternative::class, 'alternative_id');
    }

    public function criterion()
    {
        return $this->belongsTo(TpkCriterion::class, 'criterion_id');
    }
}

