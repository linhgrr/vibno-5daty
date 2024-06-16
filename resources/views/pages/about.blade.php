@extends('layouts.app')

@section('content')
<h1>This is about page</h1>
@unless(empty($name))
    <h1>{{ $name }}</h1>
@endunless
<img src="{{ asset('storage/20225732.jpg') }}" alt="">

@for($i = 0; $i < 10; $i++)
    <h2>{{ $i }}</h2>
@endfor

@foreach($names as $x)
    <h2>{{ $x }}</h2>
@endforeach
@endsection