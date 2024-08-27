<nav>
    <style>
        .translucent-blue {
            background-color: rgba(59, 130, 246, 0.8);
            /* rgba for #3B82F6 with 0.8 opacity */
        }

        /* Basic Styles */
        .main-menu {
            display: flex;
            gap: 1rem;
        }

        .main-menu li {
            list-style: none;
        }

        .main-menu a {
            text-decoration: none;
            color: white;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .main-menu {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: rgba(59, 130, 246, 0.9);
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 100;
            }

            .main-menu.active {
                display: flex;
            }

            .main-menu li {
                padding: 1rem;
                text-align: center;
            }

            #navbarToggler {
                display: block;
                cursor: pointer;
            }
        }
    </style>
    <div class="container mb-54">
        <!-- menu -->
        <!-- ====== Navbar Section Start -->
        <div class="ud-header absolute left-0 top-0 z-40 flex w-full items-center translucent-blue">
            <div class="container">
                <!-- Header section -->
                {{-- @if ($about !== null)
                    <marquee>
                        <div>
                            <h5 class="text-white font-semibold text-md">{!! $about->about !!}</h5>
                        </div>
                    </marquee>
                @endif --}}

                <div class="relative -mx-4 flex items-center justify-between bg-blue-500">
                    <div class="w-60 max-w-12 px-4">
                        <a href="/" class="navbar-logo block w-12 py-1">
                            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" class="header-logo w-12"
                                width="400" />
                        </a>
                    </div>
                    <button id="navbarToggler"
                        class="absolute right-4 top-1/2 block -translate-y-1/2 rounded-lg px-3 ring-primary focus:ring-2 lg:hidden">
                        <span class="relative my-[6px] block h-[2px] w-[30px] bg-black"></span>
                        <span class="relative my-[6px] block h-[2px] w-[30px] bg-black"></span>
                        <span class="relative my-[6px] block h-[2px] w-[30px] bg-black"></span>
                    </button>
                    <ul id="mainMenu" class="main-menu">
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ route('frontendCategories') }}">Our Shop</a>
                            <ul class="sub-menu">
                                @foreach ($navCategories as $cat)
                                    <li><a href="{{ route('frontendCategory', $cat->slug) }}">{{ $cat->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{ route('on-sale') }}">On Sale
                                <span class="new" style="color: white;">Sale</span>
                            </a></li>
                        <li><a href="{{ route('partners') }}">Partners</a></li>
                        <li><a href="{{ route('prescription') }}">Prescription</a></li>
                        @auth
                            <li><i class="flaticon-profile mr-2 text-light"></i><a
                                    href="#">{{ auth()->user()->name }}</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('my-profile.edit') }}">Settings</a></li>
                                    <li><a href="{{ route('my-orders.index') }}">My Orders</a></li>
                                    @if (auth()->user()->isAdmin())
                                        <li><a href="{{ route('home') }}" target="_blank">Admin Dashboard</a></li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Signin</a></li>
                            <li><a href="{{ route('register') }}">Signup</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('navbarToggler').addEventListener('click', function() {
            var menu = document.getElementById('mainMenu');
            menu.classList.toggle('active');
        });
    </script>
</nav>
