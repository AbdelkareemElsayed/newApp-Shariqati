<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <div class="nav toggle">
      <a id="menu_toggle"><i class="fa fa-bars"></i></a>
    </div>
    <nav class="nav navbar-nav">
      <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
          <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
            data-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('storage/' . auth('admin')->user()->image) }}" alt="">
            {{ auth('admin')->user()->name }}
          </a>
          <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ aurl('Profile') }}"> Profile</a>
            <a class="dropdown-item" href="{{ aurl('logout') }}"><i class="fa fa-sign-out pull-right"></i> Log
              Out</a>
          </div>
        </li>

        <li role="presentation" class="nav-item dropdown open">
          <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown"
            aria-expanded="false">
            <i class="fa fa-envelope-o"></i>
            <span
              class="badge bg-green">{{ DB::table('notifications')->where('user_id', auth('admin')->user()->id)->count() }}</span>
          </a>
          <ul class="dropdown-menu list-unstyled msg_list" style="height: 231px; overflow: auto;" role="menu"
            aria-labelledby="navbarDropdown1">
            @foreach (DB::table('notifications')->orderBy('id', 'desc')->where('user_id', auth('admin')->user()->id)->get() as $notification)
              <li class="nav-item">
                <a class="dropdown-item">
                  {{-- <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span> --}}
                  <span>
                    <span>{{ session('lang') == 'ar' ? $notification->title_ar : $notification->title }}</span>
                    <span
                      class="time">{{ date('H:i', strtotime('now') - strtotime($notification->created_at)) }}</span>
                  </span>
                  <span class="message">
                    {{ session('lang') == 'ar' ? $notification->content_ar : $notification->content }}
                  </span>
                </a>
              </li>
            @endforeach
          </ul>
        </li>




        <li role="presentation" class="nav-item dropdown open">
            <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown"
              aria-expanded="false">
              <i class="fa fa-envelope-o"></i>
              <span  class="badge bg-green" id="messages">{{ DB::table('conversationmessages')->get()->count() }}</span>
            </a>
            <ul class="dropdown-menu list-unstyled msg_list" style="height: 231px; overflow: auto;" role="menu"
              aria-labelledby="navbarDropdown1">

            </ul>
          </li>






      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->
