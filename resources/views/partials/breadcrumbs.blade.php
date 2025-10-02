@php
    $segments = request()->segments(); // كل أجزاء URL
    $breadcrumb = [];
    $url = url('/');
@endphp

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
        </li>

        @foreach($segments as $index => $segment)
            @php
                // نبني الرابط التدريجي
                $url .= '/' . $segment;
                $isLast = $loop->last;

                // تجاهل أي Segment عبارة عن رقم (ID)
                if (is_numeric($segment)) continue;

                // صياغة الاسم (تحويل - إلى مسافة + أول حرف كابيتال)
                $label = ucfirst(str_replace('-', ' ', $segment));
            @endphp

            @if(!$isLast)
                <li class="breadcrumb-item">
                    <a href="{{ $url }}">{{ $label }}</a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $label }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
