@extends('layouts.adminnavigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

<style>

    .banner-content {
        z-index: 2;
        text-align: left;
    }
    .banner h1 {
        font-size: 2em;
        color: #333333;
        margin: 0;
    }
    .banner p {
        font-size: 1em;
        color: #666666;
        margin: 10px 0;
    }
    .banner .cta-button {
        background-color: #0070f3;
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
        text-transform: uppercase;
    }
    .banner .cta-subtext {
        font-size: 1em;
        color: #666666;
        margin-top: 10px;
    }
    .banner img {
        max-width: 300px;
        height: auto;
        z-index: 2;
    }
    .banner .overlay {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 50%;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(0, 112, 243, 1));
        z-index: 1;
    }
</style>


@section('content')
<div>
    <div style="margin-top: 150px; margin-left: 25%; margin-right: 50px; padding-right: 200px;">
        <h1 style="font-size: 5rem; font-weight:bold">Helping Paws Clinic</h1>
        <h1 style="font-size: 2rem; font-weight:bold">Always here to help you.</h1>
    </div>
</div>

<div class="py-12">


</div>

<!-- Banner at the bottom -->
<div class="banner">
    <div class="banner-content" style="margin-left: 25%; ">
        <h1>Linking your pets to our very best!</h1>
        <p>Get your pet's medical service with our professional veterinarians based in the Philippines.</p>
        <button class="cta-button">24/7 Customer Service</button>
        <p class="cta-subtext">We're here whenever you need us!</p>
    </div>
    <img src="{{ url('/images/dog.png') }}" alt="Dog" class="mx-auto" style="max-width: 100%; max-height: 100vh; height: auto; width: auto">
</div>
@endsection
