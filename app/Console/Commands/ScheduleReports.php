<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Lease;
use App\Models\ReportSetting;
use App\Models\Tenant;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ScheduleReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Report via email to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->report_setting_model = new ReportSetting();
        $this->unit_model = new Unit();
        $this->tenant_model = new Tenant();
        $this->lease_model = new Lease();
        $this->invoice_model = new Invoice();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Log::info('report scedule');
        /*$reports = $this->report_setting_model->get();


        foreach ($reports as $report) {

            if ($report->schedule_date == date('Y-m-d') && $report->schedule_time == date('h:m')) {

                switch ($report->type->slug) {
                    case 'unit_vacancy_report':

                        $data = $this->unit_model->getReportData($report->land_lord)->get();

                        $columns = $this->unit_model->getColumnsForDataTable();

                        break;
                    case 'blocked_tenants_report':

                        $data = $this->tenant_model->getBlockedTenantsForReports($report->land_lord)->get();

                        $columns = $this->tenant_model->getColumnsForReportsDatatable();

                        break;
                    case 'expiring_lease_report':

                        $data = $this->lease_model->getExpiringLeaseForReports($report->land_lord)->get();

                        $columns = $this->lease_model->getColumnsForReportsDataTable();

                        break;
                    case 'unpaid_tenants_reports':

                        $data = $this->invoice_model->getUnpaidInvoices($report->land_lord)->get();

                        $columns = $this->invoice_model->getColumnsForReportDataTable();

                        break;

                }

                $pdf = PDF::loadView('panel.includes.pdf_format', compact('data', 'columns'));


                Mail::raw($report->type->name, function ($message) use ($report, $pdf) {

                    $message->to($report->land_lord->email)->subject($report->type->name)
                        ->attachData($pdf->output(), $report->type->slug . ".pdf");

                });
            }
        }

        $this->info('Reports are scheduled');*/
    }
}
