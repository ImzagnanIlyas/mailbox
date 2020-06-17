@extends('layouts.main')

@section('title')
    Boîte de réception
@endsection


@section('style')
<link rel="stylesheet" href="{{ asset('css/emails.css') }}">
@endsection

@section('content')
<div class="container">
<email-section></email-section>
</div>
@endsection
