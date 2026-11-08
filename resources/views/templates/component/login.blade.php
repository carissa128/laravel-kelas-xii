<div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Sign In & Sign Up
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
      </div>
      <section>
        <div class="modal-body">
          <div class="w3_login_module">
            <div class="module form-module">
              <div class="toggle"><i class="fa fa-times fa-pencil"></i>
              <div class="tooltip">Click Me</div>
              </div>
              <div class="form">
              <h3>Login to your account</h3>
              <form action="{{ url('/login') }}" method="post">
                @csrf
                @if ($errors->has('login') || $errors->has('password'))
                  <div role="alert">
                    @foreach (array_merge($errors->get('login'), $errors->get('password')) as $error)
                      <p>{{ $error }}</p>
                    @endforeach
                  </div>
                @endif
                <input type="text" name="login" placeholder="Username atau Email" value="{{ old('login') }}" autocomplete="username" required="">
                <input type="password" name="password" placeholder="Password" autocomplete="current-password" required="">
                <input type="submit" value="Login">
              </form>
              </div>
              <div class="form">
              <h3>Create an account</h3>
              <form action="{{ url('/register') }}" method="post">
                @csrf
                @if ($errors->getBag('register')->any())
                  <div role="alert">
                    @foreach ($errors->getBag('register')->all() as $error)
                      <p>{{ $error }}</p>
                    @endforeach
                  </div>
                @endif
                <input type="text" name="name" placeholder="Username" value="{{ old('name') }}" autocomplete="username" required>
                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" autocomplete="email" required>
                <input type="number" name="umur" placeholder="Umur" value="{{ old('umur') }}" min="1" max="120" required>
                <input type="text" name="bio" placeholder="Bio" value="{{ old('bio') }}" required>
                <input type="text" name="alamat" placeholder="Alamat" value="{{ old('alamat') }}" required>
                <input type="password" name="password" placeholder="Password (minimal 8 karakter)" autocomplete="new-password" required>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" autocomplete="new-password" required>
                <input type="submit" value="Register">
              </form>
              </div>
              <div class="cta"><a href="#">Forgot your password?</a></div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script>
  $('.toggle').click(function(){
    // Switches the Icon
    $(this).children('i').toggleClass('fa-pencil');
    // Switches the forms  
    $('.form').animate({
    height: "toggle",
    'padding-top': 'toggle',
    'padding-bottom': 'toggle',
    opacity: "toggle"
    }, "slow");
  });
</script>
@if ($errors->any() || $errors->getBag('register')->any())
  @push('script')
    @if ($errors->getBag('register')->any())
      $('.toggle').trigger('click');
    @endif
    $('#myModal').modal('show');
  @endpush
@endif