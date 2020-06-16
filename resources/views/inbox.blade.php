@extends('layouts.main')

@section('title')
    Boîte de réception
@endsection


@section('style')
<link rel="stylesheet" href="{{ asset('css/emails.css') }}">
@endsection

@section('content')
<email-section></email-section>
@endsection
