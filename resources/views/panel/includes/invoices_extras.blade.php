<div class="row" id="extras-{{ $key }}">
    <div class="col-sm-6">
        <label for="" class="mb-1 tx-medium">Rental/Non Rental</label>
        <div class="custom-control custom-switch cusToggle mg-t-8">
            <input type="hidden" name="extras[{{ $key }}][is_lease]" value="0">
            <input type="checkbox" name="extras[{{ $key }}][is_lease]" id="extras_{{ $key }}_is_lease"
                   class="custom-control-input"
                   value="1" {{ !isset($extra->is_lease) ?: !$extra->is_lease ?: 'checked' }}>
            <label class="custom-control-label" for="extras_{{ $key }}_is_lease"></label>

        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="" class="mb-1 tx-medium">Amount</label>
            <input type="text" name="extras[{{ $key }}][amount]" id="extras_{{ $key }}_amount" class="form-control"
                   placeholder="Amount"
                   onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))"
                   value="{{ isset($extra->amount) ? $extra->amount : '' }}">
        </div>
    </div>
    <div class="col-sm-12 text-right mb-2">
        <a href="javascript:;" onclick="removeExtra('{{ $key }}','{{ isset($extra->id) ? $extra->id : '' }}')" class=""
           title="Remove">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</div>
