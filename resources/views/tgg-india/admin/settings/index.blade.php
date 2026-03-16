@extends('tgg-india.layouts.app')

@section('title', 'Settings | TGG India')

@section('content')
<div class="admin-container">

    <div class="col-12 col-md-6 d-flex align-items-center">
            <h4 class="trainer-heading mb-3">Settings</h4>
    </div>

    @include('tgg-india.layouts.includes.message')

    <div class="row">

        <!-- Tabs -->
        <div class="col-md-3">
            <ul class="list-group">
                @foreach($groups as $group)
                    <a href="{{ route('tgg-india.admin.settings.index', ['group' => $group]) }}"
                       class="list-group-item {{ $activeGroup == $group ? 'active' : '' }} btn btn-primary assignment-button my-1">
                        {{ ucfirst($group) }}
                    </a>
                @endforeach
            </ul>
        </div>

        <!-- Content -->
        <div class="col-md-9">
            <form method="POST" action="{{ route('tgg-india.admin.settings.update') }}">
                @csrf

                <div class="card p-3">

                    @foreach($settings as $setting)

                        {{-- TEXT --}}
                        @if($setting->type === 'text')
                            <div class="mb-3">
                                <label class="form-label">{{ $setting->label }}</label>
                                <input type="text"
                                       name="settings[{{ $setting->id }}]"
                                       value="{{ $setting->value }}"
                                       class="form-control">
                            </div>
                        @endif

                         @if($setting->type === 'description')
                            <div class="mb-3">
                                <label class="form-label">{{ $setting->label }}</label>
                                {{-- <input type="description"
                                       name="settings[{{ $setting->id }}]"
                                       value="{{ $setting->value }}"
                                       class="form-control"> --}}
                                <textarea name="settings[{{ $setting->id }}]" id="" class="form-control-textarea">{{ $setting->value }}</textarea>
                            </div>
                        @endif
                        {{-- JSON RULE EDITOR --}}
                        @if($setting->type === 'json')
                            <div class="mb-4">
                                <label class="form-label">{{ $setting->label }}</label>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Min</th>
                                            <th>Max</th>
                                            <th>Plan</th>
                                            <th width="50">+</th>
                                        </tr>
                                    </thead>
                                    <tbody class="rule-table">
                                        @foreach($setting->value as $i => $rule)
                                            <tr>
                                                <td>
                                                    <input type="number"
                                                           name="settings[{{ $setting->id }}][{{ $i }}][min]"
                                                           value="{{ $rule['min'] }}"
                                                           class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                           name="settings[{{ $setting->id }}][{{ $i }}][max]"
                                                           value="{{ $rule['max'] }}"
                                                           class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           name="settings[{{ $setting->id }}][{{ $i }}][plan]"
                                                           value="{{ $rule['plan'] }}"
                                                           class="form-control">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-primary save-button mt-3">
                                    + Add Rule
                                </button>
                            </div>
                        @endif

                    @endforeach

                    <button class="btn btn-primary save-button mt-3 ">
                        Save Settings
                    </button>

                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('click', function (e) {

    if (e.target.classList.contains('add-row')) {
        let table = e.target.closest('.mb-4').querySelector('.rule-table');
        let index = table.children.length;

        table.insertAdjacentHTML('beforeend', `
            <tr>
                <td><input type="number" name="" class="form-control"></td>
                <td><input type="number" name="" class="form-control"></td>
                <td><input type="text" name="" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
            </tr>
        `);
    }

    if (e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endpush
