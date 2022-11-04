<header>
    <h1 class="logo">ChatApp</h1>
    <div class="menu">
        @auth
            <a href="{{ route('user.home') }}">home</a>
            <a href="{{ route('user.users') }}">ユーザー検索</a>    
            <form action='{{ route('user.logout') }}' method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
            <div>
                <a href="{{ route('user.show') }}" class="icon">{{ substr(Auth::user()->name,0,1) }}</a>
            </div>
        @else
        @endauth 
    </div>
</header>