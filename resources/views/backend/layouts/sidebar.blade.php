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

          
                <li class="{{ request()->routeIs('contact-message.*') ? 'active' : '' }}">
                    <a href="{{ route('contact-message.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/mail.svg') }}" alt="img">
                        <span>Contact Messages</span>                       
                    </a>
                </li>

            </ul>



        </div>
    </div>
</div>
