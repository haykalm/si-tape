
  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('/home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>T</span>
      <!-- logo for regular navbar-static-tope and mobile devices -->
      <span class="logo-lg"><b>SI-</b>TANPAN</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('AdminLTE-2') }}/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('AdminLTE-2') }}/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}}
                  <small>Member since {{ date("d-M-Y",strtotime(Auth::user()->created_at)) }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center" style="text-decoration: none;">
                    Status
                  </div>
                  <div class="col-xs-4 text-center">
                  </div>
                  <div class="col-xs-4 text-center">
                    @if(Auth::user()->role_id == 1)
                      Super Admin
                    @else()
                      Admin
                    @endif()
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" onclick="$('#logout-form').submit()" class="btn btn-default btn-flat">Sign out</a>
                </div>
                <form action="{{ url('/logout') }}" method="POST" id="logout-form" style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>