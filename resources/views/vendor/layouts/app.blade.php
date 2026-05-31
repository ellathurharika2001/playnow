<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

<div class="flex h-screen">
    @include('vendor.layouts.app.sidebar')
    
    <div class="flex-1 overflow-auto">
  
    </div>
</div>

</body>
</html>
