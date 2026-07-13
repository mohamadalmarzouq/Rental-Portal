@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="col-sm-12 row" id="unit{{ $index }}">
    @if(isset($data->id))
        <input type="hidden" name="unit[{{ $index }}][id]" value="{{ $data->id }}">
    @endif
    <div class="col-sm-6 mt-3">
        <div class="form-group">
            <label for="" class="mb-1">Unit number</label>
            <input type="number" name="unit[{{ $index }}][number]" id="unit_{{$index}}_number" class="form-control"
                   placeholder="Unit number" value="{{ isset($data->number) ? $data->number : '' }}"
                   onkeyup="checkUnitNumber({{$index}})">
        </div>
        @if(isset($message))
            <div class="dz-error-message">
                {{$message}}
            </div>
        @endif

    </div>

    <div class="col-sm-6 mt-3">
        <div class="form-group">
            <label for="" class="mb-1">Unit Size </label>
            <input type="text" name="unit[{{ $index }}][size]" id="unit_{{$index}}_size" class="form-control"
                   placeholder="Unit Size" value="{{ isset($data->size) ? $data->size : '' }}">
        </div>
    </div>

    <div class="col-sm-6 form-group">

        <label for="" class="mb-1">Unit type</label>
        <select id='unit_select_type' onchange="checkUnitType('{{ $index }}',$(this).val());" class="custom-select form-control mr-0 font-weight-500"
                name="unit[{{ $index }}][type]" id="unit_{{$index}}_type">

            <option id="commercial_type" {{ isset($data) && isset($data->type)  ? $data->type == 'commercial' ? 'selected' : '' : '' }}
                    value="commercial">
                Commercial
            </option>

            @if($property->type->name == "Residential" || $property->type->name  == "Investment" )
                <option id="residential_type" {{ isset($data->type) ? $data->type == 'residential' ? 'selected' : '' : ''}}
                        value="residential">
                    Residential
                </option>
            @endif
        </select>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="" class="mb-1">Estimated Rent </label>
            <input type="number" name="unit[{{ $index }}][estimated_rent]" id="unit_{{$index}}_estimated_rent" class="form-control"
                   placeholder="Estimated Rent" value="{{ isset($data->estimated_rent) ? $data->estimated_rent : '' }}">
        </div>
    </div>

    <div class="col-sm-12" id="residential{{ $index }}"
         style="display: {{ isset($data->type) ? $data->type == 'residential' ? 'block' : 'none' : 'none' }}">
        <div class="row">
            <div class="col-sm-6 no_of_bedroom">
                <div class="form-group">
                    <label for="" class="mb-1">No. of Bedrooms</label>
                    <input type="number" name="unit[{{ $index }}][no_of_bedrooms]" min="0" max="" id="unit_{{$index}}_no_of_bedrooms"
                           class="form-control"
                           placeholder="No. of Bedrooms"
                           value="{{ isset($data->no_of_bedrooms) ? $data->no_of_bedrooms : '' }}">
                </div>
            </div>
            <div class="col-sm-6 no_of_bedroom">
                <div class="form-group">
                    <label for="" class="mb-1">No. of Bathrooms</label>
                    <input type="number" name="unit[{{ $index }}][no_of_bathrooms]" min="0" max="" id="unit_{{$index}}_no_of_bathrooms"
                           class="form-control"
                           placeholder="No. of Bathrooms"
                           value="{{ isset($data->no_of_bathrooms) ? $data->no_of_bathrooms : '' }}">
                </div>
            </div>
            <div class="col-sm-6 no_of_bedroom">
                <div class="form-group">
                    <label for="" class="mb-1">No. of Livingrooms</label>
                    <input type="number" name="unit[{{ $index }}][no_of_livingrooms]" min="0" max="" id="unit_{{$index}}_no_of_livingrooms"
                           class="form-control"
                           placeholder="No. of Living Rooms"
                           value="{{ isset($data->no_of_livingrooms) ? $data->no_of_livingrooms : '' }}">
                </div>
            </div>
            <div class="col-sm-6 no_of_bedroom">
                <div class="form-group">
                    <label for="" class="mb-1">No. of Kitchens</label>
                    <input type="number" name="unit[{{ $index }}][no_of_kitchens]" min="0" max="" id="unit_{{$index}}_no_of_kitchens"
                           class="form-control"
                           placeholder="No. of Kitchens"
                           value="{{ isset($data->no_of_kitchens) ? $data->no_of_kitchens : '' }}">
                </div>
            </div>
            <div class="col-sm-6 no_of_bedroom">
                <div class="form-group">
                    <label for="" class="mb-1">Description</label>
                    <input type="text" name="unit[{{ $index }}][unit_description]" id="unit_{{$index}}_unit_description"
                           class="form-control"
                           placeholder="Description"
                           value="{{ isset($data->unit_description) ? $data->unit_description : '' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="section-divider col-sm-12 mb40">
        <span>
              <a href="javascript:;" class="btn btn-primary btn-sm" style="margin: 0 !important;"
                 onclick="removeUnit('unit{{ $index }}','{{ isset($data->id) ? $data->id : 0 }}')">Remove</a>
        </span>
    </div>
</div>


<script>
    // console.log({!! $index !!});
    // console.log({!! $property !!});


</script>
