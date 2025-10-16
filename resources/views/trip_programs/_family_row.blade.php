@php
    $prefix = "families[$i]";
@endphp
<tr>
    <td>
        <select class="customer-select" name="{{ $prefix }}[customer_id]">
            @if(!empty($fam['customer_id']))
                <option value="{{ $fam['customer_id'] }}" selected>[Selected Customer #{{ $fam['customer_id'] }}]</option>
            @endif
        </select>
        <div class="muted" style="font-size:12px">or</div>
        <input type="text" name="{{ $prefix }}[group_name]" placeholder="Group name (e.g., MASTER / ETS)" value="{{ $fam['group_name'] ?? '' }}">
    </td>
    <td>
        <select name="{{ $prefix }}[agency_id]" style="min-width:150px">
            <option value="">-- Select Agency --</option>
            @foreach($agencies as $agency)
                <option value="{{ $agency->id }}" @selected(($fam['agency_id'] ?? null) == $agency->id)>{{ $agency->name }}</option>
            @endforeach
        </select>
    </td>
    <td><input type="number" min="0" name="{{ $prefix }}[adults]" value="{{ $fam['adults'] ?? 0 }}" style="width:70px"></td>
    <td><input type="number" min="0" name="{{ $prefix }}[children]" value="{{ $fam['children'] ?? 0 }}" style="width:70px"></td>
    <td><input type="number" min="0" name="{{ $prefix }}[infants]" value="{{ $fam['infants'] ?? 0 }}" style="width:70px"></td>

    <td>
        <select name="{{ $prefix }}[hotel_id]" style="min-width:150px">
            <option value="">--</option>
            @foreach($hotels as $h)
                <option value="{{ $h->id }}" @selected(($fam['hotel_id'] ?? null)==$h->id)>{{ $h->name }}</option>
            @endforeach
        </select>
    </td>
    <td><input type="text" name="{{ $prefix }}[room_number]" value="{{ $fam['room_number'] ?? '' }}" style="width:100px"></td>
    <td><input type="time" name="{{ $prefix }}[pickup_time]" value="{{ $fam['pickup_time'] ?? '' }}" style="width:120px"></td>
    <td><input type="text" name="{{ $prefix }}[activity]" value="{{ $fam['activity'] ?? '' }}" style="width:100px" placeholder="SNK / DP / ..."></td>
    <td><input type="text" name="{{ $prefix }}[size]" value="{{ $fam['size'] ?? '' }}" style="width:90px"></td>
    <td><input type="text" name="{{ $prefix }}[nationality]" value="{{ $fam['nationality'] ?? '' }}" style="width:120px"></td>
    <td>
        <select name="{{ $prefix }}[boat_master]" style="width:120px">
            <option value="">-- Select Boat --</option>
            @foreach($boats as $boat)
                <option value="{{ $boat->id }}" @selected(($fam['boat_master'] ?? null) == $boat->id)>{{ $boat->name }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="{{ $prefix }}[guide_id]" style="min-width:150px">
            <option value="">-- Select Guide --</option>
            @foreach($guides as $guide)
                <option value="{{ $guide->id }}" @selected(($fam['guide_id'] ?? null) == $guide->id)>{{ $guide->name }}</option>
            @endforeach
        </select>
    </td>
    <td><input type="text" name="{{ $prefix }}[transfer_name]" value="{{ $fam['transfer_name'] ?? '' }}" style="width:120px"></td>
    <td><input type="text" name="{{ $prefix }}[transfer_phone]" value="{{ $fam['transfer_phone'] ?? '' }}" style="width:120px"></td>
    <td><input type="number" step="0.01" min="0" name="{{ $prefix }}[collect_egp]" value="{{ $fam['collect_egp'] ?? '' }}" style="width:100px"></td>
    <td><input type="number" step="0.01" min="0" name="{{ $prefix }}[collect_usd]" value="{{ $fam['collect_usd'] ?? '' }}" style="width:100px"></td>
    <td><input type="number" step="0.01" min="0" name="{{ $prefix }}[collect_eur]" value="{{ $fam['collect_eur'] ?? '' }}" style="width:100px"></td>
    <td><input type="text" name="{{ $prefix }}[remarks]" value="{{ $fam['remarks'] ?? '' }}" style="width:140px"></td>
    <td><button type="button" class="btn btn-danger remove-row">X</button></td>
</tr>
