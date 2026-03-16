<form id="onboarding-form" class="chat-form">

    <input name="name" placeholder="Name" required>

    <input name="email" type="email" placeholder="Email" required>

    <input name="number" placeholder="Mobile Number" required>

    <input name="address" placeholder="Address" required>

    <input name="referred_by" placeholder="Referre Code (Optional)">


    {{-- <select name="referred_by" id="referred_by" class="select2">
        <option value="">Referred By (Optional)</option>

        @foreach($users as $user)
            <option value="{{ $user['id'] }}" data-name="{{ $user['name'] }}">
                {{ $user['name'] }}
            </option>
        @endforeach
    </select> --}}

    {{-- <select name="role_type" required>
        <option value="">Select Role Type</option>
        @foreach($roleTypes as $key => $role)
            <option value="{{ $key }}">{{ $role['name'] }}</option>
        @endforeach
    </select>

    <select name="referred_by" id="referred_by" class="select2">
        <option value="">Referred By (Optional)</option>
        @foreach($users as $user)
            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
        @endforeach
    </select> --}}

    

    <select name="role_type" {{ $userTypeFromUrl ? 'disabled' : '' }} required>
        
        <option value="">Select Role Type</option>

        @foreach($roleTypes as $key => $role)
            <option value="{{ $key }}"
                {{ old('role_type', $userTypeFromUrl) == $key ? 'selected' : '' }}>
                {{ $role['name'] ?? $role->name }}
            </option>
        @endforeach
    </select>

    {{-- Important: Disabled fields are not submitted --}}
    @if($userTypeFromUrl)
        <input type="hidden" name="role_type" value="{{ $userTypeFromUrl }}">
    @endif

    

    <button type="submit">Continue</button>

</form>


<script>
    
$(document).ready(function () {

    $('.select2').select2({
        placeholder: 'Select option',
        allowClear: true,
        width: '100%'
    });

});
</script>
