<x-guest-layout>
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

    <div class="blok_menu">
        @foreach ($menus as $menu)
        {{-- <button class="menu-item-outline {{ $menu['active'] ? 'active' : '' }}"
            onclick="showSection('{{ $menu['key'] }}')"> --}}
            <button class="btn_nav menu-item-outline {{ $menu['active'] ? 'active' : '' }}"
                id="btn_nav--{{$menu['key']}}">
                <span class="icon">{{ $menu['icon'] }}</span>
                <span class="label">{{ $menu['label'] }}</span>
            </button>
            @endforeach
            <script>
                $(function(){
                    $('.btn_nav').click(function(){
                        let tid = $(this).prop('id');
                        let rid = tid.split('--');
                        let key = rid[1];
                        $('.spa-section').slideUp();
                        $('#'+key).slideDown();
                        $('.btn_nav').removeClass('active');
                        $(this).addClass('active');
                    })
                })
            </script>
    </div>

    {{-- SPA Sections --}}
    <div class="blok_content">

        <div id="login" class="spa-section active">

            @include('welcome-login')


        </div>

        <div id="leaderboard" class="spa-section">
            <h2>🏆 Leaderboard</h2>
            <p>Fitur ini akan segera hadir.</p>
        </div>

        <div id="help" class="spa-section">
            <h2>❓ Help</h2>
            <p>Panduan penggunaan Academic War.</p>
        </div>

        <div id="about" class="spa-section">
            <h2>ℹ️ About</h2>
            <p>Academic War — Gamified Learning System.</p>
        </div>

    </div>


    <style>
        .blok_menu {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            background: #e5e7eb;
            cursor: pointer;
            font-weight: 600;
            transition: .3s;
        }

        .menu-item:hover {
            background: #d1d5db;
        }

        .menu-item.active {
            background: #111827;
            color: white;
        }

        .spa-section {
            display: none;
        }

        .spa-section.active {
            display: block;
        }

        .menu-item-outline {
            display: flex;
            align-items: center;
            gap: 8px;

            padding: 8px 8px 8px 15px;
            border: 2px solid #525c6d;
            /* gray-400 */
            border-radius: 9999px;

            background: transparent;
            cursor: pointer;
            font-weight: 600;
            transition: all .3s ease;
        }

        /* icon selalu tampil */
        .menu-item-outline .icon {
            font-size: 18px;
        }

        /* label hidden default */
        .menu-item-outline .label {
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: all .3s ease;
        }

        /* saat hover → label muncul */
        .menu-item-outline:hover .label {
            max-width: 120px;
            opacity: 1;
        }

        /* hover effect */
        .menu-item-outline:hover {
            border-color: #111827;
            padding-right: 20px;
            /* gray-900 */
        }

        /* active state */
        .menu-item-outline.active {
            border-color: #111827;
            background: #111827;
            color: white;
        }
    </style>

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

</x-guest-layout>