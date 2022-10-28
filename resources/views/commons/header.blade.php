<header>
    <h1 class="logo">ChatApp</h1>
    <div class="logout">
        @auth
            <form action='{{ route('user.logout') }}' method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        @else
            
        @endauth 
    </div>
</header>