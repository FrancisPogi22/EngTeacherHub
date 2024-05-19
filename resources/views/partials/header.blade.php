<section id="header">
    <div class="wrapper">
        <div class="header-con">
            <ul class="navbar">
                @guest
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
                @auth
                    @if (auth()->user()->type == 1)
                        <li>
                            <a href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('inquiries') }}">Inquiries</a>
                        </li>
                        <li>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#profileModal" id="profileBtn">
                                Profile
                            </button>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">Logout</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('teacher.homepage') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('clients') }}">Clients</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">Logout</a>
                        </li>
                    @endif
                @endauth
            </ul>
            <button class="mobile-btn">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</section>
<section id="mobile-nav">
    <ul class="navbar">
        @guest
            <li>
                <a href="{{ route('login') }}">Login</a>
            </li>
            <li>
                <a href="{{ route('register') }}">Register</a>
            </li>
        @endguest
        @auth
            @if (auth()->user()->type == 1)
                <li>
                    <a href="{{ route('homepage') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('inquiries') }}">Inquiries</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">Logout</a>
                </li>
            @else
                <li>
                    <a href="{{ route('teacher.homepage') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('clients') }}">Clients</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">Logout</a>
                </li>
            @endif
        @endauth
    </ul>
</section>
