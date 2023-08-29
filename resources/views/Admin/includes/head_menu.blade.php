<!-- Main navbar -->
<div class="navbar navbar-default header-highlight">
    <div class="navbar-header navbar-header-color">
        <a class="navbar-brand navbar-brand-header" href="#">
            <img src="{{ asset('assets/images/mockups/logo.png') }}" alt="">
        </a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav nav-hide">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
            </li>
        </ul>
        <div class="navbar-right">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu nav-hide">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ auth()->user()->image_url }}" class="rounded-circle" width="20" height="18">                        <span class="hidden-xs">My account</span>
                    </a>
                    <ul class="dropdown-menu">

                        <li><a href="{{ route('profile') }}"><i class="icon-user-plus"></i> <span>My profile</span></a>
                        </li>
                        <li><a href="{{ route('resetpassword') }}"><i class="icon-lock2"></i> <span>Change
                                    Password</span></a>
                        </li>
                        <li><a href="javascript:void(0);" onclick="document.getElementById('logoutuser').submit();"><i
                                    class="icon-switch2"></i> <span>Logout</span></a>
                        </li>
                        </form>
                    </ul>
                    <form action="{{ route('logout') }}" method="post" enctype="multipart/form-data" id="logoutuser">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->
