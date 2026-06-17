# Phase 2: Order Management & Fulfillment - Research

**Researched:** 2025-03-24
**Domain:** Order Management, Inventory Fulfillment, Customer Portals
**Confidence:** HIGH

## Summary

This phase focuses on the transition from a purely procurement-focused system to a dual-sided logistics platform. We will implement customer identities, order lifecycle management, and a strict FIFO-based inventory reservation system. The core technical challenge is ensuring atomic transactions during order placement to prevent overselling while maintaining a clear audit trail of which inventory batches were used for each fulfillment.

**Primary recommendation:** Use a dedicated `OrderService` to handle the atomic process of order validation, creation, and FIFO stock allocation, and add `batch_id` to `inventory_movements` to track batch-level fulfillment.

<user_constraints>
## User Constraints (from CONTEXT.md)

### Locked Decisions
- **Customer Identity**: Customers (SMEs/Retailers) treated as a Separate Entity linked to a User record.
- **Immediate Reservation**: Stock is allocated from `inventory_batches` using FIFO (received_at ASC) immediately upon order placement.
- **Strict Block**: No backorders allowed; orders must be blocked if stock is insufficient.
- **Document Format**: Printable HTML views for packing slips and invoices using `@media print`.
- **Alerting**: Dashboard flagging for products below `safety_stock`.

### the agent's Discretion
- Database schema for `customers`, `orders`, and `order_items`.
- Specific implementation of FIFO allocation logic.
- Service-layer structure for order processing.

### Deferred Ideas (OUT OF SCOPE)
- Advanced customer sub-user management (multiple users per business).
- External PDF generation libraries (dompdf/snappy).
- External shipping carrier integrations.
</user_constraints>

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|------------------|
| ORD-01 | Web portal for customers to place orders. | UI/UX patterns for simplified customer catalogs. |
| ORD-02 | Web portal for staff to enter orders. | Admin UI for customer selection and order entry. |
| ORD-03 | Track order status lifecycle. | Enum/State mapping for Pending -> Delivered. |
| ORD-04 | Validate orders against inventory levels. | Service layer logic for aggregate stock checks. |
| ORD-05 | Generate packing slips and invoices. | CSS `@media print` patterns for professional documents. |
| INV-05 | Define safety stock and trigger alerts. | SQL/Eloquent aggregate queries for threshold monitoring. |
</phase_requirements>

## Architectural Responsibility Map

| Capability | Primary Tier | Secondary Tier | Rationale |
|------------|-------------|----------------|-----------|
| Customer Profile | Database | API / Backend | Persistent business data and RBAC linkage. |
| Stock Validation | API / Backend | — | Business logic to enforce "Strict Block" policy. |
| FIFO Allocation | API / Backend | Database | Transactional logic selecting batches by age. |
| Order State | API / Backend | Database | State machine managing lifecycle transitions. |
| Printable Documents| Frontend (SSR) | Browser | Blade views optimized for printing. |
| Low Stock Alerts | Database | Frontend | Background/Periodic queries and UI flags. |

## Standard Stack

### Core
| Library | Version | Purpose | Why Standard |
|---------|---------|---------|--------------|
| Laravel | 12.x | Backend Framework | Project foundation [VERIFIED: composer.json] |
| Bootstrap | 5.3.x | UI Styling | Standard CSS framework in project [VERIFIED: package.json] |
| MySQL | 8.0+ | Persistence | Standard relational DB for transactional integrity [ASSUMED] |

### Supporting
| Library | Version | Purpose | When to Use |
|---------|---------|---------|--------------|
| Alpine.js | 3.x | Lightweight JS | For dynamic order item rows without full SPA complexity. |

## Package Legitimacy Audit

| Package | Registry | Age | Downloads | Source Repo | Verdict | Disposition |
|---------|----------|-----|-----------|-------------|---------|-------------|
| laravel/framework | npm | 13 yrs | 35M/mo | github.com/laravel/framework | [OK] | Approved |
| bootstrap | npm | 13 yrs | 20M/wk | github.com/twbs/bootstrap | [OK] | Approved |

## Architecture Patterns

### System Architecture Diagram
(Request) -> [OrderController] -> [OrderService]
                                      |
                                      +-> [Validation: Product::getCurrentStockAttribute()]
                                      +-> [DB Transaction Start]
                                      |     +-> [Create Order & Items]
                                      |     +-> [InventoryService::allocateFIFO()]
                                      |           +-> [Loop: InventoryBatch(received_at ASC)]
                                      |           +-> [Update current_quantity]
                                      |           +-> [Log InventoryMovement(outbound)]
                                      +-> [DB Transaction Commit]
                                      |
(Response) <- [Success Message]

### Recommended Project Structure
```
app/
├── Services/
│   ├── OrderService.php      # Atomic order placement
│   └── InventoryService.php  # FIFO logic and movement logging
├── Http/
│   ├── Requests/
│   │   └── StoreOrderRequest.php # Order validation
│   └── Controllers/
│       ├── Customer/         # Customer portal controllers
│       └── Staff/            # Staff order management
```

