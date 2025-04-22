<?php

namespace AlanRetubis\LaravelRete\Http\Controllers;

use Illuminate\Routing\Controller;
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
        $request->validate([
            'name' => 'required|string',
            'conditions' => 'required',
            'actions' => 'required',
        ]);

        Rule::create([
            'name' => $request->input('name'),
            'conditions' => json_encode($request->input('conditions')),
            'actions' => json_encode($request->input('actions')),
        ]);

        return redirect()->route('rete.rules.index');
    }
}
