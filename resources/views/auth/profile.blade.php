<x-layout>
    <div class="profile-page">

        <div class="profile-header">
            <h1>{{ __('messages.profile') }}</h1>
            <p>{{ __('messages.profile_description') }}</p>
        </div>

        <div class="profile-grid">

            {{-- Profile Card --}}
            <div class="profile-card">
                <div class="profile-card-top">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->vards, 0, 1)) }}{{ strtoupper(substr($user->uzvards, 0, 1)) }}
                    </div>

                    <div>
                        <h2>{{ $user->vards }} {{ $user->uzvards }}</h2>
                    </div>
                </div>

                <div class="profile-info">
                    <div class="profile-info-row">
                        <span>{{ __('messages.first_name') }}</span>
                        <strong>{{ $user->vards }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>{{ __('messages.last_name') }}</span>
                        <strong>{{ $user->uzvards }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>{{ __('messages.email') }}</span>
                        <strong>{{ $user->epasts }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>{{ __('messages.phone_number') }}</span>
                        <strong>{{ $user->telefons }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>{{ __('messages.account_created') }}</span>
                        <strong>{{ $user->created_at->format('d.m.Y') }}</strong>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="{{ route('auth.edit') }}" class="profile-btn profile-btn-edit">
                        {{ __('messages.edit_profile') }}
                    </a>

                    <form 
                        action="{{ route('auth.destroy') }}" 
                        method="POST" 
                        onsubmit="return confirm(@json(__('messages.delete_profile_confirm')))"
                    >
                        @csrf
                        @method('DELETE')
                        <button class="profile-btn profile-btn-delete" type="submit">
                            {{ __('messages.delete_profile') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ride History --}}
            <div class="rides-card">
                <div class="rides-header">
                    <h2>{{ __('messages.ride_history') }}</h2>
                    <p>{{ __('messages.ride_history_description') }}</p>
                </div>

                <div class="rides-list">
                    @forelse($rides as $ride)
                        <div class="ride-item">
                            <div class="ride-item-top">
                                <h3>{{ __('messages.ride_number', ['id' => $ride->id]) }}</h3>

                                @php
                                    $rideStatusKey = match($ride->statuss) {
                                        'aktīva' => 'ride_status_active',
                                        'pabeigta' => 'ride_status_completed',
                                        'atcelta' => 'ride_status_cancelled',
                                        default => 'ride_status_unknown',
                                    };
                                @endphp

                                <span class="ride-status">
                                    {{ __('messages.' . $rideStatusKey) }}
                                </span>
                            </div>

                            <div class="ride-details">
                                <div>
                                    <span>{{ __('messages.distance') }}</span>
                                    <strong>{{ $ride->nobrauktais_attalums }} km</strong>
                                </div>

                                @if($ride->maksajums)
                                    <div>
                                        <span>{{ __('messages.payment_date') }}</span>
                                        <strong>{{ $ride->maksajums->maksajuma_datums }}</strong>
                                    </div>
                                @else
                                    <div>
                                        <span>{{ __('messages.payment') }}</span>
                                        <strong>{{ __('messages.not_paid_yet') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-rides">
                            <div class="empty-icon">🚗</div>
                            <h3>{{ __('messages.no_rides_yet') }}</h3>
                            <p>{{ __('messages.no_rides_description') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-layout>