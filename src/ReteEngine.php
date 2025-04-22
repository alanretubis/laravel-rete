<?php

namespace AlanRetubis\LaravelRete;

use AlanRetubis\LaravelRete\Models\Rule;
use AlanRetubis\LaravelRete\Models\Variable;

class ReteEngine
{
    protected array $rules;
    protected array $variables;

    public function __construct()
    {
        $this->rules = Rule::all()->toArray();
        $this->variables = Variable::all()->pluck('value', 'key')->toArray();
    }

    public function evaluate(array $facts = []): array
    {
        $results = [];
    
        $facts = empty($facts) ? $this->variables : array_merge($this->variables, $facts);
    
        foreach ($this->rules as $rule) {
            if ($this->matchRule($rule, $facts)) {
                $results[] = [
                    'rule' => $rule['name'],
                    'actions' => $this->applyActions($rule),
                ];
            }
        }
    
        return $results;
    }
    
    protected function applyActions(array $rule): array
    {
        $actions = json_decode($rule['actions'], true) ?? [];
    
        foreach ($actions as $action) {
            $key = $action['name'] ?? null;
            $value = $action['value'] ?? null;
    
            if ($key !== null) {
                Variable::updateOrCreate(
                    ['name' => $key],
                    ['value' => $value]
                );
            }
        }
    
        return $actions;
    }

    protected function matchRule(array $rule, array $facts): bool
    {
        $conditions = json_decode($rule['conditions'], true);

        foreach ($conditions as $condition) {
            $key = $condition['key'] ?? null;
            $operator = $condition['operator'] ?? '=';
            $value = $condition['value'] ?? null;

            $factValue = $facts[$key] ?? null;

            if (!$this->compare($factValue, $operator, $value)) {
                return false;
            }
        }

        return true;
    }

    protected function compare($factValue, string $operator, $value): bool
    {
        return match ($operator) {
            '=' => $factValue == $value,
            '!=' => $factValue != $value,
            '>' => $factValue > $value,
            '<' => $factValue < $value,
            '>=' => $factValue >= $value,
            '<=' => $factValue <= $value,
            default => false,
        };
    }
}
