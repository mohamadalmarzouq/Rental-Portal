@isset($status)
<span class="{{ $status == 'active' || $status == 'approved' ? 'status_active' : ($status == 'pending' ? 'status_pending' : 'status_in_active') }}">
    {{ $status_name }}
</span>
@endisset

