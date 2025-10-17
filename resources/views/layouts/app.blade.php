<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sambo Operation System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @auth
            @include('partials.navbar')
            @include('partials.sidebar')
        @endauth
        <main class="app-main">
            <div class="app-content p-3">
                @yield('content')
            </div>
        </main>
        @include('partials.footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize Flatpickr globally for all date inputs
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('input[type="date"]', {
                dateFormat: 'Y-m-d',
                allowInput: true,
                altInput: true,
                altFormat: 'F j, Y',
                disableMobile: false,
                locale: {
                    firstDayOfWeek: 0 // Sunday = 0, Monday = 1
                },
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
                onReady: function(selectedDates, dateStr, instance) {
                    // Wrap input in a container if not already wrapped
                    const input = instance.altInput || instance.input;
                    let wrapper = input.parentElement;

                    if (!wrapper.classList.contains('flatpickr-wrapper-custom')) {
                        wrapper = document.createElement('div');
                        wrapper.className = 'flatpickr-wrapper-custom';
                        wrapper.style.cssText = 'position: relative; display: inline-block; width: 100%;';
                        input.parentNode.insertBefore(wrapper, input);
                        wrapper.appendChild(input);
                    }

                    // Create clear button
                    const clearButton = document.createElement('button');
                    clearButton.innerHTML = '&times;';
                    clearButton.type = 'button';
                    clearButton.className = 'flatpickr-clear';
                    clearButton.title = 'Clear date';
                    clearButton.style.cssText = 'position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: #7373731a; color: #717171; border: 1px solid #dfdfdf; border-radius: 3px; width: 22px; height: 22px; cursor: pointer; font-size: 18px; line-height: 1; padding: 0; display: none; z-index: 100; transition: all 0.2s; font-weight: bold;';

                    // Add hover effect
                    clearButton.addEventListener('mouseenter', function() {
                        this.style.background = '#dc3545';
                        this.style.color = 'white';
                    });
                    clearButton.addEventListener('mouseleave', function() {
                        this.style.background = 'rgba(220, 53, 69, 0.1)';
                        this.style.color = '#dc3545';
                    });                    // Clear functionality
                    clearButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        instance.clear();
                        this.style.display = 'none';
                    });

                    // Insert button inside the wrapper
                    wrapper.appendChild(clearButton);

                    // Add padding to input to make room for button
                    input.style.paddingRight = '60px';

                    // Show/hide button based on value
                    if (instance.input.value) {
                        clearButton.style.display = 'block';
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    const input = instance.altInput || instance.input;
                    const wrapper = input.closest('.flatpickr-wrapper-custom');
                    const clearButton = wrapper ? wrapper.querySelector('.flatpickr-clear') : null;
                    if (clearButton) {
                        clearButton.style.display = dateStr ? 'block' : 'none';
                    }
                }
            });
        });
    </script>
    @yield('scripts')
    @stack('scripts')
</body></html>
