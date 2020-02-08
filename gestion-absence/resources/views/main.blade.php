<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <title>Dashboard</title>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="App">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" action="#">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup.enter="searchFor" v-model="search" type="search" placeholder="Search" name="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
 
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/dashboard" class="brand-link">
      <i class="fas fa-user-graduate"></i>
      <span class="brand-text font-weight-light" style="font-size:16px;">Attendance Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/{{Auth::user()->image}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
          {{Auth::user()->name}}
          {{Auth::user()->last_name}}
          </a>
        </div>
      </div>
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               Dashboard
                
              </p>
            </router-link>
        </li>
            
          <li class="nav-item has-treeview menu-close">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link active">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Admins</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/teacher" class="nav-link active">
                  <i class="fas fa-user-md nav-icon"></i>
                  <p>Teachers</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/student" class="nav-link active">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Student</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/module" class="nav-link active">
                  <i class="fas fa-book nav-icon"></i>
                  <p>Module</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/attendance" class="nav-link active">
                  <i class="fas fa-server nav-icon"></i>
                  <p>Attendance</p>
                </router-link>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <router-link to="/profile"class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>

            <li class="nav-item">
        
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off"></i>
               <p> {{ __('Logout') }}</p>  
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        




        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
       <!-- <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Stats</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar> 
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
</div>
<!-- ./wrapper -->
</body>
</html>
