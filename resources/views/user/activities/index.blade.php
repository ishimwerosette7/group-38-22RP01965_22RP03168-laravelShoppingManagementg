@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Your Activity History</h4>
                    <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>

                <div class="card-body">
                    @if($activities->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No activities found.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($activities as $activity)
                                <a href="{{ route('user.activities.show', $activity) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">
                                            <i class="fas fa-{{ $activity->action === 'login' ? 'sign-in-alt' : ($activity->action === 'logout' ? 'sign-out-alt' : 'shopping-cart') }}"></i>
                                            {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                        </h5>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">
                                        @if($activity->details)
                                            {{ $activity->details }}
                                        @endif
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-globe"></i> IP: {{ $activity->ip_address }}
                                    </small>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $activities->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 