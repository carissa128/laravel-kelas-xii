<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="{{ route('movies') }}" method="get">
        <input type="text" name="search" placeholder="Cari nama film" value="{{ request('search') }}" required>
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @auth
          <li>{{ Auth::user()->name }}</li>
          @if (Auth::user()->role?->name === 'admin')
            <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
          @else
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('profile.show') }}">Profil</a></li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button type="submit">Logout</button>
            </form>
          </li>
        @else
          <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
        @endauth
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>