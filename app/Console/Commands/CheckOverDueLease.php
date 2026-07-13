<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Lease;
use App\Models\OverduePayment;
use App\Models\Status;
use App\Models\Tenant;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckOverDueLease extends Command
{
    protected $signature = 'overdue:lease';
    protected $description = 'Check and update overdue leases and tenant statuses.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Cron job started: Checking overdue leases.');

        $leaseModel = new Lease();
        $statusModel = new Status();
        $overdueModel = new OverduePayment();
        $invoiceModel = new Invoice();
        $tenantModel = new Tenant();

        // Get status IDs
        $activeLeaseStatusId = $statusModel->getStatusID($leaseModel->getTable(), 'active');
        $expiredLeaseStatusId = $statusModel->getStatusID($leaseModel->getTable(), 'expired');
        $activeTenantStatusId = $statusModel->getStatusID($tenantModel->getTable(), 'active');
        $inactiveTenantStatusId = $statusModel->getStatusID($tenantModel->getTable(), 'in-active');
        $blockedTenantStatusId = $statusModel->getStatusID($tenantModel->getTable(), 'blocked');

        // Get all active leases
        $leases = $leaseModel->where('end_date', '>', Carbon::today())
            ->where('lease_status_id', $activeLeaseStatusId)
            ->get();

        foreach ($leases as $lease) {
            $this->processLease($lease, $invoiceModel, $overdueModel);
        }

        // Mark expired leases
        $leaseModel->where('end_date', '<', Carbon::today())
            ->update(['lease_status_id' => $expiredLeaseStatusId]);

        // Mark tenants without active leases as inactive
        $this->updateTenantStatuses($tenantModel, $leaseModel, $activeLeaseStatusId, $inactiveTenantStatusId, $blockedTenantStatusId);

        Log::info('Cron job completed: Overdue lease check finished.');
    }

    protected function processLease($lease, $invoiceModel, $overdueModel)
    {
        $startDate = Carbon::parse($lease->start_date);
        $currentDate = Carbon::today();
        $monthsPassed = $startDate->diffInMonths($currentDate);

        $expectedRent = $lease->monthly_rent * $monthsPassed;
        $advancePayment = $lease->advance_payment ?? 0;
        $adjustedExpectedRent = max(0, $expectedRent - $advancePayment);

        $totalPaid = $invoiceModel->where('lease_id', $lease->id)->sum('total_amount');
        $overdueAmount = max(0, $adjustedExpectedRent - $totalPaid);

        Log::info("Lease ID {$lease->id}: Expected Rent = {$expectedRent}, Advance = {$advancePayment}, Paid = {$totalPaid}, Overdue = {$overdueAmount}");

        $existingOverdue = $overdueModel->where('lease_id', $lease->id)->latest()->first();
        $hasInvoiceThisMonth = $invoiceModel->where('lease_id', $lease->id)
            ->whereMonth('created_at', $currentDate->month)
            ->exists();

        if ($overdueAmount > 0) {
            if ($existingOverdue) {
                if (!$hasInvoiceThisMonth) {
                    $existingOverdue->update(['amount' => $overdueAmount]);
                    Log::info("Updated overdue for Lease ID {$lease->id}: {$overdueAmount}");
                } else {
                    Log::info("Skipping overdue update for Lease ID {$lease->id} due to invoice this month.");
                }
            } else {
                if (!$hasInvoiceThisMonth) {
                    $overdueModel->create([
                        'lease_id' => $lease->id,
                        'unit_id' => $lease->unit_id,
                        'property_id' => $lease->property_id,
                        'tenant_id' => $lease->tenant_id,
                        'amount' => $overdueAmount,
                        'date' => $currentDate,
                    ]);
                    Log::info("Created new overdue for Lease ID {$lease->id}: {$overdueAmount}");
                }
            }
        }

        // Handle due date logic
        $this->updateLeaseDueDate($lease);
    }

    protected function updateLeaseDueDate($lease)
    {
        $gracePeriodDays = 0;
        $dueDay = 1; // Default 1st of month

        if ($lease->property && $lease->property->land_lord_id) {
            $user = User::find($lease->property->land_lord_id);

            if ($user) {
                $gracePeriodDays = (int) ($user->grace_period ?? 0);
                $dueDay = (int) ($user->due_date ?? 1);
            }
        }

        $now = Carbon::now()->startOfMonth();
        $daysInMonth = $now->daysInMonth;

        // Prevent invalid days (example: February has max 28/29 days)
        $dueDay = min($dueDay, $daysInMonth);

        $dueDate = $now->day($dueDay);

        if ($gracePeriodDays > 0) {
            $dueDate->addDays($gracePeriodDays);

            // If adding grace days jumps to next month, reset to last day of this month
            if ($dueDate->month != $now->month) {
                $dueDate = $now->endOfMonth();
            }
        }

        $lease->update(['due_date' => $dueDate]);

        Log::info("Lease ID {$lease->id}: Due Day = {$dueDay}, Grace Period = {$gracePeriodDays}, Final Due Date = {$dueDate->toDateString()}");
    }


    protected function updateTenantStatuses($tenantModel, $leaseModel, $activeLeaseStatusId, $inactiveTenantStatusId, $blockedTenantStatusId)
    {
        $tenants = $tenantModel->all();

        foreach ($tenants as $tenant) {
            if (in_array($tenant->tenant_status_id, [$blockedTenantStatusId, $inactiveTenantStatusId])) {
                continue; // Skip blocked and already inactive
            }

            $hasActiveLease = $leaseModel->where('tenant_id', $tenant->id)
                ->where('lease_status_id', $activeLeaseStatusId)
                ->exists();

            if (!$hasActiveLease) {
                $tenant->update(['tenant_status_id' => $inactiveTenantStatusId]);
                Log::info("Marked Tenant ID {$tenant->id} as inactive.");
            }
        }
    }
}
