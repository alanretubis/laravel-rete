@extends('laravel-rete::layouts.app')

@section('content')
    <h2>Rules</h2>
    <form method="POST" action="{{ route('rete.rules.store') }}">
        @csrf
        <input name="name" placeholder="Rule name" required>
        <textarea name="conditions" placeholder='{"var1":"yes"}' required></textarea>
        <textarea name="actions" placeholder='{"var2":"no"}' required></textarea>
        <button type="submit">Add Rule</button>
    </form>

    <ul>
        @foreach($rules as $rule)
            <li><strong>{{ $rule->name }}</strong></li>
        @endforeach
    </ul>
@endsection
