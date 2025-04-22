<?php
namespace AlanRetubis\LaravelRete\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['name', 'conditions', 'actions'];
}
