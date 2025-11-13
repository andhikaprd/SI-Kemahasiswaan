<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecisionWeight extends Model
{
    use HasFactory;

    protected $table = 'decision_weights';

    protected $fillable = [
        'context', 'method', 'tahun', 'matrix', 'weights', 'lambda_max', 'ci', 'cr',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'matrix' => 'array',
        'weights' => 'array',
        'lambda_max' => 'float',
        'ci' => 'float',
        'cr' => 'float',
    ];
}

