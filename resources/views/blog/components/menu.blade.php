
     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
        <div class="container">

             <div class="navbar-header">
                  <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                       <span class="icon icon-bar"></span>
                       <span class="icon icon-bar"></span>
                       <span class="icon icon-bar"></span>
                  </button>

                  <!-- lOGO TEXT HERE -->
                  <a href="{{ route('index')}}" class="navbar-brand">Patrik Solutions</a>
             </div>

             <!-- MENU LINKS -->
             <div class="collapse navbar-collapse">
                  <ul class="nav navbar-nav navbar-nav-first">
                       <li class="@yield('home-active')"><a href="{{ route('index')}}">Home</a></li>
                       <li class="@yield('blog-active')"><a href="{{route('blog-posts')}}">Blog</a></li>
                         <!-- Calculators Dropdown -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Calculators <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="@yield('investment_calculator.index-active')">
                    <a href="{{ route('investment_calculator.index') }}">Investment Calculator</a>
                </li>
                <li class="@yield('budget_calculator.index-active')">
                    <a href="{{ route('budget_calculator.index') }}">Budget Calculator</a>
                </li>
                <li class="@yield('retirement_calculator.index-active')">
                    <a href="{{ route('retirement_calculator.index') }}">Retirement Calculator</a>
                </li>
                <li class="@yield('retirement_calculator.index-active')">
                    <a href="{{ route('mortgage-calculator') }}">Mortgage Calculator</a>
                </li>
            </ul>
        </li>
                       <li class="@yield('about-active')"><a href="{{route('about-us')}}">About Us</a></li>
                       {{-- <li><a href="{{route('team')}}">Authors</a></li> --}}
                       <li class="@yield('contact-active')"><a href="{{route('contact')}}">Contact Us</a></li>
                       @if (Route::has('login'))

                       <li class="@yield('dashboard-active')"> @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                        <li class="@yield('register-active')">
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </a>
                        </li>
                        @endif
                    @endauth</li>
                    @endif
                       {{-- <a href="{{route('contact')}}">Contact Us</a> --}}
                  </ul>
             </div>

        </div>
   </section>
