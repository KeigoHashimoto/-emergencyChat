<header>
    <h1 class="logo">Helme</h1>
    <div class="menu">
        @auth
            <a href="{{ route('user.home') }}">home</a>
            <a href="{{ route('user.users') }}">ユーザー検索</a>    
        
            <div>
                <a href="{{ route('user.show') }}" class="icon">{{ substr(Auth::user()->name,0,1) }}</a>
            </div>
        @else
        @endauth 
    </div>
    <div class="mobile-menu">
        <div class="mobile-menu-icon">
            <i class="fas fa-ellipsis-v" @click="menuBtn = !menuBtn"></i>
        </div>

        <div class="nav-items" v-show="menuBtn != false">
            @auth
                <ul>
                    <li><a href="{{ route('user.home') }}">home</a></li>
                    <li><a href="{{ route('user.users') }}">ユーザー検索</a></li>    
                    <li><a href="{{ route('user.show') }}">{{ Auth::user()->name }}</a></li>
                </ul>
            @endauth
        </div>

    </div>
</header>