<?php
namespace AlanRetubis\LaravelRete\Http\Controllers;

use Illuminate\Http\Request;
use AlanRetubis\LaravelRete\Models\Rule;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::all();
        return view('laravel-rete::rules.index', compact('rules'));
    }

    public function store(Request $request)
    {
        Rule::create($request->only('name', 'conditions', 'actions'));
        return redirect()->route('rete.rules.index');
    }
}
