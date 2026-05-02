<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>
    <div class="wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="main">

            {{-- Navbar --}}
            @include('layouts.navbar')

            {{-- Content --}}
            <main class="content">
                <div class="container-fluid p-3">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>
    </div>

    {{-- GLOBAL SCRIPTS --}}
    @include('layouts.scripts')

    {{-- STACK (WAJIB UNTUK DATATABLES DLL) --}}
    @stack('scripts')

    {{-- FEATHER ICON INIT --}}
    <script>
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    </script>

</body>
</html>