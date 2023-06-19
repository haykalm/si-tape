<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="{{request()->is('home') ? 'active' : ''}}">
          <a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
        </li>
        @if(Auth::user()->role_id == 1)
          <li class="{{request()->is('user') ? 'active' : ''}}">
            <a href="{{url('/user')}}">
              <i class="fa fa-user"></i> <span>Users</span>
            </a>
          </li>
        @endif()

        <li class="treeview {{request()->is('penduduk','list_napi','list_transgender','list_odgj','list_panti_asuhan','all_pr') ? 'active' : ''}}">
          <a href="#">
            <i class="fa fa-users"></i> <span>Penduduk Rentan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{request()->is('all_pr') ? 'active' : ''}}"><a href="{{url('/all_pr')}}"><i class="fa fa-circle-o"></i> All</a></li>
            <li class="{{request()->is('penduduk') ? 'active' : ''}}"><a href="{{url('/penduduk')}}"><i class="fa fa-circle-o"></i> Disabilitas</a></li>
            <li class="{{request()->is('list_napi') ? 'active' : ''}}"><a href="{{url('/list_napi')}}"><i class="fa fa-circle-o"></i> Napi</a></li>
            <li class="{{request()->is('list_transgender') ? 'active' : ''}}"><a href="{{url('/list_transgender')}}"><i class="fa fa-circle-o"></i> Transgender </a></li>
            <li class="{{request()->is('list_odgj') ? 'active' : ''}}"><a href="{{url('/list_odgj')}}"><i class="fa fa-circle-o"></i> Odgj </a></li>
            <li class="{{request()->is('list_panti_asuhan') ? 'active' : ''}}"><a href="{{url('/list_panti_asuhan')}}"><i class="fa fa-circle-o"></i> Panti Asuhan </a></li>
            
          </ul>
        </li>

        <li class="treeview {{request()->is('yayasan','yayasan_odgj','yayasan_p_asuhan') ? 'active' : ''}}">
          <a href="{{url('/user')}}">
            <i class="fa fa-bank"></i> <span>Yayasan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{request()->is('yayasan') ? 'active' : ''}}">
              <a href="{{url('/yayasan')}}"><i class="fa fa-circle-o"></i>All</a>
            </li>
            <li class="{{request()->is('yayasan_odgj') ? 'active' : ''}}">
              <a href="{{url('/yayasan_odgj')}}"><i class="fa fa-circle-o"></i>Odgj</a>
            </li>
            <li class="{{request()->is('yayasan_p_asuhan') ? 'active' : ''}}">
              <a href="{{url('/yayasan_p_asuhan')}}"><i class="fa fa-circle-o"></i>Panti Asuhan</a>
            </li>
          </ul>
        </li>
        
        {{--<!-- <li class="treeview {{request()->is('category_pr','category_users') ? 'active' : ''}}">
          <a href="#"><i class="fa fa-th"></i><span> Kategori </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{request()->is('category_users') ? 'active' : ''}}">
              <a href="{{url('/category_users')}}"><i class="fa fa-circle-o"></i>Users</a>
            </li>
            <li class="{{request()->is('category_pr') ? 'active' : ''}}">
              <a href="{{url('/category_pr')}}"><i class="fa fa-circle-o"></i>Penduduk Rentan</a>
            </li>
          </ul>
        </li> --> --}}

        <li class="treeview {{request()->is('event','event/create','event_internal','create_event_internal','event/*/edit','edit_event_internal/*') ? 'active' : ''}}">
          <a href="#"><i class="fa fa-picture-o"></i><span>kegiatan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{request()->is('event_internal','create_event_internal','edit_event_internal/*') ? 'active' : ''}}">
              <a href="{{url('/event_internal')}}"><i class="fa fa-circle-o"></i> Per-orangan</a>
            </li>
            <li class="{{request()->is('event','event/create','event/*/edit') ? 'active' : ''}}">
              <a href="{{url('/event')}}"><i class="fa fa-circle-o"></i> Per-yayasan</a>
            </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#" onclick="$('#logout-form').submit()">
            <i class="fa fa-share"></i> <span>Sign Out</span>
          </a>
        </li>

        <form action="{{ url('/logout') }}" method="POST" id="logout-form" style="display: none;">
          @csrf
        </form>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>