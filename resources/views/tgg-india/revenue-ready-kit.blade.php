@extends('tgg-india.layouts.app')

@section('title', 'Revenue Ready Kit | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    {{-- Page Header (Like Feature Limits) --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="mb-3 trainer-heading">Revenue Ready Kit</h4>
    </div>
    {{-- Services Grid --}}
    <div class="row g-4">
        @php
            $key = str_replace('-', '_', request()->route('slug'));
        @endphp
        @foreach(getRevenueReadyKit()[$key]['details'] as $index => $item)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex flex-column text-center">

                        <img src="{{ asset($item['image']) }}"
                         class="img-fluid mb-3 rounded-3"
                         style="max-height:160px; object-fit:cover;"
                         alt="{{ $item['title'] }}">

                        <h5 class="fw-semibold mb-2">
                            {{ $item['title'] }}
                        </h5>

                        <!-- <p class="text-muted small mb-3">
                            {!! $item['description'] ?? '' !!}
                        </p> -->
                        <!-- Modicare -->
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{$item['link']}}"  class="get-more-btn"><span class="btn-text">Login</span> </a>
                                <button type="button" class="get-more-btn"
                                    data-modal
                                    data-img="{{ asset($item['image']) ?? '#'}}"
                                    data-title="{{ $item['title'] ?? '' }}"
                                    data-note="{{ ($item['description'] ?? '') }}"
                                    data-link="{{ $item['link'] ?? '' }}"
                                    ><span class="btn-text">Information</span> 
                                </button>
                            </div>


                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
