<x-layout>
    <div class="profile-page">

        <div class="profile-header">
            <span class="page-badge">Account</span>
            <h1>Profile</h1>
            <p>Manage your personal information and view your ride history.</p>
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
                        <span class="profile-status">{{ $user->statuss }}</span>
                    </div>
                </div>

                <div class="profile-info">
                    <div class="profile-info-row">
                        <span>First name</span>
                        <strong>{{ $user->vards }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>Last name</span>
                        <strong>{{ $user->uzvards }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>E-mail</span>
                        <strong>{{ $user->epasts }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>Phone number</span>
                        <strong>{{ $user->telefons }}</strong>
                    </div>

                    <div class="profile-info-row">
                        <span>Account created</span>
                        <strong>{{ $user->created_at->format('d.m.Y') }}</strong>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="{{ route('auth.edit') }}" class="profile-btn profile-btn-edit">
                        Edit Profile
                    </a>

                    <form action="{{ route('auth.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your profile?')">
                        @csrf
                        @method('DELETE')
                        <button class="profile-btn profile-btn-delete" type="submit">
                            Delete Profile
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ride History --}}
            <div class="rides-card">
                <div class="rides-header">
                    <h2>Ride History</h2>
                    <p>Your completed and active rides.</p>
                </div>

                <div class="rides-list">
                    @forelse($rides as $ride)
                        <div class="ride-item">
                            <div class="ride-item-top">
                                <div>
                                    <h3>Ride #{{ $ride->id }}</h3>
                                    <span class="ride-status">{{ $ride->statuss }}</span>
                                </div>

                                @if($ride->maksajums)
                                    <div class="ride-price">
                                        {{ $ride->maksajums->summa_ar_pvn }} €
                                    </div>
                                @else
                                    <div class="ride-price unpaid">
                                        Unpaid
                                    </div>
                                @endif
                            </div>

                            <div class="ride-details">
                                <div>
                                    <span>Distance</span>
                                    <strong>{{ $ride->nobrauktais_attalums }} km</strong>
                                </div>

                                @if($ride->maksajums)
                                    <div>
                                        <span>Payment date</span>
                                        <strong>{{ $ride->maksajums->maksajuma_datums }}</strong>
                                    </div>
                                @else
                                    <div>
                                        <span>Payment</span>
                                        <strong>Not paid yet</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-rides">
                            <div class="empty-icon">🚗</div>
                            <h3>No rides yet</h3>
                            <p>Your ride history will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-layout>