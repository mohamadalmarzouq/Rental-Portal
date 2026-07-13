<?php

namespace App\Repositories\Search;

use App\Exports\BlockedTenantReportExport;
use App\Exports\ExpiringLeaseReportExport;
use App\Exports\UnitVacancyReportExport;
use App\Exports\UnpaidTenantReportExport;
use App\Models\Invoice;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Widget;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SearchFilter
{
    public function __construct()
    {
        $this->tenant_model = new Tenant();
        $this->lease_model = new Lease();
        $this->unit_model = new Unit();
        $this->type_model = new Type();
        $this->widget_model = new Widget();
        $this->invoice_model = new Invoice();
    }

    public function reportFilterColumns($request)
    {
        $columns_data = [];

        switch ($request['type']) {
            case 'unit_vacancy_report':
                $columns_data = $this->unit_model->getColumnsForDataTable();
                break;
            case 'blocked_tenants_report':
                $columns_data = $this->tenant_model->getColumnsForReportsDatatable();
                break;
            case 'expiring_lease_report':
                $columns_data = $this->lease_model->getColumnsForReportsDataTable();
                break;
            case 'unpaid_tenants_reports':
                $columns_data = $this->invoice_model->getColumnsForReportDataTable();
                break;
        }
        return $columns_data;
    }

    public function reportFilterData($search_by)
    {
        $data = [];

        switch ($search_by['type']) {
            case 'unit_vacancy_report':
                $data = $this->unit_model->getReportData(Auth()->user());
                break;
            case 'blocked_tenants_report':
                $data = $this->tenant_model->getBlockedTenantsForReports(Auth()->user());
                break;
            case 'expiring_lease_report':
                $data = $this->lease_model->getExpiringLeaseForReports(Auth()->user());
                break;
            case 'unpaid_tenants_reports':
                $data = $this->invoice_model->getUnpaidInvoices(Auth()->user());
                break;
        }
        return $data;
    }

    public function getReportTypes()
    {
        $current_user = Auth()->user();

        return $this->widget_model->getWidgetsForReports($current_user);
    }

    public function export($type, $report_type)
    {
        switch ($type) {
            case 'pdf':
                return $this->exportReportPdf($report_type);
                break;

            case 'xlsx':
                return $this->exportReportExcel($report_type);
                break;
        }
    }

    public function exportReportPdf($report_type)
    {
        $data = [];
        $columns = [];
        switch ($report_type['type']) {
            case 'unit_vacancy_report':

                $data = $this->unit_model->getReportData(Auth()->user())->get();

                $columns = $this->unit_model->getColumnsForDataTable();

                break;
            case 'blocked_tenants_report':

                $data = $this->tenant_model->getBlockedTenantsForReports(Auth()->user())->get();

                $columns = $this->tenant_model->getColumnsForReportsDatatable();

                break;
            case 'expiring_lease_report':

                $data = $this->lease_model->getExpiringLeaseForReports(Auth()->user())->get();

                $columns = $this->lease_model->getColumnsForReportsDataTable();

                break;
            case 'unpaid_tenants_reports':

                $data = $this->invoice_model->getUnpaidInvoices(Auth()->user())->get();

                $columns = $this->invoice_model->getColumnsForReportDataTable();

                break;
        }

        $pdf = PDF::loadView('panel.includes.pdf_format', compact('data', 'columns'));

        return $pdf->download(time() . $report_type['type'] . '.pdf');

    }

    public function exportReportExcel($report_type)
    {
        $export_data = [];

        switch ($report_type['type']) {
            case 'unit_vacancy_report':
                $export_data = Excel::download(new UnitVacancyReportExport(), time() . $report_type['type'] . '.xlsx');
                break;
            case 'blocked_tenants_report':
                $export_data = Excel::download(new BlockedTenantReportExport(), time() . $report_type['type'] . '.xlsx');
                break;
            case 'expiring_lease_report':
                $export_data = Excel::download(new ExpiringLeaseReportExport(), time() . $report_type['type'] . '.xlsx');
                break;
            case 'unpaid_tenants_reports':
                $export_data = Excel::download(new UnpaidTenantReportExport(), time() . $report_type['type'] . '.xlsx');
                break;
        }
        return $export_data;
    }
}
