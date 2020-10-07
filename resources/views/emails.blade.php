@extends('layouts.main')

@section('title')
    Mailbox
@endsection


@section('style')
<link rel="stylesheet" href="{{ asset('css/emails.css') }}">
@endsection

@section('content')

<email-section></email-section>

@endsection
