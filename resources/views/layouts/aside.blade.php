<div class="col-md-3 left_col">
  <div class="left_col scroll-view">

    <div class="navbar nav_title" style="border: 0;">
      <a href="{{ url('/') }}" class="site_title">
        <span>{{ trans('lang.web_name') }}</span>
      </a>
    </div>

    <div class="clearfix"></div>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

      <div class="menu_section"><br>
        <ul class="nav side-menu">
          <li>
            <a href="{{ url('/') }}">
              <i class="fa fa-home"></i> {{ trans('lang.home') }}
            </a>
          </li>

          @foreach($mainMenuArray as $mainMenu)
          <li>
            <a>
              <i class="fa <?php echo $mainMenu['icon']; ?>"></i> {{ $mainMenu['name'] }}
              @if(isset($subMenuArray[$mainMenu['id']]))
              <span class="fa fa-chevron-down"></span>
              @endif
            </a>
              @if(isset($subMenuArray[$mainMenu['id']]))
              <ul class="nav child_menu">
                @foreach($subMenuArray[$mainMenu['id']] as $subMenu)
                  <li>
                    @if (!in_array($subMenu['id'], $expectId))
                    <a href="{{ url($subMenu['route_name']) }}">{{ $subMenu['name'] }}</a>
                    @else
                    <a>{{ $subMenu['name'] }}<span class="fa fa-chevron-down"></span></a>
                    @endif

                    @if(isset($thirdMenuArray[$subMenu['id']]))
                    <ul class="nav child_menu">
                      @foreach($thirdMenuArray[$subMenu['id']] as $subMenu2)
                        <li>
                          <a href="{{ url($subMenu2['route_name']) }}"> {{ $subMenu2['name'] }}</a>
                        </li>
                      @endforeach
                    </ul>
                    @endif

                  </li>
                @endforeach
              </ul>
              @endif
          </li>
          @endforeach
        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

  </div>
</div>
