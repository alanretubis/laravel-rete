<?php
namespace AlanRetubis\LaravelRete\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['name', 'conditions', 'actions'];

    protected $casts = [
        'conditions' => 'array', // Automatically cast conditions to an array
        'actions' => 'array',    // Automatically cast actions to an array
    ];
}
