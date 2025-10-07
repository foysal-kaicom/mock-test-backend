<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>JPTBD Login</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
  </head>
  <body>
    <section>
      <div class="container bg-light rounded col-lg-5" style="position:relative; top:140px; box-shadow: 0 8px 10px rgba(33, 1, 1, 0.1); width:500px;padding-top:30px; height:500px">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-10">
            <div class="text-start text-secondary mb-4">
              {{-- <h2 class="display-5 fw-medium text-center">JPTBD Login</h2> --}}
              <img src="{{ asset('logo/logo.png') }}" alt="" style="width:250px; position:relative; top:-20px; left:70px">
              <p class="mt-1">Sign in to your account</p>
            </div>

            <form action="{{ route('doLogin') }}" method="post">
              @csrf
              <div class="mb-3">
                  <label htmlFor="email" class="form-label">Email</label>
                  <div class="input-group">
                      <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C13.6418 20 15.1681 19.5054 16.4381 18.6571L17.5476 20.3214C15.9602 21.3818 14.0523 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V13.5C22 15.433 20.433 17 18.5 17C17.2958 17 16.2336 16.3918 15.6038 15.4659C14.6942 16.4115 13.4158 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C13.1258 7 14.1647 7.37209 15.0005 8H17V13.5C17 14.3284 17.6716 15 18.5 15C19.3284 15 20 14.3284 20 13.5V12ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"></path></svg>
                      </span>
                      <input
                          type="email"
                          class="form-control @error('email') is-invalid @enderror"
                          id="email"
                          name="email"
                          placeholder="Email"
                          value="{{ old('email') }}"
                      />
                      @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
          
              <div class="mb-4">
                  <label htmlFor="password" class="form-label">Password</label>
                  <div class="input-group">
                      <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M6 8V7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7V8H20C20.5523 8 21 8.44772 21 9V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V9C3 8.44772 3.44772 8 4 8H6ZM19 10H5V20H19V10ZM11 15.7324C10.4022 15.3866 10 14.7403 10 14C10 12.8954 10.8954 12 12 12C13.1046 12 14 12.8954 14 14C14 14.7403 13.5978 15.3866 13 15.7324V18H11V15.7324ZM8 8H16V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V8Z"></path></svg>
                      </span>
                      <input
                          type="password"
                          class="form-control @error('password') is-invalid @enderror"
                          id="password"
                          name="password"
                          placeholder="Password"
                      />
                      @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
          
              <div class="d-flex justify-content-between align-items-center">
                  <button type="submit" class="btn btn-primary px-4 py-2">Login</button>
                  <a href="/forgot-password" class="text-primary">Forgot your password?</a>
              </div>
          </form>
          
          </div>
        </div>
      </div>
    </section>
  </body>

  <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
  <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

  <!-- Display Toastr notifications -->
  @if (session('success'))
      <script>
          toastr.success("{{ session('success') }}");
      </script>
  @elseif (session('error'))
      <script>
          toastr.error("{{ session('error') }}");
      </script>
  @endif
</html>
