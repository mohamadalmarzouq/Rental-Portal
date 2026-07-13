<div class="dropdown actionBtns">
    <button class="btn bg-transparent p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        <img class="dropdownDots" src="{{ asset('assets/img/dropdownDots.svg') }}">
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        <input type="hidden" value="{{ $row->id }}" id="id">

        @if(in_array('view',$actions) && hasRole($module , 'show'))
            @if($module == 'invoices')
                <a href="{{ route($buttons['view']['route'] , ['id' => $row->id]) }}" class="dropdown-item"
                   title="View">
                    <img class="view_ic" src="{{ asset('assets/img/view_ic.svg') }}"> <span
                        class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">View</span>
                </a>
            @else
                <a href="#viewModal" data-toggle="modal"
                   onclick="view({{$row->id}},'{{ $module }}','{{ setText($module,true) }}')" class="dropdown-item"
                   title="View">
                    <img class="view_ic" src="{{ asset('assets/img/view_ic.svg') }}"> <span
                        class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">View</span>
                </a>
            @endif
        @endif

        @if(in_array('edit',$actions) && hasRole($module , 'edit'))
            <a href="{{ route($buttons['edit']['route'] , ['id' => $row->id]) }}" class="dropdown-item" title="Edit">
                <img class="edit_ic" src="{{ asset('assets/img/edit_ic.svg') }}"> <span
                    class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Edit</span>
            </a>
        @endif

        @if(in_array('delete',$actions) && hasRole($module , 'delete'))
            <a href="javascript:" onclick="deleteRow({{$row->id}},'{{ $module }}' , $(this))" class="dropdown-item"
               title="Delete">
                <img class="delete_ic" src="{{ asset('assets/img/delete_ic.svg') }}"> <span
                    class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Delete</span>
            </a>
        @endif

        @if(in_array('print_invoice',$actions))
            <a href="javascript:;" onclick="printInvoice('{{ $row->id }}');" class="dropdown-item"
               title="Print Invoice">
                <img class="delete_ic" src="{{ asset('assets/img/printInvoice_ic.svg') }}"> <span
                    class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Print Invoice</span>
            </a>
        @endif

        @if(in_array('view_transactions',$actions))
            <a href="{{ route('invoices.search',['lease_id' => $row->id]) }}" class="dropdown-item"
               title="View Transactions Log">
                <img class="delete_ic" src="{{ asset('assets/img/viewTransactionLog_ic.svg') }}"> <span
                    class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">View Transactions Log</span>
            </a>
        @endif

        @if(in_array('edit_report',$actions))
            <a href="javascript:;" onclick="openReportSettingModal('{{ $row->id }}')" class="mr-2"
               title="Report Setting">
                <i class="fa fa-file-alt"></i>
            </a>
        @endif

        @if(in_array('lease_details',$actions))
            <a href="{{ route('leases.search',['tenant_id' => $row->id]) }}" class="dropdown-item"
               title="Lease Details">
                <img class="delete_ic" src="{{ asset('assets/img/leaseDetails_ic.svg') }}"> <span
                    class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Lease Details</span>
            </a>
        @endif

        @if(in_array('payment_history',$actions))
            <a href="{{ route('invoices.search',['tenant_id' => $row->id]) }}" class="dropdown-item"
               title="Payment History">
                <img class="delete_ic" src="{{ asset('assets/img/paymentHistory_ic.svg') }}"> <span
                    class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Payment History</span>
            </a>
        @endif

        @if(in_array('approve_lease',$actions) && Auth::user()->role_id != getEmployeeId())
        @if($row->status->slug != 'active' && $row->status->slug != 'ended' && $row->status->slug != 'expired')
            <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','approve')" class="dropdown-item"
               title="Approve Lease">
                <img class="delete_ic" src="{{ asset('assets/img/paymentHistory_ic.svg') }}"> <span
                    class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Approve Lease</span>
            </a>
            @endif
        @endif

        @if(in_array('cancel_lease',$actions))
            @if($row->status->slug == 'active')
                <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','cancel')" class="mr-2"
                   title="Cancel Lease">
                    <i class="fa fa-file-signature"></i>
                </a>
            @endif
        @endif

       {{-- @if(in_array('approve_lease',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
            @if($row->status->slug == 'pending')
                <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','approve')" class="mr-2"
                   title="Approve Lease">
                    <i class="fa fa-file-signature"></i>
                </a>
            @endif
        @endif--}}

        @if(in_array('approve_tenant',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
            @if($row->status->slug == 'pending')
                <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','approve')" class="dropdown-item mr-2"
                   title="Approve Tenant">
                    <i class="fa fa-users"></i>
                    <span class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Approve Tenant</span>

                </a>
            @endif
        @endif

        @if(in_array('add_comment',$actions) )
            <a href="javascript:;" onclick="addComment('{{ $row->id }}')" class="dropdown-item"
               title="Add Comment">
                 <span
                     class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Add Comment</span>
            </a>
        @endif

        @if(in_array('end_lease',$actions))
            @if($row->status->slug == 'active')
                <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','end')" class="dropdown-item"
                   title="End Lease">
                    <img class="delete_ic" src="{{ asset('assets/img/endLease_ic.svg') }}"> <span
                        class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">End Lease</span>
                </a>
            @endif
        @endif

        @if(in_array('add_lease_invoice',$actions))
            @if($row->status->slug == 'active')
                <a href="{{ route($module.'.add_invoice',['id' => $row->id])}}" class="dropdown-item"
                   title="Add Future Invoice">
                    <img class="delete_ic" src="{{ asset('assets/img/addFutureInvoice_ic.svg') }}"> <span
                        class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Add Future Invoice</span>
                </a>
            @endif
        @endif

        @if(in_array('mark_invoice_paid',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
            @if($row->status->slug == 'un-paid')
                <a href="javascript:;"
                   onclick="markAsPaidInvoice('{{ $row->id }}','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
                   class="mr-2" title="Mark as Paid">
                    <i class="fa fa-file-powerpoint"></i>
                </a>
            @endif
        @endif

        @if(in_array('approve_invoice',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
            @if($row->status->slug == 'pending')
                <a href="javascript:;"
                   onclick="changeInvoiceStatus('{{ $row->id }}','approve','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
                   class="dropdown-item" title="Approve Invoice">
                    <img class="delete_ic" src="{{ asset('assets/img/approveInvoice_ic.svg') }}"> <span
                        class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Approve Invoice</span>
                </a>
            @endif
        @endif

        @if(in_array('cancel_invoice',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
            @if($row->status->slug == 'active')
                <a href="javascript:;"
                   onclick="changeInvoiceStatus('{{ $row->id }}','cancel','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
                   class="mr-2"
                   title="Cancel Invoice">
                    <i class="fa fa-calendar-times"></i>
                </a>
            @endif
        @endif

        @if(in_array('send_invoice',$actions))
        @if($row->status->slug == 'active')
            @if($row->invoice)
            <a href="javascript:;"
            onclick="changeInvoiceStatus('{{ $row->invoice?$row->invoice->id:0 }}','send','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
            class="dropdown-item"
            title="End Lease">
             <i class="fa fa-mail-bulk fs-20"></i> <span
                 class="tx-14 tx-medium mg-l-10 lh--9 flex-fill">Send Invoice</span>
            </a>
            @else
              <p style="font-size:12px;color:red">Invoice is not created for property</p>
            @endif

        @endif
        @endif
    </div>
</div>
{{--<div class="d-flex action_buttons">
    <input type="hidden" value="{{ $row->id }}" id="id">

    @if(in_array('view',$actions) && hasRole($module , 'show'))
        <a href="{{ route($buttons['view']['route'] , ['id' => $row->id]) }}" class="mr-2" title="View">
            <i class="far fa-eye"></i>
        </a>
    @endif

    @if(in_array('edit',$actions) && hasRole($module , 'edit'))
        <a href="{{ route($buttons['edit']['route'] , ['id' => $row->id]) }}" class="mr-2" title="Edit">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    @if(in_array('delete',$actions) && hasRole($module , 'delete'))
        <a href="javascript:" onclick="deleteRow({{$row->id}},'{{ $module }}' , $(this))" class="mr-2" title="Delete">
            <i class="fa fa-trash-alt"></i>
        </a>
    @endif

    @if(in_array('print_invoice',$actions))
        <a href="javascript:;" onclick="printInvoice('{{ $row->id }}');" class="mr-2" title="Print Invoice">
            <i class="fa fa-print"></i>
        </a>
    @endif

    @if(in_array('view_transactions',$actions))
        <a href="{{ route('invoices.search',['lease_id' => $row->id]) }}" class="mr-2" title="View Transactions Log">
            <i class="fa fa-file-alt"></i>
        </a>
    @endif

    @if(in_array('edit_report',$actions))
        <a href="javascript:;" onclick="openReportSettingModal('{{ $row->id }}')" class="mr-2"
           title="Report Setting">
            <i class="fa fa-file-alt"></i>
        </a>
    @endif

    @if(in_array('payment_history',$actions))
        <a href="{{ route('invoices.search',['tenant_id' => $row->id]) }}" class="mr-2" title="Payment History">
            <i class="fa fa-dollar-sign"></i>
        </a>
    @endif

    @if(in_array('lease_details',$actions))
        <a href="{{ route('leases.search',['tenant_id' => $row->id]) }}" class="mr-2" title="Lease Details">
            <i class="fa fa-file"></i>
        </a>
    @endif

    @if(in_array('cancel_lease',$actions))
        @if($row->status->slug == 'active')
            <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','cancel')" class="mr-2"
               title="Cancel Lease">
                <i class="fa fa-file-signature"></i>
            </a>
        @endif
    @endif

    @if(in_array('approve_lease',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
        @if($row->status->slug == 'pending')
            <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','approve')" class="mr-2"
               title="Approve Lease">
                <i class="fa fa-file-signature"></i>
            </a>
        @endif
    @endif

    @if(in_array('approve_tenant',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
        @if($row->status->slug == 'pending')
            <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','approve')" class="mr-2"
               title="Approve Tenant">
                <i class="fa fa-file-signature"></i>
            </a>
        @endif
    @endif

    @if(in_array('end_lease',$actions))
        @if($row->status->slug == 'active')
            <a href="javascript:;" onclick="changeLeaseStatus('{{ $row->id }}','end')" class="mr-2" title="End Lease">
                <i class="fa fa-file-excel"></i>
            </a>
        @endif
    @endif

    @if(in_array('add_lease_invoice',$actions))
        @if($row->status->slug == 'active')
            <a href="{{ route($module.'.add_invoice',['id' => $row->id])}}" class="mr-2" title="Add Future Invoice">
                <i class="fa fa-dollar-sign"></i>
            </a>
        @endif
    @endif

    @if(in_array('mark_invoice_paid',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
        @if($row->status->slug == 'un-paid')
            <a href="javascript:;"
               onclick="markAsPaidInvoice('{{ $row->id }}','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
               class="mr-2" title="Mark as Paid">
                <i class="fa fa-file-powerpoint"></i>
            </a>
        @endif
    @endif

    @if(in_array('approve_invoice',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
        @if($row->status->slug == 'pending')
            <a href="javascript:;"
               onclick="changeInvoiceStatus('{{ $row->id }}','approve','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
               class="mr-2"
               title="Approve Invoice">
                <i class="fa fa-file-signature"></i>
            </a>
        @endif
    @endif

    @if(in_array('cancel_invoice',$actions) && in_array(Auth()->user()->role_id, Auth()->user()->getLandLordRoleIds()))
        @if($row->status->slug == 'active')
            <a href="javascript:;"
               onclick="changeInvoiceStatus('{{ $row->id }}','cancel','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
               class="mr-2"
               title="Cancel Invoice">
                <i class="fa fa-calendar-times"></i>
            </a>
        @endif
    @endif

    @if(in_array('send_invoice',$actions))
        <a href="javascript:;"
           onclick="changeInvoiceStatus('{{ $row->id }}','send','{{ $row->type->slug == 'revenue' ? 'invoices' : 'expense_invoice' }}')"
           class="mr-2"
           title="Send Invoice">
            <i class="fa fa-mail-bulk"></i>
        </a>
    @endif
</div>--}}

<script>
    function changeInvoiceStatus(id, method, module) {
        if(id)
        {

            $.ajax({
                type: 'get',
                url: base_url+'/invoices-check_tenant/'+id,
                data: {'id':id},
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                  let  response = JSON.parse(data);
                  const csrfToken = "{{ csrf_token() }}";
                    if(response.tenant_status == 'blocked')
                    {
                        Swal.fire({
                        title: 'Invoice can not be sent! the tenant is blocked.',
                        text: "Are you sure you want to unblock the tenant ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, unblock!'
                        }).then((result) => {
                            if (result.value
                            ) {

                                $.ajax({
                                    method: 'post',
                                    url: base_url+'/invoices-update_tenant/'+id,
                                    data: {'id':id,_token: csrfToken},
                                    cache: false,
                                    success: function (data) {
                                    let  update_res = JSON.parse(data);
                                        if(update_res.tenant_status)
                                        {
                                            Swal.fire({
                                            title: 'Success!',
                                            text: 'Tenant has been unblocked.',
                                            icon: 'success',
                                            }).then(() => {
                                                location.reload();
                                            });
                                        }
                                    },error: function (err) {

                                    }
                                });
                             }
                        }) //swal then end
                    }
                    else if(response.tenant_status == 'active')
                    {
                        Swal.fire({
                            title: 'Are you sure???',
                            text: "You want to " + method + " the invoice!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, ' + method + ' it!'
                        }).then((result) => {
                            if (result.value) {
                                let request_url = base_url + '/invoices-' + method + '_invoice/' + id;

                                // Show loader before making AJAX request
                                Swal.fire({
                                    title: 'Sending Email',
                                    html: 'Please wait...',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                $.get(request_url).done(function () {

                                    var table = $('#datatable-' + module).DataTable();
                                    table.ajax.reload();
                                    let method_name = method;
                                    if (method == 'cancel') {
                                        method_name = 'cancelled';
                                    }

                                    // Close loader after a short delay
                                    setTimeout(() => {
                                        Swal.close();
                                        Swal.fire(
                                            'Success!',
                                            'Invoice has been sent.',
                                            'success'
                                        );
                                    }, 500);

                                }).fail(function (err) {
                                    console.log(err);
                                    // Close loader in case of failure
                                    Swal.close();
                                });
                            }
                        });
                    }

                }, error: function (err) {
                   // btn.attr("disabled", false);
                   // btn.removeClass('loader');
                    //showErrorMsgs(err);
                }
            });
        }
          /*  Swal.fire({
               title: 'Are you sure?',
               text: "You want to " + method + " the invoice!",
               type: 'warning',
               showCancelButton: true,
               confirmButtonText: 'Yes, ' + method + ' it!'
           }).then((result) => {
               if (result.value) {
                   let request_url = base_url + '/invoices-' + method + '_invoice/' + id;

                   // Show loader before making AJAX request
                   Swal.fire({
                       title: 'Sending Email',
                       html: 'Please wait...',
                       allowOutsideClick: false,
                       showConfirmButton: false,
                       onBeforeOpen: () => {
                           Swal.showLoading();
                       }
                   });

                   $.get(request_url).done(function () {

                       var table = $('#datatable-' + module).DataTable();
                       table.ajax.reload();
                       let method_name = method;
                       if (method == 'cancel') {
                           method_name = 'cancelled';
                       }

                       // Close loader after a short delay
                       setTimeout(() => {
                           Swal.close();
                           Swal.fire(
                               'Success!',
                               'Invoice has been sent.',
                               'success'
                           );
                       }, 500);

                   }).fail(function (err) {
                       console.log(err);
                       // Close loader in case of failure
                       Swal.close();
                   });
               }
           }); */

       }
</script>





