<?php

namespace Tests\Feature;

use App\Livewire\Admin\SalesReport;
use App\Models\ServiceFee;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SalesReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard service fees
        ServiceFee::create([
            'category' => 'document',
            'name' => 'Barangay Clearance',
            'code' => 'DOC-BC',
            'default_fee' => 50.00,
            'fee_unit' => 'per document',
            'is_active' => true,
        ]);

        ServiceFee::create([
            'category' => 'document',
            'name' => 'Certificate of Indigency',
            'code' => 'DOC-CI',
            'default_fee' => 0.00,
            'fee_unit' => 'per certificate',
            'is_active' => true,
        ]);

        ServiceFee::create([
            'category' => 'rental',
            'name' => 'Basketball Court Rental',
            'code' => 'RNT-CRT',
            'default_fee' => 200.00,
            'fee_unit' => 'per hour',
            'is_active' => true,
        ]);
    }

    public function test_guests_and_non_admins_cannot_access_sales_report_route(): void
    {
        // 1. Guest redirected to home/login
        $this->get(route('admin.sales'))->assertRedirect(route('home'));

        // 2. Regular resident gets 403
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident)->get(route('admin.sales'))->assertStatus(403);

        // 3. Health admin gets 403
        $healthAdmin = User::factory()->create(['role' => 'health_admin']);
        $this->actingAs($healthAdmin)->get(route('admin.sales'))->assertStatus(403);

        // 4. Household head gets 403
        $householdHead = User::factory()->create(['role' => 'household_head']);
        $this->actingAs($householdHead)->get(route('admin.sales'))->assertStatus(403);
    }

    public function test_admin_can_access_sales_report_route_and_render_livewire_component(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.sales'))
            ->assertOk()
            ->assertSeeLivewire('admin.sales-report')
            ->assertSee('Sales & Revenue Report');
    }

    public function test_sales_report_mount_sets_default_start_and_end_dates(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $now = now();
        $expectedStart = $now->copy()->startOfMonth()->toDateString();
        $expectedEnd = $now->copy()->endOfMonth()->toDateString();

        Livewire::test(SalesReport::class)
            ->assertSet('timeframe', 'this_month')
            ->assertSet('startDate', $expectedStart)
            ->assertSet('endDate', $expectedEnd);
    }

    public function test_updated_timeframe_adjusts_start_and_end_dates_correctly(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $now = Carbon::now();

        // 1. Today
        Livewire::test(SalesReport::class)
            ->set('timeframe', 'today')
            ->assertSet('startDate', $now->toDateString())
            ->assertSet('endDate', $now->toDateString());

        // 2. This Week
        Livewire::test(SalesReport::class)
            ->set('timeframe', 'this_week')
            ->assertSet('startDate', $now->copy()->startOfWeek()->toDateString())
            ->assertSet('endDate', $now->copy()->endOfWeek()->toDateString());

        // 3. This Quarter
        Livewire::test(SalesReport::class)
            ->set('timeframe', 'this_quarter')
            ->assertSet('startDate', $now->copy()->firstOfQuarter()->toDateString())
            ->assertSet('endDate', $now->copy()->lastOfQuarter()->toDateString());

        // 4. This Year
        Livewire::test(SalesReport::class)
            ->set('timeframe', 'this_year')
            ->assertSet('startDate', $now->copy()->startOfYear()->toDateString())
            ->assertSet('endDate', $now->copy()->endOfYear()->toDateString());

        // 5. All
        Livewire::test(SalesReport::class)
            ->set('timeframe', 'all')
            ->assertSet('startDate', null)
            ->assertSet('endDate', null);
    }

    public function test_sales_report_search_and_category_filters(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Transaction::create([
            'payer_name' => 'Juan Dela Cruz',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
            'official_receipt_number' => 'OR-2026-0001',
            'created_at' => now()->toDateTimeString(),
            'paid_at' => now()->toDateTimeString(),
        ]);

        Transaction::create([
            'payer_name' => 'Pedro Penduko',
            'service_type' => 'rental',
            'item_name' => 'Basketball Court Rental',
            'quantity' => 2,
            'unit_price' => 200.00,
            'total_amount' => 400.00,
            'amount_paid' => 400.00,
            'payment_status' => 'paid',
            'official_receipt_number' => 'OR-2026-0002',
            'created_at' => now()->toDateTimeString(),
            'paid_at' => now()->toDateTimeString(),
        ]);

        $foundTxn = Transaction::whereDate('created_at', '>=', now()->startOfMonth()->toDateString())
            ->whereDate('created_at', '<=', now()->endOfMonth()->toDateString())
            ->where('payment_status', 'paid')
            ->where('payer_name', 'like', '%Juan%')
            ->first();
        $this->assertNotNull($foundTxn, 'Eloquent query should find Juan Dela Cruz in DB');

        Livewire::test(SalesReport::class)
            ->set('search', 'Juan')
            ->assertSee('Juan Dela Cruz')
            ->assertDontSee('Pedro Penduko');
    }

    public function test_sales_report_metrics_and_item_breakdown_calculations(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Paid Document 1
        Transaction::create([
            'payer_name' => 'Juan Dela Cruz',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_amount' => 100.00,
            'amount_paid' => 100.00,
            'payment_status' => 'paid',
            'created_at' => now()->toDateTimeString(),
        ]);

        // Paid Rental 1
        Transaction::create([
            'payer_name' => 'Pedro Penduko',
            'service_type' => 'rental',
            'item_name' => 'Basketball Court Rental',
            'quantity' => 1,
            'unit_price' => 200.00,
            'total_amount' => 200.00,
            'amount_paid' => 200.00,
            'payment_status' => 'paid',
            'created_at' => now()->toDateTimeString(),
        ]);

        // Pending Transaction
        Transaction::create([
            'payer_name' => 'Maria Santos',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 0.00,
            'payment_status' => 'pending',
            'created_at' => now()->toDateTimeString(),
        ]);

        // Waived Transaction (Free Exemption)
        Transaction::create([
            'payer_name' => 'Indigent Resident',
            'service_type' => 'document',
            'item_name' => 'Certificate of Indigency',
            'quantity' => 1,
            'unit_price' => 0.00,
            'total_amount' => 0.00,
            'amount_paid' => 0.00,
            'payment_status' => 'waived',
            'payment_method' => 'free_exemption',
            'created_at' => now()->toDateTimeString(),
        ]);

        // Total Gross Revenue: 100 + 200 = 300
        // Document Revenue: 100
        // Rental Revenue: 200
        // Pending Amount: 50
        Livewire::test(SalesReport::class)
            ->assertViewHas('totalGrossRevenue', 300.00)
            ->assertViewHas('documentRevenue', 100.00)
            ->assertViewHas('rentalRevenue', 200.00)
            ->assertViewHas('paidCount', 2)
            ->assertViewHas('pendingCount', 1)
            ->assertViewHas('pendingAmount', 50.00)
            ->assertViewHas('waivedCount', 1);
    }

    public function test_admin_can_record_walkin_direct_sale(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Livewire::test(SalesReport::class)
            ->call('openDirectSaleModal')
            ->assertSet('showDirectSaleModal', true)
            ->set('directPayerName', 'Walkin Payer')
            ->set('directPayerAddress', 'Purok 1, Sambog')
            ->set('directServiceType', 'document')
            ->set('directItemName', 'Barangay Clearance')
            ->set('directQuantity', 2)
            ->set('directUnitPrice', 50.00)
            ->set('directPaymentMethod', 'cash')
            ->set('directOrNumber', 'OR-2026-7777')
            ->call('saveDirectSale')
            ->assertHasNoErrors()
            ->assertSet('showDirectSaleModal', false);

        $this->assertDatabaseHas('transactions', [
            'payer_name' => 'Walkin Payer',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_amount' => 100.00,
            'amount_paid' => 100.00,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'official_receipt_number' => 'OR-2026-7777',
            'processed_by' => $admin->id,
        ]);
    }

    public function test_admin_can_record_waived_free_exemption_direct_sale(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Livewire::test(SalesReport::class)
            ->call('openDirectSaleModal')
            ->set('directPayerName', 'Indigent Resident')
            ->set('directServiceType', 'document')
            ->set('directItemName', 'Certificate of Indigency')
            ->set('directQuantity', 1)
            ->set('directUnitPrice', 0.00)
            ->set('directPaymentMethod', 'free_exemption')
            ->call('saveDirectSale')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'payer_name' => 'Indigent Resident',
            'payment_status' => 'waived',
            'payment_method' => 'free_exemption',
            'amount_paid' => 0.00,
            'processed_by' => $admin->id,
        ]);
    }

    public function test_direct_sale_validation_errors(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Livewire::test(SalesReport::class)
            ->call('openDirectSaleModal')
            ->set('directPayerName', '') // Missing required name
            ->set('directQuantity', 0)   // Invalid quantity
            ->call('saveDirectSale')
            ->assertHasErrors(['directPayerName', 'directQuantity']);
    }

    public function test_admin_can_view_receipt_modal(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $transaction = Transaction::create([
            'payer_name' => 'Receipt Payer',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
            'official_receipt_number' => 'OR-REC-001',
            'processed_by' => $admin->id,
            'created_at' => now()->toDateTimeString(),
            'paid_at' => now()->toDateTimeString(),
        ]);

        Livewire::test(SalesReport::class)
            ->call('viewReceipt', $transaction->id)
            ->assertSet('showReceiptModal', true)
            ->assertSet('selectedReceipt.id', $transaction->id)
            ->assertSee('OFFICIAL COLLECTION RECEIPT')
            ->assertSee('OR-REC-001')
            ->assertSee('Receipt Payer');
    }

    public function test_admin_can_configure_and_save_service_fees(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $fee = ServiceFee::where('name', 'Barangay Clearance')->first();

        Livewire::test(SalesReport::class)
            ->call('openPricingModal')
            ->assertSet('showPricingModal', true)
            ->assertSet("editingFees.{$fee->id}", 50.0)
            ->set("editingFees.{$fee->id}", 75.50)
            ->call('savePricing')
            ->assertHasNoErrors()
            ->assertSet('showPricingModal', false);

        $this->assertDatabaseHas('service_fees', [
            'id' => $fee->id,
            'default_fee' => 75.50,
        ]);
    }
}
