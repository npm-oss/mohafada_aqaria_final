@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')
<link rel="stylesheet" href="{{ asset('css/extract-topographic.css') }}">

<div class="extract-container">

    <div class="extract-card">

        <!-- HEADER -->
        <div class="card-header">
            <button class="search-btn">Recherche</button>
            <h3>بطاقات المسح الريفية</h3>
            <a href="{{ route('home') }}" class="close-btn">✖</a>
        </div>

        <p class="note">──── معلومات العقار ────</p>

        <form>

            <div class="form-grid">

                <div>
                    <label>COMMUNE</label>
                    <input type="text" placeholder="البلدية">
                </div>

                <div>
                    <label>SECTION</label>
                    <input type="text" placeholder="قسم">
                </div>

                <div>
                    <label>ILOT</label>
                    <input type="text" placeholder="مجموعة ملكية">
                </div>

                <div>
                    <label>LOT</label>
                    <input type="text" placeholder="رقم القطعة">
                </div>

            </div>

            <div class="submit-box">
                <button type="submit">📄 بحث</button>
            </div>

        </form>

    </div>

</div>
@endsection
