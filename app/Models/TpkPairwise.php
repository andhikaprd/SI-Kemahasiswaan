<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpkPairwise extends Model
{
    use HasFactory;

    protected $table = 'tpk_pairwise';

    protected $fillable = [
        'criterion_id_a',
        'criterion_id_b',
        'value',
    ];

    public function criterionA()
    {
        return $this->belongsTo(TpkCriterion::class, 'criterion_id_a');
    }

    public function criterionB()
    {
        return $this->belongsTo(TpkCriterion::class, 'criterion_id_b');
    }
}
