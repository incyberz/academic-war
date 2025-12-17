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
        @php $id = 'btn_nav--'.$menu['key']; @endphp
        <button class="btn_nav btn-fire btn-fire-icon" id="{{$id}}">
            <span class="icon">{{ $menu['icon'] }}</span>
            <span class="hide label">{{ $menu['label'] }}</span>
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