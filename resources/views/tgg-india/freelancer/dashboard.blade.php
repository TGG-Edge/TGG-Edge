@extends('tgg-india.layouts.app')
@section('title', 'Dashboard | TGG Meta | TGG India')
@php
    use App\Models\Incentive;
    use App\Models\Reward;
    use App\Models\Donation;
    use App\Models\Payment;
    use App\Models\Invoice;
    use App\Models\Receipt;
    use App\Models\Referral;
    use App\Models\Enquiry;
    use App\Models\AssignmentSecondary;

    use Illuminate\Support\Facades\Schema;

    $invoiceStatus = Invoice::select('status', \DB::raw('count(*) as total'))
        ->where('source_id', auth('web2')->id())
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    // ✅ Receipt Status
    $receiptStatus = Receipt::select('status', \DB::raw('count(*) as total'))
        ->where('source_id', auth('web2')->id())
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    // ✅ Assignment Status
    $assignmentStatus = AssignmentSecondary::select('status', \DB::raw('count(*) as total'))
        ->where(function ($query) {
            $query->where('created_by', auth('web2')->id())->orWhere('assigned_to', auth('web2')->id());
        })
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    // ✅ Assignment Task Type Breakdown
    $assignmentTaskType = AssignmentSecondary::select('task_type', \DB::raw('count(*) as total'))
        ->where('created_by', auth('web2')->id())
        ->orWhere('assigned_to', auth('web2')->id())
        ->groupBy('task_type')
        ->pluck('total', 'task_type')
        ->toArray();

    // ✅ Assignment Count
    $assignmentCount = AssignmentSecondary::where(function ($query) {
        $query->where('created_by', auth('web2')->id())->orWhere('assigned_to', auth('web2')->id());
    })
        ->whereNull('parent_id')
        ->count();

    $mainAssignmentCount = AssignmentSecondary::where(function ($query) {
        $query->where('created_by', auth('web2')->id())->orWhere('assigned_to', auth('web2')->id());
    })->count();

    $subAssignmentCount = AssignmentSecondary::where(function ($query) {
        $query->where('created_by', auth('web2')->id())->orWhere('assigned_to', auth('web2')->id());
    })
        ->where('parent_id', '!=', null)
        ->count();

    // ✅ Enquiry Count
    $enquiryCount = Enquiry::where('referral_code', auth('web2')->user()->referral_code)->count();

    // ✅ Safe amount calculations
    if (Schema::connection('mysql2')->hasColumn('invoices', 'items')) {
        $invoiceAmount = Invoice::where('source_id', auth('web2')->id())
            ->get()
            ->sum(function ($invoice) {
                $items = $invoice->items;
                if (is_array($items)) {
                    return collect($items)->sum('amount');
                }
                return 0;
            });
    } else {
        $invoiceAmount = 0;
    }

    if (Schema::connection('mysql2')->hasColumn('receipts', 'items')) {
        $receiptAmount = Receipt::where('source_id', auth('web2')->id())
            ->get()
            ->sum(function ($receipt) {
                $items = $receipt->items;
                if (is_array($items)) {
                    return collect($items)->sum('amount');
                }
                return 0;
            });
    } else {
        $receiptAmount = 0;
    }

    // ==================== SUMMARY ARRAY ====================
    $summary = [
        [
            'title' => 'Invoices',
            'count' => array_sum($invoiceStatus),
            'icon' => 'bi-receipt',
            'color' => 'warning',
            'statuses' => $invoiceStatus,
            'amount' => $invoiceAmount,
        ],
        [
            'title' => 'Receipts',
            'count' => array_sum($receiptStatus),
            'icon' => 'bi-file-earmark-text',
            'color' => 'secondary',
            'statuses' => $receiptStatus,
            'amount' => $receiptAmount,
        ],
        [
            'title' => 'Assignments',
            'count' => $mainAssignmentCount,
            'icon' => 'bi-people',
            'color' => 'dark',
            'statuses' => $assignmentStatus,
        ],
        [
            'title' => 'Enquiry',
            'count' => $enquiryCount,
            'icon' => 'bi-heart',
            'color' => 'danger',
        ],
    ];
