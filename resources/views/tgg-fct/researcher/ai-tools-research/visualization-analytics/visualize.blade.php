@extends('tgg-fct.layouts.app')
@section('title', 'Visualize | Data Visualization | AI Tools & Research Systems | Tgg Edge | Tgg Fct')

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="page-header">
       <h3 class=" knowledge">
            <i class="fas fa-chart-bar text-primary me-2"></i>
            Visualization & Analytics of Uploaded Sheet
        </h3>
        <p style=" color: #555; font-size: 10px;">
           Transform your uploaded data into interactive visual insights.
        </p>
    </div>

    
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body">
            <!-- Detected headers -->
            <div class="mb-3">
                <strong>Detected Headers:</strong>
                <div class="mt-2">
                    @foreach($headers as $h)
                        <span class="badge bg-light text-dark border me-1">{{ $h }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Controls Row -->
            <div class="row g-3 align-items-end mb-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Label (X-axis)</label>
                    <select id="labelSelect" class="form-select">
                        <option value="">(Use row index)</option>
                        @foreach($headers as $h)
                            <option value="{{ $h }}" {{ ($labelHeader && $labelHeader === $h) ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Datasets (numeric columns)</label>
                    <select id="datasetSelect" multiple size="5" class="form-select">
                        @foreach($numericCols as $h => $col)
                            <option value="{{ $h }}" selected>{{ $h }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl/Cmd to multi-select</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Chart Type</label>
                    <select id="chartType" class="form-select select2">
                        <option>line</option>
                        <option>bar</option>
                        <option>pie</option>
                        <option>radar</option>
                        <option>scatter</option>
                    </select>
                </div>

                <div class="col-md-6 text-md-end">
                    <button id="renderBtn" class="btn btn-primary ">
                        <i class="fas fa-play me-1"></i> Render Chart
                    </button>
                </div>
            </div>

            <!-- Chart Canvas -->
            <div class="mb-3">
                <canvas id="autoChart" style="max-width:100%; height:400px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Preview -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h5 class="mb-3"><i class="fas fa-table me-2 text-primary"></i>Preview (first rows)</h5>
            <div class="table-responsive" style="max-height: 300px; overflow:auto;">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            @foreach($headers as $h)<th>{{ $h }}</th>@endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preview as $row)
                            <tr>
                                @foreach($headers as $i => $h)
                                    <td>{{ $row[$i] ?? '' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // data passed from server
    const columns = @json($columns);
    const numericCols = @json($numericCols);
    const stringCols = @json($stringCols);
    const initialLabels = @json($labels);

    // helper: generate color by index
    function colorFor(i) {
        const h = (i * 47) % 360;
        return `hsl(${h} 70% 50%)`;
    }

    let chartInstance = null;

    function buildDatasets(selectedDatasets, labelsArr, type) {
        const datasets = [];
        let idx = 0;

        selectedDatasets.forEach(name => {
            const col = columns[name] || numericCols[name];
            if (!col) return;

            // convert to numbers or nulls and align length with labels
            const data = labelsArr.map((_, i) => {
                const v = col[i];
                if (v === null || v === '') return null;
                return isFinite(Number(v)) ? Number(v) : null;
            });

            // For 'pie' Chart.js expects a single dataset with many labels (one dataset). We'll still give user control,
            // but the UI warns if multiple selected for pie.
            datasets.push({
                label: name,
                data: data,
                borderWidth: 2,
                backgroundColor: colorFor(idx),
                borderColor: colorFor(idx),
                fill: false
            });
            idx++;
        });

        return datasets;
    }

    function getSelectedValues(selectElem) {
        return Array.from(selectElem.selectedOptions).map(o => o.value);
    }

    function renderChart() {
        const labelSelect = document.getElementById('labelSelect');
        const datasetSelect = document.getElementById('datasetSelect');
        const chartType = document.getElementById('chartType').value;

        // build labels
        let labelsArr;
        if (labelSelect.value) {
            labelsArr = columns[labelSelect.value] || stringCols[labelSelect.value];
        } else {
            // fallback to numeric length from first numeric column or initialLabels
            labelsArr = initialLabels && initialLabels.length ? initialLabels : [];
        }

        const selectedDatasets = getSelectedValues(datasetSelect);
        if (chartType === 'pie' && selectedDatasets.length > 1) {
            alert('Pie chart typically uses a single dataset. Please select only one dataset for pie.');
            return;
        }
        if (selectedDatasets.length === 0) {
            alert('Please select at least one numeric column to visualize.');
            return;
        }

        const datasets = buildDatasets(selectedDatasets, labelsArr, chartType);

        // Chart.js expects data shape specific to chart types:
        let config;
        if (chartType === 'pie') {
            // One dataset where each label is a slice
            config = {
                type: 'pie',
                data: {
                    labels: labelsArr,
                    datasets: [{
                        label: selectedDatasets[0],
                        data: datasets[0].data,
                        backgroundColor: labelsArr.map((_,i) => colorFor(i)),
                    }]
                },
                options: { responsive: true }
            };
        } else if (chartType === 'scatter') {
            // scatter -> convert to [{x:label,y:value},...]
            // This will use first selected dataset only for scatter (multi-scatter needs custom logic)
            const s = datasets[0];
            const scatterData = s.data.map((y, i) => {
                return { x: labelsArr[i], y: y };
            });
            config = {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: s.label,
                        data: scatterData,
                        backgroundColor: s.backgroundColor
                    }]
                },
                options: { responsive: true, scales: { x: { type: 'category' } } }
            };
        } else {
            config = {
                type: chartType,
                data: {
                    labels: labelsArr,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Auto Generated Visualization' }
                    }
                }
            };
        }

        const ctx = document.getElementById('autoChart');
        if (chartInstance) chartInstance.destroy();
        chartInstance = new Chart(ctx, config);
    }

    document.getElementById('renderBtn').addEventListener('click', function(e){
        e.preventDefault();
        renderChart();
    });

    // auto-render on load with defaults
    window.addEventListener('DOMContentLoaded', function(){
        renderChart();
    });
</script>
@endsection
