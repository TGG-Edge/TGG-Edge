@extends('tgg-india.layouts.app')

@section('title', 'Report Builder | TGG Meta | TGG India')
@push('styles')
    <style>

    </style>
@endpush



@section('content')

    <div class="admin-container" x-data="reportBuilder()" x-init="init()">

        <!-- Header -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-3">
            <h4 class="mb-3 trainer-heading">Report Builder</h4>
            @include('tgg-india.layouts.includes.message')
            <div class="d-flex align-items-center justify-content-end gap-2 w-lg-auto mt-2 mt-lg-0">
                    <button class="btn btn-primary assignment-button" @click="generateReport()">
                        Generate Report
                    </button>
                    <button class="btn btn-secondary assignment-button" onclick="window.print()">
                        Print
                    </button>
            </div>
        </div>


        <!-- FILTER SECTION -->
        <div class="card mb-3">
            <div class="card-body">

                <div class="row g-3">

                    <!-- MODEL -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Select Model</label>

                        <select class="form-select" x-model="model" @change="loadRelations()">
                            <option value="">Select Model</option>

                            <template x-for="(className,key) in models">
                                <option :value="className" x-text="key"></option>
                            </template>

                        </select>
                    </div>


                    <!-- RELATIONS -->

                    <template x-for="(relation,index) in relationLevels">

                        <div class="col-md-4">

                            <label class="form-label fw-bold">Select Relation</label>

                            <select class="form-select" x-model="selectedRelations[index]"
                                @change="loadNextRelation(index)">

                                <option value="">Select Relation</option>

                                <template x-for="(className,name) in relation">
                                    <option :value="name" x-text="name"></option>
                                </template>

                            </select>

                        </div>

                    </template>

                </div>

            </div>
        </div>


        <!-- REPORT TYPES -->

        <div class="card mb-3">

            <div class="card-body">

                <h5 class="mb-3">Report Types</h5>

                <div class="row">

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="summary" x-model="reports"> Summary</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="table" x-model="reports"> Table</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="bar_chart" x-model="reports"> Bar Chart</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="line_chart" x-model="reports"> Line Chart</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="pie_chart" x-model="reports"> Pie Chart</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="top_records" x-model="reports"> Top Records</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="comparison" x-model="reports"> Comparison</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="timeline" x-model="reports"> Timeline</label>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label><input type="checkbox" value="growth" x-model="reports"> Growth</label>
                    </div>

                </div>
            </div>

        </div>



        <!-- REPORT OUTPUT -->

        <div class="row g-3">

            <!-- SUMMARY -->

            <template x-if="reportData.summary">

                <div class="col-md-4">

                    <div class="card h-100">

                        <div class="card-body">

                            <h5 class="card-title">Summary</h5>

                            <div class="alert alert-info mb-0">

                                Total Records:
                                <strong x-text="reportData.summary.total_records"></strong>

                            </div>

                        </div>

                    </div>

                </div>

            </template>


            <!-- BAR CHART -->

            <div class="col-md-6" x-show="reportData.bar_chart">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Bar Chart</h5>

                        <div id="barChart"></div>

                    </div>

                </div>

            </div>


            <!-- LINE CHART -->

            <div class="col-md-6" x-show="reportData.line_chart">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Line Chart</h5>

                        <div id="lineChart"></div>

                    </div>

                </div>

            </div>


            <!-- PIE CHART -->

            <div class="col-md-6" x-show="reportData.pie_chart">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Pie Chart</h5>

                        <div id="pieChart"></div>

                    </div>

                </div>

            </div>



            <!-- TABLE -->

            <div class="col-12" x-show="reportData.table">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title mb-3">Table Report</h5>

                        <div class="table-responsive">

                            <table class="table table-striped table-bordered align-middle">

                                <thead class="table-dark">

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

                </div>

            </div>


            <!-- TOP RECORDS -->

            <div class="col-md-6" x-show="reportData.top_records">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Top Records</h5>

                        <ul class="list-group">

                            <template x-for="row in reportData.top_records">

                                <li class="list-group-item" x-text="JSON.stringify(row)">
                                </li>

                            </template>

                        </ul>

                    </div>

                </div>

            </div>



            <!-- COMPARISON -->

            <div class="col-md-4" x-show="reportData.comparison">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Comparison</h5>

                        <p>Current Month:
                            <strong x-text="reportData.comparison.current_month"></strong>
                        </p>

                        <p>Previous Month:
                            <strong x-text="reportData.comparison.previous_month"></strong>
                        </p>

                    </div>

                </div>

            </div>



            <!-- TIMELINE -->

            <div class="col-md-4" x-show="reportData.timeline">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Timeline</h5>

                        <ul class="list-group">

                            <template x-for="row in reportData.timeline">

                                <li class="list-group-item">

                                    <span x-text="row.id"></span> -
                                    <span x-text="row.created_at"></span>

                                </li>

                            </template>

                        </ul>

                    </div>

                </div>

            </div>



            <!-- GROWTH -->

            <div class="col-md-4" x-show="reportData.growth">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Growth</h5>

                        <p>Total Records:
                            <strong x-text="reportData.growth.total_records"></strong>
                        </p>

                        <p>First Record:
                            <strong x-text="reportData.growth.first_record_date"></strong>
                        </p>

                        <p>Latest Record:
                            <strong x-text="reportData.growth.latest_record_date"></strong>
                        </p>

                    </div>

                </div>

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
                                        if (!rel) return null
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
                                                categories: data.bar_chart.map(i => i
                                                    .date)
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
                                                categories: data.line_chart.map(i => i
                                                    .date)
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
                                            labels: data.pie_chart.map((_, i) =>
                                                'Group ' +
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
