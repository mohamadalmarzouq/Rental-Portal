<div class="switch-button switch-button-yesno">
    <input type="checkbox" {{ !isset($row->report_settings->enable) ?: $row->report_settings->enable == 'No' ? '' : 'checked' }} id="swt{{ $row->id }}" name="swt{{ $row->id }}"
           onclick="window.location.href='{{ url($toggle_column['update_url']).'?report_id='.$row->id.'&user_id='.Auth()->user()->id }}'">
    <span>
        <label for="swt{{ $row->id }}"></label></span>

</div>
