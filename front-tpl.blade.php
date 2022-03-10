<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="description" content="@yield('meta-description')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @include('concert-front.partials._style')
</head>
<body class="antialiased">
    <header>
        @include('concert-front.includes.logo-header')
    </header>
    
    @include('concert-front.partials._nav')
    @include('concert-front.partials._messages')
    @yield('content')
    @include('concert-front.partials._footer')
</body>
</html>