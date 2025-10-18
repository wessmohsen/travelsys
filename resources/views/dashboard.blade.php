@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row g-3">
        <!-- Boats -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2" style="font-size: 0.875rem;">Boats</h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $boatsCount }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-ship fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('boats.index') }}" class="btn btn-light btn-sm mt-3 w-100">
                        <i class="fas fa-eye me-1"></i> View All Boats
                    </a>
                </div>
            </div>
        </div>

        <!-- Agencies -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2" style="font-size: 0.875rem;">Agencies</h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $agenciesCount }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('agencies.index') }}" class="btn btn-light btn-sm mt-3 w-100">
                        <i class="fas fa-eye me-1"></i> View All Agencies
                    </a>
                </div>
            </div>
        </div>

        <!-- Guides -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2" style="font-size: 0.875rem;">Guides</h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $guidesCount }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('guides.index') }}" class="btn btn-light btn-sm mt-3 w-100">
                        <i class="fas fa-eye me-1"></i> View All Guides
                    </a>
                </div>
            </div>
        </div>

        <!-- Hotels -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2" style="font-size: 0.875rem;">Hotels</h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $hotelsCount }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-hotel fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('hotels.index') }}" class="btn btn-light btn-sm mt-3 w-100">
                        <i class="fas fa-eye me-1"></i> View All Hotels
                    </a>
                </div>
            </div>
        </div>

        <!-- Trip Programs -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2" style="font-size: 0.875rem;">Trip Programs</h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $tripProgramsCount }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('trip-programs.index') }}" class="btn btn-light btn-sm mt-3 w-100">
                        <i class="fas fa-eye me-1"></i> View All Programs
                    </a>
                </div>
            </div>
        </div>

        <!-- Trips -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2" style="font-size: 0.875rem;">Trips</h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $tripsCount }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-map-marked-alt fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('trips.index') }}" class="btn btn-light btn-sm mt-3 w-100">
                        <i class="fas fa-eye me-1"></i> View All Trips
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Trip Programs -->
    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-calendar-check text-primary me-2"></i>
                    Latest Trip Programs
                </h3>
                <a href="{{ route('trip-programs.index') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Trip</th>
                        <th>Date</th>
                        <th>Organizer</th>
                        <th>Status</th>
                        <th>Families</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestTripPrograms as $program)
                        <tr>
                            <td><span class="badge bg-secondary">#{{ $program->id }}</span></td>
                            <td>
                                <strong>{{ $program->trip->name ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <i class="fas fa-calendar me-1 text-muted"></i>
                                {{ $program->date ? $program->date->format('d-m-Y') : 'N/A' }}
                            </td>
                            <td>
                                <i class="fas fa-user me-1 text-muted"></i>
                                {{ $program->organizer->name ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="badge
                                    @if($program->status == 'confirmed') bg-success
                                    @elseif($program->status == 'done') bg-info
                                    @else bg-warning
                                    @endif">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $program->families->count() }} families
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('trip-programs.show', $program) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p class="mb-0">No trip programs found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
