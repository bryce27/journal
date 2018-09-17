@extends('layouts.app')

@section('content')
<comment-review :user="{{ auth()->user() }}" :comment="{{ $comment }}"></comment-review>
@endsection
