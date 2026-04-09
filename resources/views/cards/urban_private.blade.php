@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')
    @include('forms.document_form', ['cardType' =>  'الحضرية الخاصة'])
@endsection