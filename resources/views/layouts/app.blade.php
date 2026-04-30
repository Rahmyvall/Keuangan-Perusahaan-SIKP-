@include('layouts.header')
<body>

    <div class="wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="main">

            {{-- Navbar / Topbar --}}
            @include('layouts.navbar')

            {{-- Page Content --}}
            <main class="content">
                <div class="p-0 container-fluid">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>
    </div>

    {{-- Scripts --}}
    @include('layouts.scripts')

    @stack('scripts')
</body>
</html>
