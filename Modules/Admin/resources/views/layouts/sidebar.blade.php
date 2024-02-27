<aside class="main-sidebar sidebar-dark-primary elevation-4"> 
    <a href="{{ url('admin/dashboard')}}" class="brand-link"> 
        <img src="{{ asset('public/assets/images/truck.jpg')}}" alt="Truck Logo" class="brand-image img-circle elevation-3" > 
        <span class="brand-text font-weight-bold"><b>Truck Management</b></span> 
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item"> 
                    <a href="{{ url('admin/dashboard')}}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/truck')}}" class="nav-link {{ Request::is('admin/truck') || Request::is('admin/truck/add') ? 'active' : ''}}"> <i class="fa-solid fa-truck"></i>&nbsp;&nbsp;
                        <p>Trucks</p>
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/drivers')}}" class="nav-link {{ Request::is('admin/drivers') || Request::is('admin/drivers/add') ? 'active' : ''}}"> <i class="fa-solid fa-user"></i>&nbsp;&nbsp;
                        <p>Drivers</p>
                    </a> 
                </li>
                @if(Auth::guard('admin')->user()->type=="admin")
                    <li class="nav-item"> 
                        <a href="{{ url('admin/office-expense')}}" class="nav-link {{ Request::is('admin/office-expense') || Request::is('admin/office-expense-add/add') ? 'active' : ''}}"><i class="fa-solid fa-money-bill-trend-up"></i>&nbsp;&nbsp;
                            <p>Office Expense</p>
                        </a> 
                    </li>
                    <li class="nav-item"> 
                        <a href="{{ url('admin/reports')}}" class="nav-link {{ Request::is('admin/reports') ? 'active' : ''}}"><i class="fa-solid fa-money-bill-trend-up"></i>&nbsp;&nbsp;
                            <p>Reports</p>
                        </a> 
                    </li>
                    <li class="nav-item"> 
                        <a href="{{ url('admin/subadmins')}}" class="nav-link {{ Request::is('admin/subadmins') || Request::is('admin/subadmins/add') ? 'active' : ''}}"> <i class="fa-solid fa-users"></i>&nbsp;&nbsp;
                            <p>SubAdmins</p>
                        </a> 
                    </li>
                @endif
                 <li class="nav-item"> 
                    <a href="#" class="nav-link {{ Request::is('admin/trips/add') || Request::is('admin/pending-trips') || Request::is('admin/ongoing-trips') || Request::is('admin/completed-trips') ? 'active' : ''}}"> <i class="fa-solid fa-suitcase-rolling"></i>
                        &nbsp;&nbsp;<p> Trips <i class="fas fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> 
                            <a href="{{ url('admin/trips/add')}}" class="nav-link {{ Request::is('admin/trips/add') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p>Create Trips</p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="{{ url('admin/pending-trips')}}" class="nav-link {{ Request::is('admin/pending-trips') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Pending Trips </p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="{{ url('admin/ongoing-trips')}}" class="nav-link {{ Request::is('admin/ongoing-trips') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p>Ongoing Trips </p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="{{ url('admin/completed-trips')}}" class="nav-link {{ Request::is('admin/completed-trips') ? 'active' : '' }}"> <i class="far fa-circle nav-icon"></i>
                                <p>Completed Trips </p>
                            </a> 
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item"> 
                    <a href="#" class="nav-link {{ Request::is('admin/currency') || Request::is('admin/category') || Request::is('admin/privacy-policy') || Request::is('admin/terms-and-conditions') ? 'active' : ''}}"> <i class="fa-solid fa-gear"></i>
                        <p> Settings <i class="fas fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> 
                            <a href="{{ url('admin/currency')}}" class="nav-link {{ Request::is('admin/currency') || Request::is('admin/currency/add') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Currency </p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="{{ url('admin/category')}}" class="nav-link {{ Request::is('admin/category') || Request::is('admin/category/add') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Category </p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="{{ url('admin/privacy-policy')}}" class="nav-link {{ Request::is('admin/privacy-policy') || Request::is('admin/edit-privacy-policy') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Privacy Policy </p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="{{ url('admin/terms-and-conditions')}}" class="nav-link {{ Request::is('admin/terms-and-conditions') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p>Terms & Conditions</p>
                            </a> 
                        </li>
                        {{-- <li class="nav-item"> 
                            <a href="{{ url('admin/change_password')}}" class="nav-link {{ Request::is('admin/change_password') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Change Password </p>
                            </a> 
                        </li> --}}
                    </ul>
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/logout')}}" class="nav-link"> <i class="nav-icon fas fa-th"></i>
                        <p> Logout </p>
                    </a> 
                </li>
            </ul>
        </nav>
    </div>
</aside>