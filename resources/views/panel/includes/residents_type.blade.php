<div class="form-group">
    <label for="" class="mb-1 tx-medium">Residence Type</label>
    <select onchange="checkResidenceType($(this).val());"
            class="custom-select mr-0 font-weight-500"
            name="residence_type" id="residence_type">
        <option value="">Select Residence Type</option>
        <option value="commercial" {{ isset($unit) && $unit->type == 'commercial' ? 'selected' : '' }}>
            Commercial
        </option>
        <option value="residential" {{ isset($unit) && $unit->type == 'residential' ? 'selected' : '' }}>
            Residential
        </option>
    </select>
    @if(!empty($occupied_error))
        <small id="unit_occupied_error" class="text-danger d-block mt-1">{{ $occupied_error }}</small>
    @endif
</div>

<div class="form-group">
    <label for="" class="mb-1 tx-medium">Estimated Rent</label>
    <input type="text" id="estimated_rent" name="estimated_rent" class="form-control" readonly value="{{ $unit->estimated_rent }}">
</div>

<script>
    $("#unit_type").val('{!! $unit->type !!}');
</script>
