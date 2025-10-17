@php
    $prefix = "families[$i]";
@endphp
<tr data-id="{{ $fam['id'] ?? '' }}">
    <input type="hidden" name="families[{{ $i }}][id]" value="{{ $fam['id'] ?? '' }}">
    <td class="customer-column" style="position: relative;">
        <div class="customer-tags-container" data-index="{{ $i }}" style="min-height: 40px; border: 1px solid #ddd; border-radius: 4px; padding: 5px; background: white; display: flex; flex-wrap: wrap; gap: 5px; align-items: center;">
            @php
                $existingCustomers = [];

                // Handle customer_id (can be JSON array or single ID)
                if (!empty($fam['customer_id'])) {
                    $customerIds = is_array($fam['customer_id']) ? $fam['customer_id'] : json_decode($fam['customer_id'], true);
                    if (!is_array($customerIds)) {
                        $customerIds = [$fam['customer_id']];
                    }

                    // Get customer names
                    $customers = \App\Models\Customer::whereIn('id', $customerIds)->get();
                    foreach ($customers as $customer) {
                        $existingCustomers[] = ['id' => $customer->id, 'name' => $customer->name];
                    }
                }

                // Handle group_name
                if (!empty($fam['group_name'])) {
                    $groupNames = explode(', ', $fam['group_name']);
                    foreach ($groupNames as $groupName) {
                        $existingCustomers[] = ['id' => '', 'name' => trim($groupName)];
                    }
                }
            @endphp
            @foreach($existingCustomers as $cust)
                <span class="customer-tag" style="background: #e0e0e0; padding: 3px 8px; border-radius: 3px; display: inline-flex; align-items: center; gap: 5px;">
                    <span>{{ $cust['name'] }}</span>
                    <button type="button" class="remove-tag" style="background: none; border: none; cursor: pointer; font-weight: bold; color: #666;">&times;</button>
                    <input type="hidden" name="{{ $prefix }}[customers][]" value="{{ $cust['id'] ? 'customer:' . $cust['id'] : 'group:' . $cust['name'] }}">
                </span>
            @endforeach
            <input type="text"
                   class="customer-search-input"
                   data-index="{{ $i }}"
                   placeholder="Type to add..."
                   autocomplete="off"
                   style="border: none; outline: none; flex: 1; min-width: 150px; padding: 5px;">
        </div>
        <div class="customer-suggestions" data-index="{{ $i }}" style="display:none; position:absolute; background:white; border:1px solid #ddd; max-height:200px; overflow-y:auto; z-index:1000; width:100%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></div>
    </td>
    <td>
        <select name="{{ $prefix }}[agency_id]" style="min-width:150px">
            <option value="">-- Select Agency --</option>
            @foreach($agencies as $agency)
                <option value="{{ $agency->id }}" @selected(($fam['agency_id'] ?? null) == $agency->id)>{{ $agency->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td><input type="number" min="0" name="{{ $prefix }}[adults]" value="{{ $fam['adults'] ?? 0 }}" style="width:70px">
    </td>
    <td><input type="number" min="0" name="{{ $prefix }}[children]" value="{{ $fam['children'] ?? 0 }}"
            style="width:70px"></td>
    <td><input type="number" min="0" name="{{ $prefix }}[infants]" value="{{ $fam['infants'] ?? 0 }}"
            style="width:70px"></td>

    <td>
        <select name="{{ $prefix }}[hotel_id]" style="min-width:150px">
            <option value="">--</option>
            @foreach($hotels as $h)
                <option value="{{ $h->id }}" @selected(($fam['hotel_id'] ?? null) == $h->id)>{{ $h->name }}</option>
            @endforeach
        </select>
    </td>
    <td><input type="text" name="{{ $prefix }}[room_number]" value="{{ $fam['room_number'] ?? '' }}"
            style="width:100px"></td>
    <td><input type="time" name="{{ $prefix }}[pickup_time]" value="{{ $fam['pickup_time'] ?? '' }}"
            style="width:120px"></td>
    <td><input type="text" name="{{ $prefix }}[activity]" value="{{ $fam['activity'] ?? '' }}" style="width:100px"
            placeholder="SNK / DP / ..."></td>
    <td><input type="text" name="{{ $prefix }}[size]" value="{{ $fam['size'] ?? '' }}" style="width:90px"></td>
    <td><input type="text" name="{{ $prefix }}[nationality]" value="{{ $fam['nationality'] ?? '' }}"
            style="width:120px"></td>
    <td>
        <select name="{{ $prefix }}[boat_master]" style="width:120px">
            <option value="">-- Select Boat --</option>
            @foreach($boats as $boat)
                <option value="{{ $boat->id }}" @selected(($fam['boat_master'] ?? null) == $boat->id)>{{ $boat->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="{{ $prefix }}[guide_id]" style="min-width:150px">
            <option value="">-- Select Guide --</option>
            @foreach($guides as $guide)
                <option value="{{ $guide->id }}" @selected(($fam['guide_id'] ?? null) == $guide->id)>{{ $guide->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="{{ $prefix }}[transfer_contract_id]" style="min-width:150px">
            <option value="">-- Select Contract --</option>
            @foreach($transferContracts as $contract)
                <option value="{{ $contract->id }}" @selected(($fam['transfer_contract_id'] ?? null) == $contract->id)>
                    @if($contract->driver)
                        {{ $contract->driver->name }}
                        @if($contract->contract_type === 'company' && $contract->company_name)
                            | {{ $contract->company_name }}
                        @endif
                        | {{ $contract->driver->phone }}
                        @if($contract->driver->alternative_phone)
                            | {{ $contract->driver->alternative_phone }}
                        @endif
                    @else
                        {{ $contract->company_name ?? 'No Driver' }} ({{ $contract->from }} → {{ $contract->to }})
                    @endif
                </option>
            @endforeach
        </select>
    </td>
    <td><input type="number" step="0.01" min="0" name="{{ $prefix }}[collect_egp]"
            value="{{ $fam['collect_egp'] ?? '' }}" style="width:100px"></td>
    <td><input type="number" step="0.01" min="0" name="{{ $prefix }}[collect_usd]"
            value="{{ $fam['collect_usd'] ?? '' }}" style="width:100px"></td>
    <td><input type="number" step="0.01" min="0" name="{{ $prefix }}[collect_eur]"
            value="{{ $fam['collect_eur'] ?? '' }}" style="width:100px"></td>
    <td><input type="text" name="{{ $prefix }}[remarks]" value="{{ $fam['remarks'] ?? '' }}" style="width:140px"></td>
    <td style="white-space: nowrap;">
        <button type="button" class="btn btn-info btn-sm duplicate-row" title="Duplicate">
            ⎘
        </button>
        <button type="button" class="btn btn-danger btn-sm remove-row" data-id="{{ $fam['id'] ?? '' }}" title="Delete">
            X
        </button>
    </td>
</tr>
