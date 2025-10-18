<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Daily Trip Programs - {{ $date->format('d-m-Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .page-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .trip-section {
            margin-bottom: 30px;
        }
        .trip-header {
            background: #f4f4f4;
            padding: 10px;
            margin-bottom: 15px;
        }
        .program-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
        }
        .program-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .status-badge {
            float: right;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
        }
        .status-confirmed { background: #d4edda; }
        .status-draft { background: #fff3cd; }
        .status-done { background: #cce5ff; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Daily Trip Programs</h1>
        <h2>{{ $date->format('d-m-Y') }}</h2>
    </div>

    @forelse($groupedPrograms as $tripId => $programs)
        @php
            $trip = $programs->first()->trip;
        @endphp
        <div class="trip-section">
            <div class="trip-header">
                <h3>{{ $trip->name }}</h3>
            </div>

            @foreach($programs as $program)
                <div class="program-card">
                    <div class="program-header">
                        <span class="status-badge status-{{ $program->status }}">
                            {{ ucfirst($program->status) }}
                        </span>
                        <h4>Program Details</h4>
                    </div>

                    <p><strong>Organizer:</strong> {{ $program->organizer->name ?? 'Not assigned' }}</p>
                    <p><strong>Remarks:</strong> {{ $program->remarks ?? 'No remarks' }}</p>

                    @if($program->families->isNotEmpty())
                        <p><strong>Program Families:</strong></p>
                        <ul>
                            @foreach($program->families as $family)
                                <li>{{ $family->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    @empty
        <div>
            <p>No programs found for this date.</p>
        </div>
    @endforelse
</body>
</html>
