<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>


                <li class="{{ request()->route()->getName() == 'admin.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('backend/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admission.*') ? 'active' : '' }}">
                    <a href="{{ route('admission.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Admissions</span>
                    </a>
                </li>


                <li class="{{ request()->routeIs('contact-message.*') ? 'active' : '' }}">
                    <a href="{{ route('contact-message.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/mail.svg') }}" alt="img">
                        <span>Contact Messages</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">
                    <a href="{{ route('gallery.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/product.svg') }}" alt="img">
                        <span>Gallery</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('school-class.*') ? 'active' : '' }}">
                    <a href="{{ route('school-class.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/product.svg') }}" alt="img">
                        <span>Classes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('section.*') ? 'active' : '' }}">
                    <a href="{{ route('section.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/quotation1.svg') }}" alt="img">
                        <span>Sections</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('student.*') ? 'active' : '' }}">
                    <a href="{{ route('student.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Students</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ request()->routeIs('attendance.*') ? 'subdrop active' : '' }}">
                        <img src="{{ asset('backend/assets/img/icons/calendars.svg') }}" alt="img">
                        <span>Attendance</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->routeIs('attendance.*') ? 'display:block' : '' }}">
                        <li><a href="{{ route('attendance.mark') }}" class="{{ request()->routeIs('attendance.mark') ? 'active' : '' }}">Mark Attendance</a></li>
                        <li><a href="{{ route('attendance.dashboard') }}" class="{{ request()->routeIs('attendance.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{ route('attendance.report') }}" class="{{ request()->routeIs('attendance.report*') ? 'active' : '' }}">Reports</a></li>
                        <li><a href="{{ route('attendance.holidays') }}" class="{{ request()->routeIs('attendance.holidays*') ? 'active' : '' }}">Holidays</a></li>
                    </ul>
                </li>
            </ul>



        </div>
    </div>
</div>