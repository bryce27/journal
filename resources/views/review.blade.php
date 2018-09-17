@extends('layouts.app')

@section('content')
<review-manager :user="{{ auth()->user() }}"></review-manager>
@endsection
