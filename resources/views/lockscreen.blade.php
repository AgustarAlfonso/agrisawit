@extends('layouts.mastererror')

@section('content')
<div class="lockscreen-container">
    <h2>Lock Screen</h2>
    <form action="{{ route('lockscreen.submit') }}" method="POST">
        @csrf
        <label for="password">Masukkan password untuk membuka layar:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Unlock</button>
    </form>
    <a href="{{ route('logout') }}">Logout</a>
</div>
@endsection
