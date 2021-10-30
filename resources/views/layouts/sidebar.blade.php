<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">

            <a href="index.html" class="logo"><img src="{{ asset('assets/images/HRMS3.png') }}" height="50" alt="logo"></a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{route('admin.dashboard') }}" class="waves-effect">
                        <i class="fa fa-dashboard"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.category.dataTable') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span> Category </span>
                    </a>
                </li>
                <li>
                    <a href="{{  route('admin.subcategory.dataTable') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span> Sub Category </span>
                    </a>
                </li>
                <li>
                    <a href="{{  route('admin.getuser') }}" class="waves-effect">
                        <i class="fa fa-users"></i>
                        <span> Users </span>
                    </a>
                </li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>