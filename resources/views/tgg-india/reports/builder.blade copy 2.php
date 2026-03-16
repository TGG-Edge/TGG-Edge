@extends('tgg-india.layouts.app')

@section('title', 'Report Generator | TGG Meta | TGG India')
@push('styles')
<style>
.container {
    max-width: 1200px;
    margin: auto;
}

.card {
    background: white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
}

button {
    padding: 10px 20px;
    border: none;
    background: #2d6cdf;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background: #1b4eb1;
}

.grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.report-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.summary-box {
    background: #2d6cdf;
    color: white;
    padding: 20px;
    border-radius: 5px;
    font-size: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    border: 1px solid #ddd;
    padding: 8px;
    font-size: 13px;
}

#barChart,
#lineChart,
#pieChart {
    min-height: 300px;
}
</style>
@endpush


@section('content')

<div class="container" x-data="reportBuilder()" x-init="init()">

    <h1>Dynamic Report Builder</h1>

    <!-- MODEL -->
    <div class="card">

        <h3>Select Model</h3>

        <select x-model="model" @change="loadRelations()">
            <option value="">Select Model</option>

            <template x-for="(className,key) in models">
                <option :value="className" x-text="key"></option>
            </template>

        </select>

    </div>


    <!-- RELATIONS -->

    <template x-for="(relation,index) in relationLevels">

        <div class="card">

            <h3>Select Relation</h3>

            <select x-model="selectedRelations[index]" @change="loadNextRelation(index)">

                <option value="">Select Relation</option>

                <template x-for="(className,name) in relation">
                    <option :value="name" x-text="name"></option>
                </template>

            </select>

        </div>

    </template>


    <!-- REPORT TYPES -->

    <div class="card">

        <h3>Report Types</h3>

        <div class="grid">

            <label><input type="checkbox" value="summary" x-model="reports"> Summary</label>

            <label><input type="checkbox" value="table" x-model="reports"> Table</label>

            <label><input type="checkbox" value="bar_chart" x-model="reports"> Bar Chart</label>

            <label><input type="checkbox" value="line_chart" x-model="reports"> Line Chart</label>

            <label><input type="checkbox" value="pie_chart" x-model="reports"> Pie Chart</label>

            <label><input type="checkbox" value="top_records" x-model="reports"> Top Records</label>

            <label><input type="checkbox" value="comparison" x-model="reports"> Comparison</label>

            <label><input type="checkbox" value="timeline" x-model="reports"> Timeline</label>

            <label><input type="checkbox" value="growth" x-model="reports"> Growth</label>

        </div>

        <br>

        <button @click="generateReport()">Generate Report</button>

        <button onclick="window.print()">Print All Reports</button>

    </div>


    <!-- OUTPUT -->

    <div class="report-grid">


        <!-- SUMMARY -->

        <template x-if="reportData.summary">

            <div class="card">

                <h3>Summary</h3>

                <div class="summary-box">

                    Total Records:

                    <span x-text="reportData.summary.total_records"></span>

                </div>

            </div>

        </template>


        <!-- BAR -->

        <div class="card" x-show="reportData.bar_chart">

            <h3>Bar Chart</h3>

            <div id="barChart"></div>

        </div>


        <!-- LINE -->

        <div class="card" x-show="reportData.line_chart">

            <h3>Line Chart</h3>

            <div id="lineChart"></div>

        </div>


        <!-- PIE -->

        <div class="card" x-show="reportData.pie_chart">

            <h3>Pie Chart</h3>

            <div id="pieChart"></div>

        </div>


        <!-- TABLE -->

        <div class="card" x-show="reportData.table">

            <h3>Table Report</h3>

            <div style="overflow:auto">

                <table>

                    <thead>

                        <tr>

                            <template x-for="(value,key) in reportData.table[0]">

                                <th x-text="key"></th>

                            </template>

                        </tr>

                    </thead>

                    <tbody>

                        <template x-for="row in reportData.table">

                            <tr>

                                <template x-for="(value,key) in row">

                                    <td x-text="value"></td>

                                </template>

                            </tr>

                        </template>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- TOP RECORDS -->

        <div class="card" x-show="reportData.top_records">

            <h3>Top Records</h3>

            <ul>

                <template x-for="row in reportData.top_records">

                    <li x-text="JSON.stringify(row)"></li>

                </template>

            </ul>

        </div>


        <!-- COMPARISON -->

        <div class="card" x-show="reportData.comparison">

            <h3>Comparison</h3>

            <p>Current Month: <strong x-text="reportData.comparison.current_month"></strong></p>

            <p>Previous Month: <strong x-text="reportData.comparison.previous_month"></strong></p>

        </div>


        <!-- TIMELINE -->

        <div class="card" x-show="reportData.timeline">

            <h3>Timeline</h3>

            <ul>

                <template x-for="row in reportData.timeline">

                    <li>

                        <span x-text="row.id"></span> -
                        <span x-text="row.created_at"></span>

                    </li>

                </template>

            </ul>

        </div>


        <!-- GROWTH -->

        <div class="card" x-show="reportData.growth">

            <h3>Growth</h3>

            <p>Total Records: <strong x-text="reportData.growth.total_records"></strong></p>

            <p>First Record: <strong x-text="reportData.growth.first_record_date"></strong></p>

            <p>Latest Record: <strong x-text="reportData.growth.latest_record_date"></strong></p>

        </div>


    </div>

