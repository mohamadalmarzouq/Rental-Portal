<label for="" class="mb-1">{{ setText($sub_module) }}</label>
<select onchange="changeUnitType($(this).val())"  class="custom-select mr-0 font-weight-500" name="{{ $sub_module }}_id" id="{{ $sub_module }}_id">
    <option value="">Select {{ setText($sub_module) }}</option>
    @foreach($data as $row)
        <option {{ isset($id) ? $id == $row->id ? 'selected' : '' : '' }} value="{{ $row->id }}">
            {{ $row->{$name} }}
        </option>
    @endforeach
</select>
