<nav class="main-nav">

    <div class="main-nav__inner">

        {{-- ロゴ --}}
        <div class="main-nav__logo">
            <a href="{{ route('books.index') }}">
                <x-application-logo class="main-nav__logo-image" />
            </a>
        </div>


        {{-- メニュー --}}
        <div class="main-nav__menu">

            <a
                href="{{ route('books.index') }}"
                class="main-nav__link {{ request()->routeIs('books.index') || request()->routeIs('books.show') ? 'is-active' : '' }}"
            >
                書籍一覧
            </a>

            <a
                href="{{ route('ranking.index') }}"
                class="main-nav__link {{ request()->routeIs('ranking.index') ? 'is-active' : '' }}"
            >
                ランキング
            </a>

            @auth

                <a
                    href="{{ route('books.create') }}"
                    class="main-nav__link {{ request()->routeIs('books.create') ? 'is-active' : '' }}"
                >
                    書籍登録
                </a>

                <a
                    href="{{ route('favorites.index') }}"
                    class="main-nav__link {{ request()->routeIs('favorites.index') ? 'is-active' : '' }}"
                >
                    お気に入り
                </a>

                <a
                    href="{{ route('genres.index') }}"
                    class="main-nav__link {{ request()->routeIs('genres.*') ? 'is-active' : '' }}"
                >
                    ジャンル管理
                </a>

            @endauth

        </div>


        {{-- 右側 --}}
        <div class="main-nav__right">

            @auth

                <details class="user-menu">

                    <summary class="user-menu__button">
                        {{ Auth::user()->name }}
                        <span class="user-menu__arrow">⌄</span>
                    </summary>

                    <div class="user-menu__dropdown">

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                            novalidate
                        >
                            @csrf

                            <button
                                type="submit"
                                class="user-menu__logout"
                            >
                                ログアウト
                            </button>

                        </form>

                    </div>

                </details>

            @else

                <a
                    href="{{ route('login') }}"
                    class="main-nav__guest-link"
                >
                    ログイン
                </a>

                <a
                    href="{{ route('register') }}"
                    class="main-nav__guest-link"
                >
                    会員登録
                </a>

            @endauth

        </div>

    </div>

</nav>
