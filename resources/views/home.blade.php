@extends('layouts.app')

@section('content')
    {{-- @dd(json_encode($user)) --}}
    <div class="container">
        <div id="main" data-user="{{ json_encode($user) }}"></div>
    </div>
@endsection
