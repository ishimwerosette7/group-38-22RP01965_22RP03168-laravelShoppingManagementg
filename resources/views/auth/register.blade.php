@extends('layouts.app')

@section('title', 'Register - Stock Management System')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Your Account</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                name="full_name" value="{{ old('full_name') }}" required autocomplete="name" autofocus>
                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="account_type" class="form-label">Account Type</label>
                            <select id="account_type" class="form-select @error('account_type') is-invalid @enderror" 
                                name="account_type" required>
                                <option value="">Select Account Type</option>
                                <option value="buyer" {{ old('account_type') == 'buyer' ? 'selected' : '' }}>Buyer</option>
                                <option value="seller" {{ old('account_type') == 'seller' ? 'selected' : '' }}>Seller</option>
                            </select>
                            @error('account_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                name="phone_number" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                            name="address" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div id="seller_fields" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="business_name" class="form-label">Business Name</label>
                                <input id="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                    name="business_name" value="{{ old('business_name') }}">
                                @error('business_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="business_type" class="form-label">Business Type</label>
                                <input id="business_type" type="text" class="form-control @error('business_type') is-invalid @enderror" 
                                    name="business_type" value="{{ old('business_type') }}">
                                @error('business_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                        <p class="text-center mt-3">
                            Already have an account? <a href="{{ route('login') }}">Login here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('account_type').addEventListener('change', function() {
        const sellerFields = document.getElementById('seller_fields');
        if (this.value === 'seller') {
            sellerFields.style.display = 'block';
        } else {
            sellerFields.style.display = 'none';
        }
    });
</script>
@endpush
@endsection 