</div>

@endsection



@push('scripts')

<script src="https://unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('alpine:init', () => {

    Alpine.data('reportBuilder', () => ({

        model: '',
        models: {},

        relationLevels: [],
        selectedRelations: [],

        reports: ['summary', 'table', 'bar_chart'],

        reportData: {},

        barChart: null,
        lineChart: null,
        pieChart: null,


        init() {

            fetch('/reports/models')
                .then(res => res.json())
                .then(data => {
                    this.models = data
                })

        },


        loadRelations() {

            this.relationLevels = []
            this.selectedRelations = []

            fetch('/reports/relations', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content
                    },
                    body: JSON.stringify({
                        model: this.model
                    })
                })
                .then(res => res.json())
                .then(data => {
                    this.relationLevels.push(data)
                })

        },


        loadNextRelation(index) {

            let relation = this.selectedRelations[index]
            let relationClass = this.relationLevels[index][relation]

            fetch('/reports/relations', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content
                    },
                    // body: JSON.stringify({
                    //     model: relationClass
                    // })
                    body: JSON.stringify({
                        model: relationClass,
                        visited: [
                            this.model,
                            ...this.selectedRelations.map((rel, i) => {
                                if(!rel) return null
                                return this.relationLevels[i][rel]
                            }).filter(Boolean)
                        ]
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (Object.keys(data).length > 0) {
                        this.relationLevels[index + 1] = data
                    }

                })

        },


        generateReport() {

            fetch('/reports/generate', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content
                    },

                    body: JSON.stringify({

                        model: this.model,
                        relations: this.selectedRelations.filter(Boolean),
                        reports: this.reports

                    })

                })
                .then(res => res.json())
                .then(data => {

                    this.reportData = data

                    this.$nextTick(() => {

                        /* destroy previous */

                        if (this.barChart) {
                            this.barChart.destroy();
                            this.barChart = null
                        }
                        if (this.lineChart) {
                            this.lineChart.destroy();
                            this.lineChart = null
                        }
                        if (this.pieChart) {
                            this.pieChart.destroy();
                            this.pieChart = null
                        }

                        /* clear containers */

                        document.querySelector("#barChart").innerHTML = ''
                        document.querySelector("#lineChart").innerHTML = ''
                        document.querySelector("#pieChart").innerHTML = ''


                        /* BAR */

                        if (data.bar_chart) {

                            this.barChart = new ApexCharts(

                                document.querySelector("#barChart"),

                                {
                                    series: [{
                                        name: 'Total',
                                        data: data.bar_chart.map(i => i
                                            .total)
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 300
                                    },
                                    xaxis: {
                                        categories: data.bar_chart.map(i => i.date)
                                    }
                                }

                            )

                            this.barChart.render()

                        }


                        /* LINE */

                        if (data.line_chart) {

                            this.lineChart = new ApexCharts(

                                document.querySelector("#lineChart"),

                                {
                                    series: [{
                                        name: 'Total',
                                        data: data.line_chart.map(i => i
                                            .total)
                                    }],
                                    chart: {
                                        type: 'line',
                                        height: 300
                                    },
                                    xaxis: {
                                        categories: data.line_chart.map(i => i.date)
                                    }
                                }

                            )

                            this.lineChart.render()

                        }


                        /* PIE */

                        if (data.pie_chart) {

                            this.pieChart = new ApexCharts(

                                document.querySelector("#pieChart"),

                                {
                                    series: data.pie_chart.map(i => i.total),
                                    chart: {
                                        type: 'pie',
                                        height: 300
                                    },
                                    labels: data.pie_chart.map((_, i) => 'Group ' +
                                        (i + 1))
                                }

                            )

                            this.pieChart.render()

                        }

                    })

                })

        }

    }))

})
</script>

@endpush