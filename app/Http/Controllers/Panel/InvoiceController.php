<?php

namespace App\Http\Controllers\Panel;

use App\Events\MarkInvoice;
use App\Exports\ExpenseInvoiceExport;
use App\Exports\InvoiceExport;
use App\Exports\RevenueInvoiceExport;
use App\Http\Requests\Invoice\StoreInvoice;
use App\Http\Requests\Invoice\UpdateInvoice;
use App\Http\Requests\Property\StoreExpense;
use App\Models\Invoice;
use App\Models\InvoiceExtra;
use App\Models\Lease;
use App\Models\OverduePayment;
use App\Models\PaymentMethod;
use App\Models\Property;
use App\Models\Status;
use App\Models\Tenant;
use App\Models\Type;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    protected $primary_model;
    protected $overdue_model;
    protected $property_model;
    protected $lease_model;
    protected $status_model;
    protected $type_model;
    protected $invoice_extra_model;
    protected $dataAssign;

    public function __construct()
    {
        $this->primary_model = new Invoice();
        $this->property_model = new Property();
        $this->lease_model = new Lease();
        $this->status_model = new Status();
        $this->type_model = new Type();
        $this->tenant_model = new Tenant();
        $this->tenant_model = new Tenant();
        $this->invoice_extra_model = new InvoiceExtra();
        $this->payment_method_model = new PaymentMethod();
        $this->overdue_model = new OverduePayment();
        $this->dataAssign['module'] = 'invoices';
        $this->rawColumns = ['duration', 'invoice_status', 'amount', 'action', 'overdue_comment'];
        $this->dataAssign['actions'] = ['add', 'edit', 'view', 'delete', 'print_invoice', 'approve_invoice', 'send_invoice'];
        // $this->dataAssign['actions'] = ['add', 'edit', 'view', 'delete', 'mark_invoice_paid', 'print_invoice', 'approve_invoice', 'send_invoice'];
        $this->dataAssign['ordering_column'] = $this->primary_model->orderingColumn();
        $this->dataAssign['ordering'] = true;
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
        $this->dataAssign['expense_data_table_columns'] = $this->primary_model->getExpenseColumnsForDataTable();
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.revenue.ajaxListing';
        $this->dataAssign['expense_route_name_for_listing'] = $this->dataAssign['module'] . '.expense.ajaxListing';
        $this->dataAssign['startTag'] = "<div class='text-wrap width-200'>";
        $this->dataAssign['endTag'] = "</div>";
    }

    public function show()
    {
        $this->getData();

        $this->dataAssign['widgets'] = $this->primary_model->widgetData();


        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function getData()
    {
        $this->dataAssign['types'] = $this->type_model->getInvoiceTypes();

        $this->dataAssign['revenue_type_id'] = $this->type_model->getTypeId($this->dataAssign['module'], 'revenue');

        $this->dataAssign['expense_type_id'] = $this->type_model->getTypeId($this->dataAssign['module'], 'expense');

        $this->dataAssign['leases'] = $this->lease_model->getActiveLeases();

        $this->dataAssign['properties'] = $this->property_model->getActiveProperties();

        $this->dataAssign['statuses'] = $this->status_model->getInvoiceStatus();

        $this->dataAssign['tenants'] = $this->tenant_model->getTenants(['in-active', 'active']);

        $this->dataAssign['payment_methods'] = $this->payment_method_model->getInvoicePaymentMethods();

        $this->dataAssign['payment_method_for_paid_invoice'] = $this->payment_method_model->invoicePaymentMethodsForSelect();
    }

        public function checkTenant($invoiceId)
        {
            $invoice = Invoice::find($invoiceId);
            if($invoice)
            {
                if(isset($invoice->tenant) && isset($invoice->tenant->status))
                {
                    return json_encode(['tenant_status'=>$invoice->tenant->status->slug]);
                }
                else
                {
                    return json_encode(['tenant_status'=>'tenant not found']);
                }
            }
            return json_encode(['tenant_status'=>'invoice not found']);
            //return json_encode(['id'=>$invoiceId]);
        }
        public function updateTenant(Request $request)
        {
            $invoice = Invoice::find($request->id);
            if($invoice)
            {
                if(isset($invoice->tenant))
                {
                    $status_id = $this->status_model->getStatusID($this->tenant_model->getTable(), 'active');
                    $invoice->tenant->tenant_status_id = $status_id;
                    $invoice->tenant->save();
                    return json_encode(['tenant_status'=>'active']);
                }
                else{
                    return json_encode(['tenant_status'=>'tenant not found']);
                }
            }
           return json_encode(['tenant_status'=>'invoice not found']);

        }

    // public function store(StoreInvoice $storeInvoice)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $status_id = $this->primary_model->invoiceStatus();

    //         $storeInvoice->merge(['invoice_status_id' => $status_id, 'start_date' => $storeInvoice->revenue_start_date]);

    //         $invoice = $this->primary_model->create($storeInvoice->only($this->primary_model->getFillable()));
    //         if ($storeInvoice->has('extras')) {
    //             $totalAmount = 0;
    //             foreach ($storeInvoice->extras as $key => $extras) {
    //                 if ((int)$extras['is_lease']) {

    //                     $status_model = new Status();

    //                     $lease_status_id = $status_model->getStatusID($this->lease_model->getTable(), 'active');

    //                     /* $lease = $this->lease_model->where('unit_id', $storeInvoice->unit_id)
    //                     ->where('property_id', $storeInvoice->property_id)->where('lease_status_id', $lease_status_id)
    //                     ->whereDate('end_date', '>', date('Y-m-d'))->first(); */

    //                     $lease = $this->lease_model->where('unit_id', $extras['unit_id'])
    //                         ->where('property_id', $extras['property_id'])->where('lease_status_id', $lease_status_id)
    //                         ->orderBy('id', 'DESC')->first();

    //                     if (!$lease) {
    //                         return response()->json([
    //                             'errors' => [
    //                                 'unit_id' => ['No active lease found against this unit.']
    //                             ],
    //                             'message' => 'The given data was invalid.'
    //                         ], 422);
    //                     }
    //                     $extras['lease_id'] = $lease->id;
    //                     $extras['tenant_id'] = $lease->tenant_id;
    //                 }
    //                 $totalAmount += $this->invoice_extra_model->attachItems($extras, $invoice->id);
    //             }

    //             $invoice->total_amount = $totalAmount;
    //             $invoice->tenant_id = $lease->tenant_id;
    //             $invoice->property_id = $lease->property_id;
    //             $invoice->unit_id = $lease->unit_id;
    //             $invoice->lease_id = $lease->id;
    //             $invoice->save();
    //         }

    //         if ($storeInvoice->has('attachments')) {
    //             foreach ($storeInvoice->input('attachments', []) as $file) {
    //                 $invoice->addMedia(public_path('files/' . $file))->toMediaCollection($this->primary_model->getTable());
    //             }
    //         }

    //         $month = date('m', strtotime($invoice->start_date));

    //         // $this->overdue_model->where('lease_id', $invoice->lease_id)->whereMonth('date', $month)->delete();
    //         $overduePayments = $this->overdue_model
    //             ->where('lease_id', $invoice->lease_id)
    //             ->whereMonth('date', $month)
    //             ->get();

    //         foreach ($overduePayments as $overdue) {
    //             // Remove non-numeric characters (currency symbols, commas, spaces)
    //             $overdueAmount = floatval(preg_replace('/[^\d.]/', '', $overdue->amount));
    //             $invoiceAmount = floatval($invoice->total_amount);

    //             Log::info("Processing Overdue ID: {$overdue->id}, Cleaned Overdue Amount: {$overdueAmount}, Invoice Amount: {$invoiceAmount}");

    //             if (!is_numeric($overdueAmount) || !is_numeric($invoiceAmount)) {
    //                 Log::error("Non-numeric value found: Overdue ID {$overdue->id}, Overdue Amount: {$overdue->amount}, Invoice Amount: {$invoice->total_amount}");
    //                 continue; // Skip this iteration
    //             }

    //             $newAmount = $overdueAmount - $invoiceAmount;

    //             if ($newAmount <= 0) {
    //                 Log::info("Overdue fully paid. Deleting Overdue ID: {$overdue->id}");
    //                 $overdue->delete();
    //             } else {
    //                 Log::info("Partial payment. Updating Overdue ID: {$overdue->id} to Amount: {$newAmount}");
    //                 $overdue->update(['amount' => $newAmount]);

    //                 break;
    //             }

    //             Log::info("After processing Overdue ID: {$overdue->id}, Remaining Invoice Amount: {$invoiceAmount}");

    //             if ($invoiceAmount <= 0) {
    //                 break;
    //             }
    //         }

    //         // Update the invoice total amount after deductions
    //         $invoice->update(['total_amount' => $invoiceAmount]);

    //         $storeInvoice->session()->flash('activity_log_data', [
    //             'identifier' => 'invoice_added',
    //             'subject_type' => $invoice,
    //             'name' => 'name',
    //             'module' => $this->dataAssign['module'],
    //             'method' => __FUNCTION__
    //         ]);
    //         DB::commit();
    //         return redirect($this->dataAssign['module']);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response($e->getMessage(), 500);
    //     }
    // }

    public function store(StoreInvoice $storeInvoice)
    {

        try {
            DB::beginTransaction();
            $status_id = $this->primary_model->invoiceStatus();

            $storeInvoice->merge(['invoice_status_id' => $status_id, 'start_date' => $storeInvoice->revenue_start_date,'end_date' => $storeInvoice->revenue_start_date]);

            $invoice = $this->primary_model->create($storeInvoice->only($this->primary_model->getFillable()));

            if ($storeInvoice->has('extras')) {
                $totalAmount = 0;
                foreach ($storeInvoice->extras as $key => $extras) {
                    if ((int)$extras['is_lease']) {
                        $status_model = new Status();
                        $lease_status_id = $status_model->getStatusID($this->lease_model->getTable(), 'active');

                        $lease = $this->lease_model->where('unit_id', $extras['unit_id'])
                            ->where('property_id', $extras['property_id'])
                            ->where('lease_status_id', $lease_status_id)
                            ->orderBy('id', 'DESC')
                            ->first();

                        if (!$lease) {
                            return response()->json([
                                'errors' => ['unit_id' => ['No active lease found against this unit.']],
                                'message' => 'The given data was invalid.'
                            ], 422);
                        }

                        $extras['lease_id'] = $lease->id;
                        $extras['tenant_id'] = $lease->tenant_id;
                    }
                    $totalAmount += $this->invoice_extra_model->attachItems($extras, $invoice->id);
                }

                $invoice->total_amount = $totalAmount;
                $invoice->tenant_id = $lease->tenant_id;
                $invoice->property_id = $lease->property_id;
                $invoice->unit_id = $lease->unit_id;
                $invoice->lease_id = $lease->id;
                $invoice->save();
            }

            if ($storeInvoice->has('attachments')) {
                foreach ($storeInvoice->input('attachments', []) as $file) {
                    $invoice->addMedia(public_path('files/' . $file))->toMediaCollection($this->primary_model->getTable());
                }
            }

            $month = date('m', strtotime($invoice->start_date));

            $overduePayments = $this->overdue_model
                ->where('lease_id', $invoice->lease_id)
                ->whereMonth('date', $month)
                ->get();

            $invoiceAmount = floatval($invoice->total_amount);

            // Ensure advance_payment is not null (default to 0)
            $lease->advance_payment = $lease->advance_payment ?? 0;

            // Use Lease's Advance Payment (if available)
            if ($lease->advance_payment >= $invoiceAmount) {
                // Fully pay the invoice using advance payment
                $lease->advance_payment -= $invoiceAmount;
                $invoiceAmount = 0;
            } else {
                // Use all advance payment, remaining amount still unpaid
                $invoiceAmount -= $lease->advance_payment;
                $lease->advance_payment = 0;
            }
            Log::info("Used lease advance payment. Remaining Advance: {$lease->advance_payment}");
            $lease->save();

            foreach ($overduePayments as $overdue) {
                $overdueAmount = floatval(preg_replace('/[^\d.]/', '', $overdue->amount));

                Log::info("Processing Overdue ID: {$overdue->id}, Overdue Amount: {$overdueAmount}, Invoice Amount: {$invoiceAmount}");

                if (!is_numeric($overdueAmount) || !is_numeric($invoiceAmount)) {
                    Log::error("Non-numeric value found: Overdue ID {$overdue->id}, Overdue Amount: {$overdue->amount}, Invoice Amount: {$invoice->total_amount}");
                    continue;
                }

                $newAmount = $overdueAmount - $invoiceAmount;

                if ($newAmount <= 0) {
                    Log::info("Overdue fully paid. Deleting Overdue ID: {$overdue->id}");
                    $overdue->delete();
                    $invoiceAmount = abs($newAmount); // Carry over remaining amount
                } else {
                    Log::info("Partial payment. Updating Overdue ID: {$overdue->id} to Amount: {$newAmount}");
                    $overdue->update(['amount' => $newAmount]);
                    // $invoiceAmount = 0;
                    break;
                }

                Log::info("After processing Overdue ID: {$overdue->id}, Remaining Invoice Amount: {$invoiceAmount}");

                if ($invoiceAmount <= 0) {
                    break;
                }
            }

            // If there is extra payment left, store it as Advance Payment
            if ($invoiceAmount > 0) {
                Log::info("Remaining amount after overdue payments: {$invoiceAmount}. Adding to advance payment.");
                $lease->advance_payment += $invoiceAmount;
                $lease->save();
                // $invoiceAmount = 0;
            }

            // Update the invoice total amount after deductions
            $invoice->update(['total_amount' => $invoiceAmount]);

            $storeInvoice->session()->flash('activity_log_data', [
                'identifier' => 'invoice_added',
                'subject_type' => $invoice,
                'name' => 'name',
                'module' => $this->dataAssign['module'],
                'method' => __FUNCTION__
            ]);

            DB::commit();
            return redirect($this->dataAssign['module']);
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }


    public function storeExpense(StoreExpense $storeInvoice)
    {
        $status_id = $this->primary_model->invoiceStatus();

        $storeInvoice->merge([
            'invoice_status_id' => $status_id,
            'property_id' => $storeInvoice->expense_property_id,
            'start_date' => date('Y-m-d', strtotime($storeInvoice->date_start_expense)),
            'end_date' => date('Y-m-d', strtotime($storeInvoice->date_start_expense)),
            'total_amount' => $storeInvoice->expense_amount
        ]);

        $invoice = $this->primary_model->create($storeInvoice->only($this->primary_model->getFillable()));

        if ($storeInvoice->has('attachments')) {
            foreach ($storeInvoice->input('attachments', []) as $file) {
                $invoice->addMedia(public_path('files/' . $file))->toMediaCollection($this->primary_model->getTable());
            }
        }

        $storeInvoice->session()->flash('activity_log_data', [
            'identifier' => 'invoice_added',
            'subject_type' => $invoice,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return redirect($this->dataAssign['module']);
    }


    public function update(UpdateInvoice $updateInvoice)
    {
        $invoice = $this->primary_model->find($updateInvoice->id);

        $medias = $invoice->getMedia($this->primary_model->getTable());

        if (count($medias) > 0) {
            foreach ($medias as $media) {
                if (!in_array($media->file_name, $updateInvoice->input('attachments', []))) {
                    $media->delete();
                }
            }
        }

        if ($updateInvoice->has('comment') && $invoice->comment != $updateInvoice->comment) {

            $updateInvoice->merge(['comment_added_by' => Auth()->user()->id]);
        }

        $invoice->update($updateInvoice->only($this->primary_model->getFillable()));

        if ($updateInvoice->has('extras')) {

            $invoice->total_amount = $this->invoice_extra_model->attachItems($updateInvoice->extras, $invoice->id);

            $invoice->save();
        }

        $media = $medias->pluck('file_name')->toArray();

        if ($updateInvoice->has('attachments')) {
            foreach ($updateInvoice->input('attachments', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $invoice->addMedia(public_path('files/' . $file))->toMediaCollection($this->primary_model->getTable());
                }
            }
        }

        $updateInvoice->session()->flash('activity_log_data', [
            'identifier' => 'invoice_update',
            'subject_type' => $invoice,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return redirect($this->dataAssign['module']);
    }

    public function edit($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        $this->dataAssign['data']->attachments = $this->dataAssign['data']->getMedia($this->primary_model->getTable());

        $this->getData();
        $invoiceModel =  Invoice::select('id', 'description')->find($id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign, ['invoiceModel' => $invoiceModel]);
    }

    public function view($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);
        $this->dataAssign['data']->attachments = $this->dataAssign['data']->getMedia($this->primary_model->getTable());
        // dd(getStoragePath());
        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function getLeaseData($id)
    {
        return $this->lease_model->with('tenant')->find($id);
    }

    public function delete($id)
    {
        $data = $this->primary_model->find($id);

        $data->delete();

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'invoice_deleted',
            'subject_type' => $data,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function search(Request $request)
    {
        $this->dataAssign['route_name_for_listing'] = $this->routeListingArray($request->all(), 'revenue.ajaxListing');

        $this->dataAssign['expense_route_name_for_listing'] = $this->routeListingArray($request->all(), 'expense.ajaxListing');

        $this->getData();

        $this->dataAssign['widgets'] = $this->primary_model->widgetData();

        $request->session()->put('search_invoice', $request->all());

        $this->dataAssign['search_invoice'] = app('session')->get('search_invoice');

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.show', $this->dataAssign);
    }

    public function routeListingArray($search, $route_name = 'ajaxListing')
    {
        return [
            'route' => $this->dataAssign['module'] . '.' . $route_name,
            'key' => 'search_by',
            'value' => $search
        ];
    }

    public function markAsPaidInvoice($id)
    {
        $status_id = $this->status_model->getStatusID($this->dataAssign['module'], 'approved');

        $invoice = $this->primary_model->findOrFail($id);

        $invoice->update(['invoice_status_id' => $status_id]);


        event(new MarkInvoice($this->primary_model->find($id)));

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'invoice_paid',
            'subject_type' => $invoice,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function cancelInvoice($id)
    {
        $status_id = $this->status_model->getStatusID($this->dataAssign['module'], 'cancelled');

        $invoice = $this->primary_model->findOrFail($id);

        $invoice->update(['invoice_status_id' => $status_id]);

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'invoice_cancelled',
            'subject_type' => $invoice,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function makeTotalEarningsDataTable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.allPaidInvoices';

        $this->dataAssign['module'] = $this->dataAssign['module'] . '-earnings';

        $this->dataAssign['ordering'] = true;

        return json_encode($this->dataAssign);
    }

    public function makeTotalTransactionsDataTable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.allPaidInvoices';
        //dd($this->dataAssign);
        $this->dataAssign['module'] = $this->dataAssign['module'] . '-transactions';

        $this->dataAssign['ordering'] = true;
        //dd(json_encode($this->dataAssign));
        return json_encode($this->dataAssign);
    }

    public function makeTotalOverDueDataTable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.overdueInvoices';

        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForOverDueAmountDataTable();

        $this->dataAssign['module'] = $this->dataAssign['module'];

        $this->dataAssign['ordering'] = 'false';

        return json_encode($this->dataAssign);
    }

    public function getDataForPlotLineGraph($value = null)
    {
        return $this->primary_model->plotGraphWidgetData($value);
    }

    public function getDataForRevenueBarGraph($value = null)
    {
        $request = app('request');

        return $this->primary_model->getDataForRevenueBarGraph($value, $request->all());
    }

    public function allPaidInvoicesListing()
    {
        $data = $this->primary_model->allPaidInvoices();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];
        //dd($module);
        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function overdueInvoicesListing()
    {
        $data = $this->primary_model->overDueInvoices();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        return $this->makeDataTable($data, $actions, $module, false);
    }

    public function export()
    {
        return Excel::download(new InvoiceExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    protected function ajaxListing()
    {
        $request = \request();

        if ($request->has('search_by')) {
            if (isset($request['search_by']['lease_id'])) {
                $data = $this->primary_model->transactionLogs($request['search_by']);
            } elseif (isset($request['search_by']['tenant_id'])) {
                $data = $this->primary_model->viewPaymentHistory($request['search_by']);
            } else {
                $data = $this->primary_model->searchAjaxListing($request['search_by']);
            }
        } else {
            $data = $this->primary_model->ajaxlisting();
        }
        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function revenueAjaxListing()
    {
        $request = \request();

        $revenue_type_id = $this->type_model->getTypeId($this->dataAssign['module'], 'revenue');

        if ($request->search['value']) {
            if (isset($request['search']['value'])) {
                if (str_contains($request['search']['value'], 'KWD')) {
                    $string = str_replace(array("KWD ", ","), array("", ""), $request['search']['value']);
                    $request->merge(['search' => ['value' => $string, 'regex' => 'false']]);
                }
            }


            if (isset($request['search']['lease_id'])) {
                $data = $this->primary_model->transactionLogs($request['search'])->where('type_id', $revenue_type_id);
            } elseif (isset($request['search']['tenant_id'])) {
                $data = $this->primary_model->viewPaymentHistory($request['search'])->where('type_id', $revenue_type_id);
            } else {
                $data = $this->primary_model->searchAjaxListing($request['search'])->where('type_id', $revenue_type_id);
            }
        } else {
            $data = $this->primary_model->ajaxlisting()->where('type_id', $revenue_type_id);
        }
        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function expenseAjaxListing()
    {
        $request = \request();

        $expense_type_id = $this->type_model->getTypeId($this->dataAssign['module'], 'expense');

        if ($request->search['value']) {
            if (isset($request['search_by']['lease_id'])) {
                $data = $this->primary_model->transactionLogs($request['search_by'])->where('type_id', $expense_type_id);
            } elseif (isset($request['search_by']['tenant_id'])) {
                $data = $this->primary_model->viewPaymentHistory($request['search_by'])->where('type_id', $expense_type_id);
            } else {
                $data = $this->primary_model->searchAjaxListing($request['search_by'])->where('type_id', $expense_type_id);
            }
        } else {
            $data = $this->primary_model->ajaxlisting()->where('type_id', $expense_type_id);
        }
        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function extras($key)
    {
        return view($this->layout_base . '.includes.' . $this->dataAssign['module'] . '_' . __FUNCTION__, compact('key'));
    }

    public function removeExtra($id)
    {
        $this->invoice_extra_model->findOrFail($id)->delete();

        return back();
    }

    public function revenueExport()
    {
        return Excel::download(new RevenueInvoiceExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    public function expenseExport()
    {
        return Excel::download(new ExpenseInvoiceExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    public function approveInvoice($id)
    {
        $status_id = $this->status_model->getStatusID($this->dataAssign['module'], 'approved');

        $invoice = $this->primary_model->findOrFail($id);

        $invoice->update(['invoice_status_id' => $status_id]);
    }

    public function sendInvoice($id)
    {

        $this->primary_model->sendInvoiceByEmail($id);
    }

    public function getDataForExpenseBarGraph()
    {
        $request = app('request');

        return $this->primary_model->getDataForExpenseBarGraph($request->all());
    }

    public function makeOutStandingBalanceDataTable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->lease_model->getTable() . '.overdueInvoices';

        $this->dataAssign['data_table_columns'] = $this->overdue_model->getColumnsForOverDueAmountDataTable();

        $this->dataAssign['module'] = $this->dataAssign['module'];

        $this->dataAssign['ordering'] = true;

        $this->dataAssign['ordering_column'] = $this->overdue_model->orderingColumnForOverdue();

        $this->dataAssign['search'] = 'true';

        $this->dataAssign['total_amount'] = $this->overdue_model->overdueAjaxListing()->sum('amount');

        //dd($this->dataAssign);
        return json_encode($this->dataAssign);
    }

    public function outStandingBalancesListing()
    {
        $data = $this->overdue_model->overdueAjaxListing();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        return $this->makeDataTable($data, $actions, $module, false);
    }

    public function storeMedia(Request $request)
    {
        $path = public_path('files');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}
