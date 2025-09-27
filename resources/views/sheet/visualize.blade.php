@extends('tgg-fct.layouts.app')
@php
    $is_sidebar = false
@endphp

@section('content')
<div class="container">
    <h2>Auto Visualization</h2>

    <div style="margin-bottom:1rem;">
        <strong>Detected headers:</strong>
        <div>
            @foreach($headers as $h)
                <span style="display:inline-block;padding:4px 8px;border:1px solid #ddd;margin:2px;border-radius:4px;">{{ $h }}</span>
            @endforeach
        </div>
    </div>

    <div style="display:flex;gap:1rem;align-items:center;margin-bottom:1rem;">
        <div>
            <label>Label (X-axis)</label><br>
            <select id="labelSelect">
                <option value="">(Use row index)</option>
                @foreach($headers as $h)
                    <option value="{{ $h }}" {{ ($labelHeader && $labelHeader === $h) ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Datasets (choose numeric columns)</label><br>
            <select id="datasetSelect" multiple size="5" style="min-width:220px;">
                @foreach($numericCols as $h => $col)
                    <option value="{{ $h }}" selected>{{ $h }}</option>
                @endforeach
            </select>
            <div style="font-size:.85rem;color:#666">Hold Ctrl/Cmd to multi-select</div>
        </div>

        <div>
            <label>Chart Type</label><br>
            <select id="chartType">
                <option>line</option>
                <option>bar</option>
                <option>pie</option>
                <option>radar</option>
                <option>scatter</option>
            </select>
        </div>

        <div style="align-self:end;">
            <button id="renderBtn">Render Chart</button>
        </div>
    </div>

    <div style="margin-bottom:1rem;">
        <canvas id="autoChart" style="max-width:100%;"></canvas>
    </div>

    <h4>Preview (first rows)</h4>
    <div style="overflow:auto; max-height:240px;">
        <table border="1" cellpadding="6">
            <thead>
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
