<?php

namespace AlanRetubis\Rete\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AlanRetubis\LaravelRete\Models\Rule;
use AlanRetubis\LaravelRete\Models\Variable;
use AlanRetubis\LaravelRete\Facades\ReteEngine;
use Orchestra\Testbench\TestCase;
use AlanRetubis\LaravelRete\ReteServiceProvider;

class ReteEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            ReteServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ReteEngine' => ReteEngine::class,
        ];
    }

    /** @test */
    public function it_applies_actions_when_conditions_match()
    {
        // Prepare variables
        Variable::create(['name' => 'temperature', 'value' => 'high']);
        Variable::create(['name' => 'status', 'value' => 'normal']);

        // Prepare a rule
        Rule::create([
            'name' => 'Turn on fan if hot',
            'conditions' => json_encode([
                ['name' => 'temperature', 'operator' => '==', 'value' => 'high'],
            ]),
            'actions' => json_encode([
                ['name' => 'status', 'value' => 'fan_on'],
            ]),
        ]);

        // Evaluate the rules
        ReteEngine::evaluate();

        // Check result
        $this->assertDatabaseHas('variables', [
            'name' => 'status',
            'value' => 'fan_on',
        ]);
    }

    /** @test */
    public function it_does_not_apply_actions_when_conditions_do_not_match()
    {
        // Prepare variables
        Variable::create(['name' => 'temperature', 'value' => 'low']);
        Variable::create(['name' => 'status', 'value' => 'normal']);

        // Prepare a rule
        Rule::create([
            'name' => 'Turn on fan if hot',
            'conditions' => json_encode([
                ['name' => 'temperature', 'operator' => '==', 'value' => 'high'],
            ]),
            'actions' => json_encode([
                ['name' => 'status', 'value' => 'fan_on'],
            ]),
        ]);

        // Evaluate the rules
        ReteEngine::evaluate();

        // Check result
        $this->assertDatabaseHas('variables', [
            'name' => 'status',
            'value' => 'normal', // Should remain unchanged
        ]);
    }
}