@endphp
@section('content')
    <style>
        .checkout-btn:hover {
            background-color: #0056b3 !important;
        }

        .checkout-btn-new:hover {
            background-color: #0056b3 !important;
        }

        .btn-inside-model {
            background: #265475;
            color: #fff;
        }

        .btn-inside-model:hover {
            background-color: #0056b3 !important;
            color: #fff !important;
        }

        .checkout-btn-tgg_foundation:hover {
            background-color: #0056b3 !important;
        }

        .dashboard-card {
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
        }

        .status-breakdown .progress {
            margin-bottom: 0.5rem;
        }

        .bg-opacity-10 {
            opacity: 0.1 !important;
        }

        .bg-opacity-20 {
            opacity: 0.2 !important;
        }
    </style>
    <div class="admin-container">
        @include('tgg-india.layouts.includes.message')
        <main class="dashboard-main mb-4">

            <!-- Welcome Note -->
            <div class="dashboard-grid-welcome">
                @php
                    $user = \App\Models\UserSecondary::find(auth('web2')->id());
                    $mainApplicant = \App\Models\UserSecondary::where(
                        'rhm_number',
                        $user->parent_rhm_number ?? '',
                    )->first();
                @endphp

                <div class="d-flex justify-content-end align-items-center flex-wrap gap-3 mb-2">
                    <span><strong>Name:</strong> {{ $user->name ?? 'N/A' }}</span>
                    <span><strong>Role:</strong> {{ $user->role_name ?? 'N/A' }}</span>
                    <span><strong>RHM No:</strong> {{ $user->rhm_number ?? 'N/A' }}</span>

                </div>
                <section class="welcome-note card">
                    <div class="card-inner-welcome">
                        <p id="expandWelcome" class="welcome-expand-note" style="text-align: justify;">{!! $showcase->welcome_note_freelancer ??
                            'Welcome to the Volunteer Dashboard! Explore the Woodperker collections, review entrepreneurship opportunities, and keep an eye on the latest updates below.' !!}
                        </p>
                        <span id="toggleExpandWelcome" class="text-primary"
                            style="cursor:pointer; display:none; font-weight:600;">
                            Read More
                        </span>
                    </div>
                </section>
            </div>

            <!-- Freelancing Opportunities -->
            <div class=" card opportunities mt-4">
                <h3 class="card-title">FREELANCING OPPORTUNITIES</h3>
                <div class="card-inner p-3">
                    @if (!empty($showcase->investment_opportunities))
                        @foreach ($showcase->investment_opportunities as $opportunity)
                            <div class="project-row">
                                <label class="project-left">
                                    <input type="radio" name="project" />
                                    <span>{{ $opportunity['title'] ?? '' }}</span>
                                </label>
                                <button class="btn-outline checkout-btn-new" data-note="{!! htmlspecialchars($opportunity['note'] ?? '', ENT_QUOTES) !!}"
                                    data-link="{{ $opportunity['link'] ?? '' }}" data-html="1">
                                    Details
                                </button>
                            </div>
                        @endforeach
                    @else
                        <p>No opportunities available</p>
                    @endif
                </div>
            </div>
        </main>

        <div class="row g-4 mb-5">

            @foreach ($summary as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card border-0 shadow-lg rounded-4 h-100 dashboard-card position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box bg-{{ $item['color'] }} bg-opacity-10 rounded-3 p-3">
                                    <i class="bi {{ $item['icon'] }} text-{{ $item['color'] }}"
                                        style="font-size: 2rem;"></i>
                                </div>
                                <span class="badge bg-{{ $item['color'] }} text-{{ $item['color'] }}"
                                    style="--bs-bg-opacity: 0.2;">
                                    {{ strtoupper($item['title']) }}
                                </span>
                            </div>

                            <h2 class="fw-bold text-dark mb-1">{{ $item['count'] }}</h2>

                            @if (isset($item['amount']))
                                <p class="text-muted small mb-3">Total Amount: ₹{{ number_format($item['amount'], 2) }}</p>
                            @else
                                <p class="text-muted small mb-3">{{ $item['title'] }} Total</p>
                            @endif

                            {{-- Status-wise breakdown --}}
                            @if (!empty($item['statuses']))
                                <div class="status-breakdown mt-3">
                                    @foreach ($item['statuses'] as $status => $total)
                                        <div class="d-flex justify-content-between small text-muted mb-1">
                                            <span class="text-capitalize">{{ $status }}</span>
                                            <span class="fw-semibold">{{ $total }}</span>
                                        </div>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-{{ $item['color'] }}" role="progressbar"
                                                style="width: {{ ($total / max(1, array_sum($item['statuses']))) * 100 }}%">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- =================== OVERVIEW SECTION =================== --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-light border-0 fw-semibold fs-5">
                Platform Overview
            </div>
            <div class="card-body">
                <p class="text-muted">
                    The dashboard provides a unified view of your contributions, assignments, and financial activities.
                    Below is an overview of your engagement, task types, and transactions across the platform.
                </p>

                <div class="row text-center mt-4">
                    <div class="col-md-3 mb-3">
                        <h5 class="fw-bold text-primary mb-0">{{ $assignmentCount }}</h5>
                        <small class="text-muted">Main Assignments</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h5 class="fw-bold text-secondary mb-0">{{ $subAssignmentCount }}</h5>
                        <small class="text-muted">Sub Assignments</small>
                    </div>
                </div>

                {{-- ====== Assignment Task Type Breakdown ====== --}}
                @if (!empty($assignmentTaskType))
                    <hr class="my-4">
                    <h6 class="fw-semibold text-dark mb-3">Assignment Distribution by Task Type</h6>

                    <div class="row">
                        <div class="col-md-6">
                            @foreach ($assignmentTaskType as $taskType => $total)
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span class="text-capitalize">{{ $taskType }}</span>
                                    <span class="fw-semibold">{{ $total }}</span>
                                </div>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ ($total / max(1, array_sum($assignmentTaskType))) * 100 }}%">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <canvas id="taskTypeChart" height="120"></canvas>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- =================== VENTURE BENCH SUPPORT =================== --}}
    <section class="vb-support-section rounded-4 mt-4">
        <h3 class="card-title p-3">VENTURE BENCH SUPPORT</h3>

        <div class="container">
            <div class="row g-4">

                @foreach (getVentureBenchSupportDashbaordData() as $service)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="vb-service-card text-center rounded-4">

                            <div class="vb-service-image">
                                <img src="{{ asset($service['logo']) }}" alt="{{ $service['title'] }}">
                            </div>

                            <h6 class="fw-bold text-dark my-3">
                                {{ strtoupper($service['title']) }}
                            </h6>

                        </div>
                    </div>
                @endforeach

            </div>

            {{-- See More Button --}}
            {{-- <div class="text-center py-3 d-flex justify-content-center">
                <a href="{{ route('tgg-india.venture-bench-services.index', ['role' => auth('web2')->user()->role_key]) }}"
                    class="btn-outline small text-white checkout-vb-service-btn" style="text-decoration: none;">
                    See More Details
                </a>
            </div> --}}
        </div>
    </section>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 1000px;">
            <div class="modal-content a4-modal">
                <div class="modal-header">
                    <h5 class="modal-title">Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="checkoutModalBody">
                    <!-- Dynamic content goes here -->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ==========================
        // Modal handling
        // ==========================
        const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        // const checkoutModalBody = document.getElementById('checkoutModalBody');

        document.querySelectorAll('.checkout-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');
                if (isHtml) {
                    checkoutModalBody.innerHTML = note;
                } else {
                    checkoutModalBody.textContent = note || 'No details available.';
                }
                checkoutModal.show();
            });
        });

        document.querySelectorAll('.checkout-btn-new').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const link = this.dataset.link || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');

                let content = '';
                if (isHtml) {
                    content = note;
                } else {
                    content = `<p>${note || 'No details available.'}</p>`;
                }

                if (link) {
                    content += `<div class="mt-3 " style="text-align: center;">
                        <a href="${link}" target="_blank" class="btn btn-inside-model">Apply</a>
                    </div>`;
                }

                checkoutModalBody.innerHTML = content;
                checkoutModal.show();
            });
        });

        document.querySelectorAll('.checkout-btn-tgg_foundation').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const link = this.dataset.link || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');

                let content = '';
                if (isHtml) {
                    content = note;
                } else {
                    content = `<p>${note || 'No details available.'}</p>`;
                }

                if (link) {
                    content += `<div class="mt-3 text-center">
                <a href="${link}" target="_blank" class="btn btn-inside-model">Donate</a>
                </div>`;
                }

                checkoutModalBody.innerHTML = content;
                checkoutModal.show();
            });
        });



        document.querySelectorAll('.modal .close-btn').forEach(close => {
            close.addEventListener('click', () => {
                close.closest('.modal').style.display = 'none';
            });
        });

        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });
    </script>

    <script>
        @if (!empty($assignmentTaskType))
            const ctx = document.getElementById('taskTypeChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($assignmentTaskType)),
                    datasets: [{
                        data: @json(array_values($assignmentTaskType)),
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#20c997', '#6f42c1'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    return `${ctx.label}: ${ctx.parsed} assignments`;
                                }
                            }
                        }
                    }
                }
            });
        @endif
    </script>
    <script>
        // ==========================
        // Modal handling
        // ==========================
        const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        // const checkoutModalBody = document.getElementById('checkoutModalBody');

        document.querySelectorAll('.checkout-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');
                if (isHtml) {
                    checkoutModalBody.innerHTML = note;
                } else {
                    checkoutModalBody.textContent = note || 'No details available.';
                }
                checkoutModal.show();
            });
        });

        document.querySelectorAll('.checkout-btn-new').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const link = this.dataset.link || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');

                let content = '';
                if (isHtml) {
                    content = note;
                } else {
                    content = `<p>${note || 'No details available.'}</p>`;
                }

                if (link) {
                    content += `<div class="mt-3 " style="text-align: center;">
                        <a href="${link}" target="_blank" class="btn btn-inside-model">Apply</a>
                    </div>`;
                }

                checkoutModalBody.innerHTML = content;
                checkoutModal.show();
            });
        });

        document.querySelectorAll('.checkout-btn-tgg_foundation').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const link = this.dataset.link || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');

                let content = '';
                if (isHtml) {
                    content = note;
                } else {
                    content = `<p>${note || 'No details available.'}</p>`;
                }

                if (link) {
                    content += `<div class="mt-3 text-center">
                <a href="${link}" target="_blank" class="btn btn-inside-model">Donate</a>
            </div>`;
                }

                checkoutModalBody.innerHTML = content;
                checkoutModal.show();
            });
        });



        document.querySelectorAll('.modal .close-btn').forEach(close => {
            close.addEventListener('click', () => {
                close.closest('.modal').style.display = 'none';
            });
        });

        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });

        // ==========================
        // Auto slider handling
        // ==========================
        document.addEventListener('DOMContentLoaded', () => {
            const INTERVAL = 5000;
            document.querySelectorAll('.slider').forEach(slider => {
                const slides = slider.querySelectorAll('.slide');
                if (slides.length <= 1) return;
                let index = 0;
                const goTo = i => {
                    slider.scrollTo({
                        left: slider.clientWidth * i,
                        behavior: 'smooth'
                    });
                };
                setInterval(() => {
                    index = (index + 1) % slides.length;
                    goTo(index);
                }, INTERVAL);
            });
        });


        document.addEventListener('DOMContentLoaded', () => {
            const INTERVAL = 5000;
            document.querySelectorAll('.slider1').forEach(slider => {
                const slides = slider.querySelectorAll('.slide');
                if (slides.length <= 1) return;
                let index = 0;
                const goTo = i => {
                    slider.scrollTo({
                        left: slider.clientWidth * i,
                        behavior: 'smooth'
                    });
                };
                setInterval(() => {
                    index = (index + 1) % slides.length;
                    goTo(index);
                }, INTERVAL);
            });
        });
    </script>
@endpush
