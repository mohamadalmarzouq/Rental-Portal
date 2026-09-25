@isset($status)
<span class="{{ $status == 'active' || $status == 'approved' ? 'status_active' : ($status == 'pending' ? 'status_pending' : 'status_in_active') }}">
    {{ t('status.' . $status, tn($status_name)) }}
</span>
@endisset

