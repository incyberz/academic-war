@php
$menus = [
[
'key' => 'login',
'label' => 'Welcome Login',
'icon' => '👋',
'active'=> true, // default page
],
[
'key' => 'leaderboard',
'label' => 'Leaderboard',
'icon' => '🏆',
'active'=> false,
],
[
'key' => 'help',
'label' => 'Help',
'icon' => '❓',
'active'=> false,
],
[
'key' => 'about',
'label' => 'About App',
'icon' => 'ℹ️',
'active'=> false,
],
];


@endphp



















<x-app-layout>

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/btn-fire.css') }}">

    <div class="max-w-full">
        @include('components.animasi-logo')
    </div>
    {{-- @include('components.fire-animation') --}}


    <div class="w-full mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        style="z-index: 10">
        <div class="blok_menu">
            @foreach ($menus as $menu)
            @php $id = 'btn_nav--'.$menu['key']; @endphp
            <button class="btn_nav btn-fire btn-fire-icon" id="{{$id}}">
                <span class="icon">{{ $menu['icon'] }}</span>
                <span class="hide label">{{ $menu['label'] }}</span>
            </button>
            @endforeach
        </div>

        {{-- SPA Sections --}}
        <div class="blok_content">

            <div id="login" class="spa-section">
                @include('welcome-login')
            </div>

            <div id="leaderboard" class="spa-section">
                @include('leaderboard')
            </div>

            <div id="help" class="spa-section">
                @include('help')
            </div>

            <div id="about" class="spa-section">
                @include('about')
            </div>

        </div>
    </div>






</x-app-layout>



















<script>
    $(function(){
        $('.btn_nav').click(function(){
            let tid = $(this).prop('id');
            let rid = tid.split('--');
            let key = rid[1];
            $('.spa-section').slideUp();
            $('#'+key).slideDown();
            $('.btn_nav').removeClass('btn-fire-active');
            $(this).addClass('btn-fire-active');

            localStorage.setItem('active_menu', key);
        });

        const lastActive = localStorage.getItem('active_menu');
        console.log(lastActive);
        
        if (lastActive) {
        // setActive(lastActive);
        $('#btn_nav--'+lastActive).addClass('btn-fire-active');
        $('.spa-section').hide();
        $('#'+lastActive).slideDown();
        }
    })
</script>

<script>
    function showSection(key) {
        document.querySelectorAll('.spa-section').forEach(el => {
            el.classList.remove('active');
        });

        document.querySelectorAll('.menu-item').forEach(el => {
            el.classList.remove('active');
        });

        document.getElementById(key)?.classList.add('active');

        event.target.closest('.menu-item')?.classList.add('active');
    }
</script>