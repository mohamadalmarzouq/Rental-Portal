<div class="form-group">
    <label for="" class="mb-1 tx-medium">Residence Type</label>
    <select onchange="checkResidenceType($(this).val());"
            class="custom-select mr-0 font-weight-500"
            name="residence_type" id="residence_type">

        @if($unit->type == 'residential')
        <option
            {{-- {{ isset($data->residence_type) ? $data->residence_type == 'residential' ? 'selected' : '' : ''}} --}}
            value="residential">
            Residential
        </option>
        @endif
        @if($unit->type == 'commercial')
        <option value="commercial">
            Commercial
        </option>
        @endif
    </select>

</div>

    <div class="form-group">
        <label for="" class="mb-1 tx-medium">Estimated Rent</label>
        <input type="text" id="estimated_rent" name="estimated_rent" class="form-control" readonly value="{{ $unit->estimated_rent }}">
    </div>





<script>
    $("#unit_type").val('{!! $unit->type !!}');
</script>
