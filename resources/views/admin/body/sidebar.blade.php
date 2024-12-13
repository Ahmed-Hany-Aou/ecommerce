<aside class="main-sidebar">
    <!-- Sidebar -->
    <section class="sidebar">
        <div class="user-profile">
            <div class="ulogo">
                <a href="{{ route('dashboard') }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ asset('backend/images/logo-dark.png') }}" alt="">
                        <h3><b>Easy</b> Shop</h3>
                    </div>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Dashboard -->
            <li class="treeview">
                <a href="{{ route('dashboard') }}">
                    <i data-feather="pie-chart"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Brands -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="message-circle"></i>
                    <span>Brands</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="ti-more"></i>All Brands</a></li>
                </ul>
            </li>

            <!-- Category -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="mail"></i>
                    <span>Category</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="ti-more"></i>All Categories</a></li>
                    <li><a href="#"><i class="ti-more"></i>Sub Categories</a></li>
                    <li><a href="#"><i class="ti-more"></i>Sub->Sub Categories</a></li>
                </ul>
            </li>

            <!-- Products -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="file"></i>
                    <span>Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="ti-more"></i>Add Products</a></li>
                    <li><a href="#"><i class="ti-more"></i>Manage Products</a></li>
                </ul>
            </li>

            <!-- Slider -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="file"></i>
                    <span>Slider</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="ti-more"></i>Manage Slider</a></li>
                </ul>
            </li>

            <!-- Coupons -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="file"></i>
                    <span>Coupons</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="ti-more"></i>Manage Coupons</a></li>
                </ul>
            </li>

            <!-- Manage Stock -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="file"></i>
                    <span>Manage Stock</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="ti-more"></i>Product Stock</a></li>
                </ul>
            </li>

            <!-- User Interface -->
            <li class="header nav-small-cap">User Interface</li>

            <!-- Orders -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="file"></i>
                    <span>Orders</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="ti-more"></i>Pending Orders</a></li>
                    <li><a href="#"><i class="ti-more"></i>Confirmed Orders</a></li>
                    <li><a href="#"><i class="ti-more"></i>Processing Orders</a></li>
                    <li><a href="#"><i class="ti-more"></i>Picked Orders</a></li>
                </ul>
            </li>
        </ul>
    </section>

    <div class="sidebar-footer">
        <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="Email"><i class="ti-email"></i></a>
        <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="Logout"><i class="ti-lock"></i></a>
    </div>
</aside>
