@php $editing = isset($program); @endphp

<div class="card">
    <h3>Section 1: Trip Info</h3>
    <div class="grid grid-3">
        <div>
            <label class="muted">Trip</label>
            <select name="trip_id" required>
                <option value="">-- Select Trip --</option>
                @foreach($trips as $t)
                    <option value="{{ $t->id }}" @selected(old('trip_id', $program->trip_id ?? '') == $t->id)>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="muted">Date</label>
            <input type="date" name="date" value="{{ old('date', optional($program->date ?? null)->format('Y-m-d')) }}" required>
        </div>
        <div>
            <label class="muted">Status</label>
            <select name="status">
                @foreach(['draft', 'confirmed', 'done'] as $st)
                    <option value="{{ $st }}" @selected(old('status', $program->status ?? 'draft') == $st)>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="muted">Organizer</label>
            <select name="organizer_id">
                <option value="">-- Select Organizer --</option>
                @foreach($organizers as $organizer)
                    <option value="{{ $organizer->id }}" @selected(old('organizer_id', $program->organizer_id ?? '') == $organizer->id)>{{ $organizer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid-col-span-2">
            <label class="muted">Remarks</label>
            <textarea name="remarks" rows="2">{{ old('remarks', $program->remarks ?? '') }}</textarea>
        </div>
    </div>
</div>

<br>

<div class="card">
    <h3>Section 2: Families / Groups</h3>

    <div style="margin-bottom:10px">
        <button type="button" class="btn" id="add-family-row">+ Add Family/Group</button>
    </div>

    <table id="families-table">
        <thead>
        <tr>
            <th style="min-width:180px">Customer (AJAX) or Group Name</th>
            <th>Agency</th> <!-- Added -->
            <th>A</th>
            <th>C</th>
            <th>I</th>
            <th>Hotel</th>
            <th>Room</th>
            <th>Pickup</th>
            <th>Activity</th>
            <th>Size</th>
            <th>Nationality</th>
            <th>Boat Master</th>
            <th>Guide Name</th>
            <th>Transfer Name</th>
            <th>Transfer Phone</th>
            <th>EGP</th>
            <th>USD</th>
            <th>EUR</th>
            <th>Remarks</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @php
            $rows = old('families', isset($program) ? $program->families->toArray() : []);
        @endphp

        @forelse($rows as $i => $fam)
            @include('trip_programs._family_row', [
                'i' => $i,
                'fam' => $fam,
                'hotels' => $hotels,
                'boats' => $boats,
                'agencies' => $agencies,
                'guides' => $guides // Pass guides to the partial
            ])
        @empty
            @include('trip_programs._family_row', [
                'i' => 0,
                'fam' => [],
                'hotels' => $hotels,
                'boats' => $boats,
                'agencies' => $agencies,
                'guides' => $guides // Pass guides to the partial
            ])
        @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
// IMPORTANT: Use jQuery (not $)
jQuery(function(jQuery){
    let rowIndex = jQuery('#families-table tbody tr').length ? (jQuery('#families-table tbody tr').length - 1) : 0;

    jQuery('#add-family-row').on('click', function(){
        rowIndex++;
        jQuery.get("{{ route('trip-programs.create') }}", {partial:'family_row', i:rowIndex}, function(html){
            // We’ll build client-side to avoid extra HTTP: duplicate last row template and replace indexes
            let $last = jQuery('#families-table tbody tr:last');
            let $clone = $last.clone();

            // Clear inputs in cloned row
            $clone.find('input, select, textarea').each(function(){
                let name = jQuery(this).attr('name');
                if (name) {
                    name = name.replace(/\[\d+\]/, '['+rowIndex+']');
                    jQuery(this).attr('name', name);
                }
                if (jQuery(this).is('select')) {
                    jQuery(this).val('');
                } else {
                    jQuery(this).val('');
                }
            });

            jQuery('#families-table tbody').append($clone);

            // Re-init select2 on new selects
            jQuery('.customer-select').select2({
                width: '180px',
                placeholder: 'Search customer…',
                ajax: {
                    delay: 250,
                    url: '/api/customers/search',
                    data: function(params){ return { q: params.term }; },
                    processResults: function(data){
                        // data should be: [{id:1,text:"John"}, ...]
                        return { results: data };
                    }
                },
                allowClear: true
            });
        });
    });

    // remove row
    jQuery(document).on('click','.remove-row', function(){
        if (jQuery('#families-table tbody tr').length > 1) {
            jQuery(this).closest('tr').remove();
        } else {
            alert('At least one row required.');
        }
    });

    // init select2 on first render
    jQuery('.customer-select').select2({
        width: '180px',
        placeholder: 'Search customer…',
        ajax: {
            delay: 250,
            url: '/api/customers/search',
            data: function(params){ return { q: params.term }; },
            processResults: function(data){ return { results: data }; }
        },
        allowClear: true
    });
});
</script>
@endpush
