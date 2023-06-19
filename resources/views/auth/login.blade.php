<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>login</title>
  <link rel="icon" href="{{ url('/files/carousel/logo-capil.jpg') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page" style="background-image: url({{ url('/files/carousel/bg-summarecon.jpg') }});width: 100%">
<center>
  <div class="login-box" style="margin: 0px;margin-top: 50px">
    <div class="login-box-body" style="border-radius: 5px">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol>

        <div class="carousel-inner">
          <div class="active item">
            <img src="{{ url('/files/carousel/disabilitas.jpg') }}" alt="image disabilitas" style="height: 230px">
            <div class="carousel-caption">
              <h3><b>SI</b>-TANPAN </h3>
              <h6>
                <p class="h4"><b>Menyimpan dan Mengelola data penyandang Disabilitas di kota Bekasi</b></p>
              </h6>
            </div>
          </div>

          <div class="item">
            <img src="{{ url('/files/carousel/napi.jpg') }}" alt="image napi" style="height: 230px">      
            <div class="carousel-caption">
              <h3><b>SI</b>-TANPAN </h3>
              <p class="h4"><b>Menyimpan dan Mengelola data nara pidana (napi) di kota Bekasi</b></p>
            </div>
          </div>

          <div class="item">
            <img src="{{ url('/files/carousel/odgj.jpg') }}" alt="image odgj" style="height: 230px">
            <div class="carousel-caption">
              <h3><b>SI</b>-TANPAN </h3>
              <p class="h4"><b>Menyimpan dan Mengelola data orang dengan gangguan jiwa (odgj) di kota Bekasi</b></p>
            </div>
          </div>

          <div class="item">
            <img src="{{ url('/files/carousel/panti_asuhan.jpg') }}" alt="image panti_asuhan" style="height: 230px">
            <div class="carousel-caption">
              <h3><b>SI</b>-TANPAN </h3>
              <p class="h4"><b>Menyimpan dan Mengelola data orang terlantar di kota Bekasi</b></p>
            </div>
          </div>
        </div>
      </div>

      <p class="login-box-msg" style="margin-bottom: 3px">
        <b>SI-TANPAN</b>
        (Sistem Informasi Pendataan Penduduk Rentan)
        <b>DISDUKCAPIL KOTA BEKASI</b>
      </p>
      <form action="{{ route('login') }}" method="POST" style="margin: 3px">
        @csrf
          <div class="form-group has-feedback">
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong style="color: red;">{{ $message }}</strong>
                </span>
              @enderror
          </div>
          <div class="form-group has-feedback">
              <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong style="color: red;">{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <br>
          <div class="row">
              {{--<!-- <div class="col-xs-8">
                @if (Route::has('password.request'))
                  <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                  </a>
                @endif
              </div> --> --}}
              <!-- /.col -->
              <div class="col-xs-8" style="margin-left: 59px;">
                  <button type="submit" class="btn btn-default btn-block btn-flat" style="border-radius: 5px">Sign In</button>
              </div>
          </div>
      </form>
    </div>
  </div>
</center>
<!-- jQuery 3 -->
<script src="{{ asset('AdminLTE-2') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('AdminLTE-2') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ asset('AdminLTE-2') }}/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>


