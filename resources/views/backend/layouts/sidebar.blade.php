@php
// Active menu states
$admissionOpen = request()->routeIs('admission.*');
$studentOpen = request()->routeIs('student.*');
$academicOpen = request()->routeIs('school-class.*', 'section.*');

$attendanceOpen = request()->routeIs(
'attendance.mark',
'attendance.save',
'attendance.holidays*'
);

$attendanceReportsOpen = request()->routeIs(
'attendance.dashboard',
'attendance.report*'
);

$feeOperationsOpen = request()->routeIs(
'fees.dashboard',
'fees.vouchers*',
'fees.payments*'
);

$feeSetupOpen = request()->routeIs(
'fees.accounts*',
'fees.plans.bulk*',
'fees.structures*',
'fees.settings*'
);

$websiteOpen = request()->routeIs(
'contact-message.*',
'gallery.*'
);

$helpOpen = request()->routeIs('admin.help');

$quickActionsOpen = false;
@endphp

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>

                {{-- Dashboard --}}
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('backend/assets/img/icons/dashboard.svg') }}" alt="">
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Quick Actions --}}
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $quickActionsOpen ? 'subdrop' : '' }}">
                        <img src="{{ asset('backend/assets/img/icons/plus-circle.svg') }}" alt="">
                        <span>Quick Actions</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ $quickActionsOpen ? 'display:block;' : 'display:none;' }}">
                        <li>
                            <a href="{{ route('student.create') }}">
                                <i class="ti ti-user-plus"></i>
                                Add Student
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attendance.mark') }}">
                                <i class="ti ti-calendar-check"></i>
                                Mark Attendance
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('fees.vouchers.create') }}">
                                <i class="ti ti-file-invoice"></i>
                                Create Fee Voucher
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('fees.payments.create') }}">
                                <i class="ti ti-cash"></i>
                                Receive Payment
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Admissions --}}
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $admissionOpen ? 'subdrop' : '' }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="">
                        <span>Admissions</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ $admissionOpen ? 'display:block;' : 'display:none;' }}">
                        <li>
                            <a href="{{ route('admission.index') }}"
                                class="{{ request()->routeIs('admission.index') && !request('status') ? 'active' : '' }}">
                                All Applications
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admission.index', ['status' => 'pending']) }}"
                                class="{{ request('status') === 'pending' ? 'active' : '' }}">
                                Pending
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admission.index', ['status' => 'under_review']) }}"
                                class="{{ request('status') === 'under_review' ? 'active' : '' }}">
                                Under Review
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admission.index', ['status' => 'documents_required']) }}"
                                class="{{ request('status') === 'documents_required' ? 'active' : '' }}">
                                Documents Required
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admission.index', ['status' => 'approved']) }}"
                                class="{{ request('status') === 'approved' ? 'active' : '' }}">
                                Approved
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Student Management --}}
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $studentOpen ? 'subdrop' : '' }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="">
                        <span>Students</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ $studentOpen ? 'display:block;' : 'display:none;' }}">
                        <li>
                            <a href="{{ route('student.index') }}"
                                class="{{ request()->routeIs('student.index') && !request('trashed') ? 'active' : '' }}">
                                All Students
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.create') }}"
                                class="{{ request()->routeIs('student.create') ? 'active' : '' }}">
                                Add New
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.import') }}"
                                class="{{ request()->routeIs('student.import*') ? 'active' : '' }}">
                                Import Students
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.index', ['trashed' => 1]) }}"
                                class="{{ request()->routeIs('student.index') && request('trashed') ? 'active' : '' }}">
                                Deleted Students
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Academic Management --}}
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $academicOpen ? 'subdrop' : '' }}">
                        <img src="{{ asset('backend/assets/img/icons/product.svg') }}" alt="">
                        <span>Academic</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ $academicOpen ? 'display:block;' : 'display:none;' }}">
                        <li>
                            <a href="{{ route('school-class.index') }}"
                                class="{{ request()->routeIs('school-class.*') ? 'active' : '' }}">
                                Classes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('section.index') }}"
                                class="{{ request()->routeIs('section.*') ? 'active' : '' }}">
                                Sections
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Attendance Management --}}
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $attendanceOpen ? 'subdrop' : '' }}">
                        <img src="{{ asset('backend/assets/img/icons/calendars.svg') }}" alt="">
                        <span>Attendance</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ $attendanceOpen ? 'display:block;' : 'display:none;' }}">
                        <li>
                            <a href="{{ route('attendance.mark') }}"
                                class="{{ request()->routeIs('attendance.mark', 'attendance.save') ? 'active' : '' }}">
                                Mark Attendance
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attendance.dashboard') }}"
                                class="{{ request()->routeIs('attendance.dashboard') ? 'active' : '' }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attendance.report') }}"
                                class="{{ request()->routeIs('attendance.report*') ? 'active' : '' }}">
                                Reports
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attendance.holidays') }}"
                                class="{{ request()->routeIs('attendance.holidays*') ? 'active' : '' }}">
                                Holidays
                            </a>
                        </li>
                    </ul>
                </li>



                {{-- Fee Operations --}}
              <li class="submenu">
    <a href="javascript:void(0);" class="{{ $feeOperationsOpen ? 'subdrop' : '' }}">
        <img src="{{ asset('backend/assets/img/icons/dollar-square.svg') }}" alt="">
        <span>Manage Fees</span>
        <span class="menu-arrow"></span>
    </a>

    <ul style="{{ $feeOperationsOpen ? 'display:block;' : 'display:none;' }}">
        {{-- Section 1: Daily Operations --}}
        <li>
            <a href="{{ route('fees.dashboard') }}" class="{{ request()->routeIs('fees.dashboard') ? 'active' : '' }}">
                Fee Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('fees.vouchers.create') }}" class="{{ request()->routeIs('fees.vouchers.create') ? 'active' : '' }}">
                Create Voucher
            </a>
        </li>
        <li>
            <a href="{{ route('fees.vouchers.bulk') }}" class="{{ request()->routeIs('fees.vouchers.bulk*') ? 'active' : '' }}">
                Bulk Vouchers
            </a>
        </li>
        <li>
            <a href="{{ route('fees.vouchers') }}" class="{{ request()->routeIs('fees.vouchers') || request()->routeIs('fees.vouchers.show') ? 'active' : '' }}">
                All Vouchers
            </a>
        </li>
        <li>
            <a href="{{ route('fees.payments.create') }}" class="{{ request()->routeIs('fees.payments.create') ? 'active' : '' }}">
                Receive Payment
            </a>
        </li>
        <li>
            <a href="{{ route('fees.payments') }}" class="{{ request()->routeIs('fees.payments*') ? 'active' : '' }}">
                Payment Records
            </a>
        </li>

        {{-- Valid Semantic Separator --}}
        <li>
            <hr class="my-1 border-0" style="border-top: 1px solid rgba(0, 0, 0, 0.08); margin: 6px 15px;">
        </li>

        {{-- Section 2: Setup & Configuration --}}
        <li>
            <a href="{{ route('fees.accounts') }}" class="{{ request()->routeIs('fees.accounts*') ? 'active' : '' }}">
                Account Books
            </a>
        </li>
        <li>
            <a href="{{ route('fees.plans.bulk') }}" class="{{ request()->routeIs('fees.plans.bulk*') ? 'active' : '' }}">
                Bulk Fee Plans
            </a>
        </li>
        <li>
            <a href="{{ route('fees.structures.index') }}" class="{{ request()->routeIs('fees.structures*') ? 'active' : '' }}">
                Class Fee Amounts
            </a>
        </li>
        <li>
            <a href="{{ route('fees.settings') }}" class="{{ request()->routeIs('fees.settings*') ? 'active' : '' }}">
                Fee Settings
            </a>
        </li>
    </ul>
</li>



                {{-- Website Content --}}
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $websiteOpen ? 'subdrop' : '' }}">
                        <img src="{{ asset('backend/assets/img/icons/mail.svg') }}" alt="">
                        <span>Website Content</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ $websiteOpen ? 'display:block;' : 'display:none;' }}">
                        <li>
                            <a href="{{ route('contact-message.index') }}"
                                class="{{ request()->routeIs('contact-message.*') ? 'active' : '' }}">
                                Messages
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gallery.index') }}"
                                class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">
                                Gallery
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Help & SOPs --}}
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $helpOpen ? 'subdrop' : '' }}">
                        <i class="me-2"
                            data-feather="help-circle"></i> <span>Help</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ $helpOpen ? 'display:block;' : 'display:none;' }}">
                        <li>
                            <a href="{{ route('admin.help') }}"
                                class="{{ request()->routeIs('admin.help') ? 'active' : '' }}">
                                User Guide
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>