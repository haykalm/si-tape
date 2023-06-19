
  <header class="main-header">
    <!-- Logo -->

    <a href="{{url('/home')}}" class="logo">
      <span class="logo-mini"><img src="{{ url('/files/carousel/logo-capil.jpg') }}" class="img-circle" alt="logo-disdukcapil"></span>
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
              @if(Auth::user()->foto != NULL)
                <img src="{{ url('/files/users/'.Auth::user()->foto) }}" class="user-image" alt="User Image">
              @else()
                <img src="{{ url('/files/users/user-foto-default.jpg') }}" class="user-image" alt="User Image">
              @endif()
              
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                @if(Auth::user()->foto != NULL)
                  <img src="{{ url('/files/users/'.Auth::user()->foto) }}" class="img-circle" alt="User Image">
                @else()
                  <img src="{{ url('/files/users/user-foto-default.jpg') }}" class="img-circle" alt="User Image">
                @endif()

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
                  <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-profil">Profile</a>
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

  <!-- modal profil -->
  <div class="modal small" id="modal-profil">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="border-radius: 7px">

        <div class="box-body box-profile">
          @if(Auth::user()->foto != NULL)
            <img class="profile-user-img img-responsive img-circle" src="{{ url('/files/users/'.Auth::user()->foto) }}" alt="User profile picture" style="height: 140px;width: 220px;">
          @else()
            <img class="profile-user-img img-responsive img-circle" src="{{ url('/files/users/user-foto-default.jpg') }}" alt="User profile picture" style="height: 140px;width: 220px;">
          @endif()

          <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

          <p class="text-muted text-center">
            @if(Auth::user()->role_id == 1)
              <i>Super Admin</i>
            @else()
              <i>Admin</i>
            @endif()
          </p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Member</b> <a class="pull-right">{{ date("d-M-Y",strtotime(Auth::user()->created_at)) }}</a>
            </li>
            <li class="list-group-item">
              <b>Email</b> <a class="pull-right">{{ Auth::user()->email }}</a>
            </li>
            <li class="list-group-item">
              <b>Phone</b> <a class="pull-right">{{ Auth::user()->phone }}</a>
            </li>
            <li class="list-group-item">
              <b>Address </b> <a class="pull-right responsive">{{ Auth::user()->address }}</a>
            </li>
          </ul>

          <a href="#" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-edit-users" data-dismiss="modal"><b>Edit</b></a>
          <a href="#" class="btn btn-danger btn-block" data-dismiss="modal"><b>Close</b></a>
        </div>
      </div>
    </div>
  </div>

<!-- edit modal user -->
  <div class="modal small" id="modal-edit-users">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="border-radius: 7px">

        <div class="box-body box-profile">

          <h3 class="profile-username text-center">Edit Your Profile</h3>

          <form method="POST" action="{{ url('/user',Auth::user()->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
              <input type="hidden" name="role_id" value="{{ Auth::user()->role_id }}" required>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Name</b> <input type="text" name="name" class="pull-right" value="{{ Auth::user()->name }}" required>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <input type="email" name="email" class="pull-right" value="{{ Auth::user()->email }}" required>
                </li>
                <li class="list-group-item">
                  <b>Password</b> <input type="password" name="password" class="pull-right">
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <input type="number" name="phone" class="pull-right" value="{{ Auth::user()->phone }}">
                </li>
                <li class="list-group-item">
                  <b>Address</b> <input type="text" name="address" class="pull-right" value="{{ Auth::user()->address }}">
                </li>
                <li class="list-group-item">
                  <b>Foto</b> <input type="file" name="foto" class="pull-right" style="margin: 0px;">
                </li>
              </ul>

              <button type="submit" class="btn btn-primary btn-block"><b>Save</b></button>
              <a href="#" class="btn btn-danger btn-block" data-dismiss="modal"><b>Close</b></a>
            </div>
          </form>
      </div>
    </div>
  </div>