### Pattern 1: Service Layer with Database Transactions
**What:** Encapsulate business logic that spans multiple models (Order, Item, Batch, Movement) into a single service method wrapped in a transaction.
**When to use:** Crucial for `ORD-04` to ensure stock is never deducted without an order, or vice-versa.

### Anti-Patterns to Avoid
- **Controller-Fat Allocation:** Putting FIFO logic in the `OrderController` makes it hard to test and reuse for "Staff Order Entry".
- **Floating Quantities:** Trusting the total stock number without checking individual batches during reservation.

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Transaction Retries | Manual try/catch loops | `DB::transaction()` | Laravel handles deadlock retries and rollback cleanly. |
| Status Enums | Complex string constants | PHP 8.1+ Enums | Type safety and easier validation in Laravel 12. |

## Architecture Patterns (FIFO Implementation)

### Code Example: FIFO Stock Reservation Logic
```php
// Source: Recommended Pattern for Laravel Inventory
public function allocateFIFO(Order $order)
{
    foreach ($order->items as $item) {
        $remaining = $item->quantity;
        
        $batches = InventoryBatch::where('product_id', $item->product_id)
            ->where('current_quantity', '>', 0)
            ->orderBy('received_at', 'asc')
            ->orderBy('id', 'asc')
            ->lockForUpdate() // Prevent race conditions
            ->get();

        foreach ($batches as $batch) {
            $allocation = min($batch->current_quantity, $remaining);
            
            $batch->decrement('current_quantity', $allocation);
            
            // Record movement for audit
            InventoryMovement::create([
                'product_id' => $item->product_id,
                'quantity' => -$allocation,
                'type' => 'sale_fulfillment',
                'reference_type' => 'Order',
                'reference_id' => $order->id,
                'batch_id' => $batch->id, // Add this column to schema
                'user_id' => auth()->id()
            ]);

            $remaining -= $allocation;
            if ($remaining <= 0) break;
        }
    }
}
```

## Common Pitfalls

### Pitfall 1: Race Conditions during High-Volume Ordering
**What goes wrong:** Two users check stock at the same time, both see 10 units available, both order 10.
**How to avoid:** Use `DB::transaction()` combined with `lockForUpdate()` on the `inventory_batches` records during allocation.

### Pitfall 2: Print Layout Fragmentation
**What goes wrong:** Packing slips look different across Chrome, Firefox, and Edge.
**How to avoid:** Use a minimal, standard CSS reset for `@media print` and test with "Print to PDF" early.

## Environment Availability

| Dependency | Required By | Available | Version | Fallback |
|------------|------------|-----------|---------|----------|
| PHP | Core | ✓ | 8.2 | — |
| Node.js | Vite / Build | ✓ | 24.16 | — |
| MySQL | Data | ✓ | [ASSUMED] | — |

## Validation Architecture

### Test Framework
| Property | Value |
|----------|-------|
| Framework | PHPUnit 11 |
| Quick run command | `php artisan test --filter Order` |
| Full suite command | `php artisan test` |

### Phase Requirements → Test Map
| Req ID | Behavior | Test Type | Automated Command |
|--------|----------|-----------|-------------------|
| ORD-04 | Block order if stock insufficient | Feature | `php artisan test --filter OrderTest::test_insufficient_stock_is_blocked` |
| FIFO-01 | Allocate from oldest batch first | Unit | `php artisan test --filter InventoryServiceTest::test_fifo_allocation_logic` |

## Security Domain

### Applicable ASVS Categories
| ASVS Category | Applies | Standard Control |
|---------------|---------|-----------------|
| V4 Access Control | Yes | Laravel Policies to ensure Customers only see their own orders. |
| V5 Input Validation | Yes | `StoreOrderRequest` with `min:1` for quantities and existence checks. |

### Known Threat Patterns
| Pattern | STRIDE | Standard Mitigation |
|---------|--------|---------------------|
| Order Tampering | Tampering | Check that `customer_id` matches authenticated user's ID on submission. |
| Stock Exhaustion | DOS | Rate limit order placement and validate stock early. |

## Sources
- [Laravel Documentation] - Transactions and Database Locking.
- [Bootstrap 5 Documentation] - Print utilities.
- [FIFO Inventory Patterns] - Standard industry logic for batch tracking.

## Assumptions Log

| # | Claim | Section | Risk if Wrong |
|---|-------|---------|---------------|
| A1 | MySQL supports `lockForUpdate` | Pitfalls | Low - standard feature of InnoDB. |
| A2 | Bootstrap 5 print classes suffice | Document Format | Medium - might need custom CSS for layout. |

## Metadata
**Confidence breakdown:**
- Standard stack: HIGH
- FIFO Logic: HIGH
- Printable CSS: MEDIUM (Layout specifics vary)

**Research date:** 2025-03-24
**Valid until:** 2025-04-24
