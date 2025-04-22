<?php
namespace AlanRetubis\LaravelRete;

use AlanRetubis\LaravelRete\Models\Rule;
use AlanRetubis\LaravelRete\Models\Variable;

class ReteEngine
{
    public function run()
    {
        $rules = Rule::all();
        $variables = Variable::pluck('value', 'name')->toArray();

        foreach ($rules as $rule) {
            $conditions = json_decode($rule->conditions, true);
            $actions = json_decode($rule->actions, true);

            $match = true;
            foreach ($conditions as $key => $expected) {
                if (($variables[$key] ?? null) != $expected) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                foreach ($actions as $key => $val) {
                    Variable::updateOrCreate(['name' => $key], ['value' => $val]);
                }
            }
        }
    }
}
