@extends('laravel-rete::layouts.app')

@section('content')
    <h2>Rules</h2>
    <form method="POST" action="{{ route('rete.rules.store') }}">
        @csrf
        <div>
            <label for="name">Rule name</label>
            <input id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div>{{ $message }}</div> @enderror
        </div>
    
        <div>
            <label for="conditions">Conditions (JSON)</label>
            <textarea id="conditions" name="conditions" placeholder='[{"name":"temperature","operator":"==","value":"high"}]' required>{{ old('conditions') }}</textarea>
            @error('conditions') <div>{{ $message }}</div> @enderror
        </div>
    
        <div>
            <label for="actions">Actions (JSON)</label>
            <textarea id="actions" name="actions" placeholder='[{"name":"status","value":"fan_on"}]' required>{{ old('actions') }}</textarea>
            @error('actions') <div>{{ $message }}</div> @enderror
        </div>
    
        <button type="submit">Add Rule</button>
    </form>
    

    <ul>
        @foreach($rules as $rule)
            <li>
                <strong>{{ $rule->name }}</strong><br>
                <small><strong>Conditions:</strong> {{ $rule->conditions }}</small><br>
                <small><strong>Actions:</strong> {{ $rule->actions }}</small>
            </li>
        @endforeach
    </ul>    
@endsection
