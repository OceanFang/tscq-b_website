<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="{{ url('/logout') }}">
            <i class="fa fa-sign-out"></i> {{ trans('lang.logout') }}
          </a>
        </li>

        <li>
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <b>{{ Auth::user()->name }}</b> {{ trans('lang.hello') }}
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li>
              <a style="font-size: 16px" href="{{ url('password/own') }}">
                  修改密碼
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->
