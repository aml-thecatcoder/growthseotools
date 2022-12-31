<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ ( Cookie::get('dir_mode') ) ? Cookie::get('dir_mode') : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Update') }} - {{ env('APP_NAME') }}</title>

    <x-admin.headerAssets />

    @livewireStyles

</head>
<body class="g-sidenav-show antialiased bg-gray-100 {{ Cookie::get('theme_mode') }}">

    <div class="wrapper">
        <div class="main-content position-relative border-radius-lg ps">
            <div class="page-body">
                <div class="container-fluid py-4">

                    <div class="text-center mb-4">
                        @if ( Cookie::get('theme_mode') === 'theme-dark' )
                            <img src="{{ \App\Models\Admin\Header::first()->logo_dark }}" height="60" class="navbar-brand navbar-brand-autodark">
                        @elseif( Cookie::get('theme_mode') === 'theme-light' )
                            <img src="{{ \App\Models\Admin\Header::first()->logo_light }}" height="60" class="navbar-brand navbar-brand-autodark">
                        @else
                            <img src="{{ \App\Models\Admin\Header::first()->logo_light }}" height="60" class="navbar-brand navbar-brand-autodark">
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                            @livewire('admin.update')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footerAssets />

    @livewireScripts

</body>
</html>