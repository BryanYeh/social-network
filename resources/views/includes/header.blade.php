<header>
  <nav class="navbar navbar-default">
      <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
          <a class="navbar-brand" href="{{ route('dashboard') }}">bestfriends</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav navbar-right">
            @if(Auth::user())
               <li><a href="{{ route('friend-find') }}">Find Friends</a></li>
               <li><a href="{{ route('account') }}">Account</a></li>
               <li><a href="{{ route('logout') }}">Logout</a></li>
            @endif
         </ul>
          @if(!Auth::user())
              <form class="navbar-form form-inline navbar-right" action="{{ route('signin') }}" method="post">
                  <div class="form-group inline {{ $errors->login->has('email') ? 'has-error' : '' }}">
                      <label class="sr-only" for="email">Email</label>
                      <input type="email" name="email" class="" id="email" placeholder="Email"
                             value="{{ Request::old('email') }}">
                  </div>
                  <div class="form-group {{ $errors->login->has('password') ? 'has-error' : '' }}">
                      <label class="sr-only" for="password">Password</label>
                      <input type="password" name="password" class="" id="password" placeholder="Password">
                  </div>
                  <input type="checkbox" name="remember_me" id="remember_me">
                  {{ csrf_field() }}
                  <button type="submit" class="btn-primary">Log in</button>
                  <a href="{{ route('reset-token') }}" class="btn btn-link">Forgot password?</a>
              </form>

          @endif
      </div>
    </div>
  </nav>
</header>
