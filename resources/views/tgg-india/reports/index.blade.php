@extends('admin.layouts.app')

@section('content')

<div class="container" x-data="reportBuilder()" x-init="init()">

<h2 class="mb-4">Dynamic Report Builder</h2>


<!-- MODEL SELECT -->

<div class="mb-4">

<label class="form-label">Select Model</label>

<select class="form-control" x-model="selectedModel" @change="loadModelInfo">

<option value="">Select Model</option>

<template x-for="model in models" :key="model">

<option :value="model" x-text="model"></option>

</template>

</select>

</div>



<!-- RELATIONS -->

<div class="mb-4" x-show="relations.length">

<label class="form-label"><strong>Relations</strong></label>

<template x-for="relation in relations" :key="relation.name">

<div>

<label>

<input type="checkbox"
:value="relation.name"
x-model="selectedRelations"
@change="generateReport">

<span x-text="relation.name"></span>

</label>

</div>

</template>

</div>



<!-- COLUMNS -->

<div class="mb-4" x-show="columns.length">

<label class="form-label"><strong>Columns</strong></label>

<div class="row">

<template x-for="column in columns" :key="column">

<div class="col-md-3 mb-2">

<label>

<input type="checkbox"
:value="column"
x-model="selectedColumns"
@change="generateReport">

<span x-text="column"></span>

</label>

</div>

</template>

</div>

</div>



<!-- DEFAULT REPORTS -->

<div class="mb-4" x-show="selectedModel">

<label class="form-label"><strong>Default Reports</strong></label>

<div>
<label><input type="checkbox" checked disabled> Total Records</label>
</div>

<div>
<label><input type="checkbox" checked disabled> Records Today</label>
</div>

<div>
<label><input type="checkbox" checked disabled> Records This Month</label>
</div>

</div>



<!-- EXTRA REPORTS -->

<div class="mb-4" x-show="selectedModel">

<label class="form-label"><strong>More Reports</strong></label>

<template x-for="report in availableReports" :key="report">

<div>

<label>

<input type="checkbox"
:value="report"
x-model="selectedReports"
@change="generateReport">

<span x-text="report"></span>

</label>

</div>

</template>

</div>



<!-- REPORT SUMMARY -->

<div class="card mb-4" x-show="summary.total">

<div class="card-header">

Report Summary

</div>

<div class="card-body">

<p><strong>Total Records:</strong>
<span x-text="summary.total"></span>
</p>

<p><strong>Records Today:</strong>
<span x-text="summary.today"></span>
</p>

<p><strong>This Month:</strong>
<span x-text="summary.month"></span>
</p>

</div>

</div>



<!-- REPORT TABLE -->

<div class="card">

<div class="card-header">

Generated Table Report

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<template x-for="col in selectedColumns" :key="col">

<th x-text="col"></th>

</template>

</tr>

</thead>

<tbody>

<template x-for="row in reportData" :key="row.id">

<tr>

<template x-for="col in selectedColumns" :key="col">

<td x-text="row[col] ?? ''"></td>

</template>

</tr>

</template>

</tbody>

</table>

</div>

</div>

</div>

@endsection



@push('scripts')

<script>

function reportBuilder() {

return {

models: [],

selectedModel: '',

columns: [],

relations: [],

selectedColumns: [],

selectedRelations: [],

selectedReports: [],

reportData: [],

summary: {},

availableReports: [
'latest',
'count_by',
'group_by'
],



init() {

this.loadModels();

},



async loadModels() {

let res = await fetch('/api/reports/models');

this.models = await res.json();

},



async loadModelInfo() {

if (!this.selectedModel) return;

let res = await fetch('/api/reports/model-info?model=' + this.selectedModel);

let data = await res.json();

this.columns = data.columns;

this.relations = data.relations;

this.selectedColumns = [];

this.selectedRelations = [];

this.selectedReports = [];

this.generateReport();

},



async generateReport() {

if (!this.selectedModel) return;

let res = await fetch('/api/reports/generate', {

method: 'POST',

headers: {
'Content-Type': 'application/json',
'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
},

body: JSON.stringify({

model: this.selectedModel,
columns: this.selectedColumns,
relations: this.selectedRelations,
reports: this.selectedReports,
filters: []

})

});

let data = await res.json();

this.reportData = data.data ?? [];

this.summary = data.summary ?? {};

}

}

}

</script>

@endpush