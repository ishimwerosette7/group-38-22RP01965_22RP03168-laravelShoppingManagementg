@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Activity Details</h4>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <h5>Action</h5>
                        <p>{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</p>
                    </div>

                    <div class="mb-3">
                        <h5>Timestamp</h5>
                        <p>{{ $activity->created_at->format('F j, Y g:i A') }}</p>
                    </div>

                    @if($activity->details)
                        <div class="mb-3">
                            <h5>Details</h5>
                            <p>{{ $activity->details }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h5>IP Address</h5>
                        <p>{{ $activity->ip_address }}</p>
                    </div>

                    <div class="mb-3">
                        <h5>Login Time</h5>
                        <p>{{ $activity->login_time ? $activity->login_time->format('F j, Y g:i A') : 'N/A' }}</p>
                    </div>

                    <a href="{{ route('user.activities.index') }}" class="btn btn-primary">Back to Activities</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 