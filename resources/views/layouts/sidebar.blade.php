<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">

            <a href="index.html" class="logo"><img src="{{ asset('assets/images/HRMS3.png') }}" height="50"
                    alt="logo"></a>
        </div>
    </div>
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>
              
                <li class="menu-title">Main</li>
             
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="fa fa-dashboard"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                @can('category_view')   
           
                    <li>
                        <a href="{{ route('admin.category.dataTable') }}" class="waves-effect">
                            <i class="fa fa-list-alt"></i>
                            <span> Category </span>
                        </a>
                    </li>
                   
                @endcan
           
                @can('subcategory_view')
                    <li>
                        <a href="{{ route('admin.subcategory.dataTable') }}" class="waves-effect">
                            <i class="fa fa-list-alt"></i>
                            <span> Sub Category </span>
                        </a>
                    </li>
                @endcan
                @can('user_view')
                    <li>
                        <a href="{{ route('admin.getuser') }}" class="waves-effect">
                            <i class="fa fa-users"></i>
                            <span> Users </span>
                        </a>
                    </li>
                @endcan
                @can('user_document_view')
                    <li>
                        <a href="{{ route('admin.document.index') }}" class="waves-effect">
                            <i class="fa fa-file"></i>
                            <span>User Documents </span>
                        </a>
                    </li>
                @endcan
                @can('blog_category_view')
                    <li>
                        <a href="{{ route('admin.blog.blog') }}" class="waves-effect">
                            <i class="fa fa-list-alt"></i>
                            <span>Blog Category</span>
                        </a>
                    </li>
                @endcan
                @can('blog_details_view')
                    <li>
                        <a href="{{ route('admin.blog.blog_list') }}" class="waves-effect">
                            <i class="fa fa-list-alt"></i>
                            <span>Blog Details</span>
                        </a>
                    </li>
                @endcan
                @can('blog_comments_view')
                <li>
                    <a href="{{ route('admin.blog.blogComment') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span>Blog Comments</span>
                    </a>
                </li>
                @endcan
                @if (Auth::user()->is_admin == 1)
                    <li>
                        <a href="{{ route('admin.role.viewrole') }}" class="waves-effect">
                            <i class="fa fa-user-circle-o"></i>
                            <span>Roles & Permissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.admin_user.admin') }}" class="waves-effect">
                            <i class="fa fa-user"></i>
                            <span> Admin User </span>
                        </a>
                    </li>
                @endif
            </ul>
            
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
