@extends('backend.layouts.layout')

@section('title', 'Admin Help & SOPs - King TAS College')

@section('content')
<style>
    .sop-hero {
        color: #fff;
        background: linear-gradient(125deg, #173b68 0%, #245c88 58%, #2f7b78 100%);
        border-radius: 12px;
        padding: 26px;
        margin-bottom: 20px;
    }
    .sop-hero h3 { color: #fff; margin-bottom: 8px; font-weight: 700; }
    .sop-hero p { color: rgba(255,255,255,.88); margin-bottom: 0; max-width: 850px; }
    .sop-toolbar { gap: 8px; }
    .sop-filter { border: 1px solid #dce3eb; border-radius: 20px; padding: 7px 13px; background: #fff; color: #394b59; font-size: 13px; }
    .sop-filter.active { background: #173b68; color: #fff; border-color: #173b68; }
    .sop-card { height: 100%; border: 1px solid #e3e8ef; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(20, 40, 60, .035); }
    .sop-card .card-body { padding: 20px; }
    .sop-category { display: inline-block; border-radius: 16px; background: #edf4f8; color: #245c88; padding: 4px 10px; font-size: 11px; font-weight: 700; margin-bottom: 10px; }
    .sop-card h5 { font-size: 16px; line-height: 1.4; font-weight: 700; margin-bottom: 7px; }
    .sop-summary { color: #6b7785; font-size: 13px; margin-bottom: 14px; }
    .sop-steps { padding-left: 20px; margin-bottom: 14px; }
    .sop-steps li { padding-left: 3px; margin-bottom: 8px; color: #394b59; font-size: 13px; line-height: 1.55; }
    .sop-tip { background: #f5f8fb; border-left: 3px solid #4f8aa8; padding: 10px 12px; border-radius: 4px; color: #536575; font-size: 12px; margin: 12px 0 15px; }
    .sop-empty { display: none; }
    .sop-shortcut { border: 1px solid #e3e8ef; border-radius: 8px; padding: 12px 14px; background: #fff; display: block; height: 100%; color: #34495e; text-decoration: none; }
    .sop-shortcut:hover { border-color: #8aaec3; color: #173b68; }
    .sop-shortcut strong { display: block; font-size: 13px; }
    .sop-shortcut span { display: block; color: #778390; font-size: 12px; margin-top: 3px; }
    @media print {
        #global-loader, .sidebar, .header, .page-header .page-btn, .sop-toolbar-wrap, .sop-shortcuts, .sop-action, .sop-filter, .no-print { display: none !important; }
        .main-wrapper, .page-content, .page-wrapper, .content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .sop-hero { background: #fff !important; color: #111 !important; border: 1px solid #bbb; padding: 14px; }
        .sop-hero h3, .sop-hero p { color: #111 !important; }
        .sop-card { box-shadow: none; break-inside: avoid; border-color: #bbb; }
        .sop-card .card-body { padding: 12px; }
        body { background: #fff !important; font-size: 11px; }
        .sop-steps li { font-size: 11px; }
        .sop-tip { background: #fff; }
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Admin Help &amp; SOPs</h4>
                <h6>Simple step-by-step instructions for the school office</h6>
            </div>
            <div class="page-btn sop-action d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-added" id="sopPrintButton">Print / Save as PDF</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">Back to Dashboard</a>
            </div>
        </div>

        <div class="sop-hero">
            <h3>How to use the school portal</h3>
            <p>This handbook explains the routine tasks in everyday language. Find a task below, follow the numbered steps, and use the shortcut button to open the related screen. You can print this page or save it as a PDF for staff training.</p>
        </div>

        <div class="alert alert-warning">
            <strong>Important:</strong> Check names, dates, class/section, and amounts before saving. For uncertain fee, attendance, or student-record changes, confirm with the person responsible before continuing.
        </div>

        <div class="card mb-4 sop-toolbar-wrap">
            <div class="card-body">
                <label for="sopSearch" class="form-label fw-bold">Find an instruction</label>
                <input type="search" id="sopSearch" class="form-control mb-3" placeholder="Search: add student, attendance, voucher, payment, password…" autocomplete="off">
                <div class="d-flex flex-wrap sop-toolbar" id="sopFilters">
                    <button type="button" class="sop-filter active" data-filter="all">All guides</button>
                    @foreach ($categories as $category)
                        <button type="button" class="sop-filter" data-filter="{{ \Illuminate\Support\Str::slug($category) }}">{{ $category }}</button>
                    @endforeach
                </div>
                <small class="text-muted d-block mt-3" id="sopCount">{{ count($guides) }} guides available</small>
            </div>
        </div>

        <div class="row g-3" id="sopGuideList">
            @foreach ($guides as $index => $guide)
                <div class="col-12 col-xl-6 sop-guide-item" data-category="{{ \Illuminate\Support\Str::slug($guide['category']) }}">
                    <article class="card sop-card">
                        <div class="card-body">
                            <span class="sop-category">{{ $guide['category'] }}</span>
                            <h5>{{ $index + 1 }}. {{ $guide['title'] }}</h5>
                            <p class="sop-summary">{{ $guide['summary'] }}</p>
                            <ol class="sop-steps">
                                @foreach ($guide['steps'] as $step)
                                    <li>{{ $step }}</li>
                                @endforeach
                            </ol>
                            @if (!empty($guide['tip']))
                                <div class="sop-tip"><strong>Helpful note:</strong> {{ $guide['tip'] }}</div>
                            @endif
                            @if (!empty($guide['route']) && \Illuminate\Support\Facades\Route::has($guide['route']))
                                <div class="sop-action">
                                    <a href="{{ route($guide['route']) }}" class="btn btn-sm btn-outline-primary">{{ $guide['link'] ?? 'Open page' }} &rarr;</a>
                                </div>
                            @endif
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="alert alert-info text-center mt-4 sop-empty" id="sopEmpty">
            No matching guide found. Try a shorter search such as “student”, “fees”, “attendance”, or choose All guides.
        </div>

        <div class="card mt-4 sop-shortcuts">
            <div class="card-body">
                <h5 class="mb-3">Quick links for common tasks</h5>
                <div class="row g-2">
                    <div class="col-6 col-lg-3"><a href="{{ route('student.index') }}" class="sop-shortcut"><strong>Students</strong><span>Find or add a student</span></a></div>
                    <div class="col-6 col-lg-3"><a href="{{ route('attendance.mark') }}" class="sop-shortcut"><strong>Mark Attendance</strong><span>Daily class attendance</span></a></div>
                    <div class="col-6 col-lg-3"><a href="{{ route('fees.vouchers') }}" class="sop-shortcut"><strong>Fee Vouchers</strong><span>Find and print vouchers</span></a></div>
                    <div class="col-6 col-lg-3"><a href="{{ route('fees.accounts') }}" class="sop-shortcut"><strong>Student Fee Status</strong><span>View paid and remaining dues</span></a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var searchInput = document.getElementById('sopSearch');
    var filterButtons = Array.prototype.slice.call(document.querySelectorAll('[data-filter]'));
    var cards = Array.prototype.slice.call(document.querySelectorAll('.sop-guide-item'));
    var emptyMessage = document.getElementById('sopEmpty');
    var countLabel = document.getElementById('sopCount');
    var printButton = document.getElementById('sopPrintButton');
    var activeCategory = 'all';

    function applyFilters() {
        var query = (searchInput.value || '').toLowerCase().trim();
        var visible = 0;

        cards.forEach(function (card) {
            var matchesCategory = activeCategory === 'all' || card.getAttribute('data-category') === activeCategory;
            var matchesText = query === '' || card.textContent.toLowerCase().indexOf(query) !== -1;
            var show = matchesCategory && matchesText;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        emptyMessage.style.display = visible === 0 ? 'block' : 'none';
        countLabel.textContent = visible + (visible === 1 ? ' guide shown' : ' guides shown');
    }

    function printAllGuides() {
        searchInput.value = '';
        activeCategory = 'all';
        filterButtons.forEach(function (item) {
            item.classList.toggle('active', item.getAttribute('data-filter') === 'all');
        });
        applyFilters();
        window.print();
    }

    searchInput.addEventListener('input', applyFilters);
    printButton.addEventListener('click', printAllGuides);

    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            activeCategory = button.getAttribute('data-filter');
            filterButtons.forEach(function (item) { item.classList.toggle('active', item === button); });
            applyFilters();
        });
    });
})();
</script>
@endsection
