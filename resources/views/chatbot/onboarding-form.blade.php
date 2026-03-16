<form id="onboarding-form" class="chat-form">

    <input name="name" placeholder="Name" required>

    <input name="email" type="email" placeholder="Email" required>

    <input name="number" placeholder="Mobile Number" required>

    <input name="address" placeholder="Address" required>

    @php
        $userTypeFromUrl = request('user_type');
    @endphp

    <select name="role_type"
            {{ $userTypeFromUrl ? 'disabled' : '' }}
            required>

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
    
    <input type="text" name="referral_code" placeholder="Enter referral code" value="{{ old('referral_code') }}">

    <button type="submit">Continue</button>

</form>
