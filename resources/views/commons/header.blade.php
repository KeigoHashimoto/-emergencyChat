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
</header>