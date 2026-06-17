# Phase 2 Context: Order Management & Fulfillment

## Implementation Decisions

### 1. Customer Identity & Access
- **Decision**: Customers (SMEs/Retailers) will be treated as a **Separate Entity**.
- **Details**: A `Customer` model will be created to store business details (Company Name, Tax ID, Delivery Address). Each `Customer` will be associated with a `User` record for authentication purposes. This allows multiple staff members of a single customer business to potentially log in in the future.
- **Access**: Customers will have restricted access to the portal, only seeing their own orders and the product catalog.

### 2. Inventory Allocation (FIFO)
- **Decision**: **Immediate Reservation** upon order placement.
- **Details**: When a customer or staff member submits an order, the system will immediately allocate stock from `inventory_batches` using FIFO (sorted by `received_at` ASC).
- **Mechanism**: The `current_quantity` of relevant batches will be decremented, and an `InventoryMovement` record (Outbound) will be created. This prevents "double-selling" of stock that hasn't shipped yet.

### 3. Order Validation & Backorders
- **Decision**: **Strict Block** policy.
- **Details**: The system will not allow an order to be placed if the requested quantity exceeds the current aggregate stock level for a SKU. Users will be notified of insufficient stock during the "add to cart" or "checkout" process.

### 4. Document Generation
- **Decision**: **Printable HTML** for packing slips and invoices.
- **Details**: The system will provide clean, CSS-styled HTML views for orders that are optimized for browser-based printing (using `@media print` stylesheets). This avoids the overhead of PDF generation libraries like `dompdf` in this phase.

### 5. Low-Stock Alerts
- **Decision**: Dashboard flagging with persistent notifications.
- **Details**: The system will use the `safety_stock` attribute defined in Phase 1 to highlight products on the staff/admin dashboards. An "Alerts" section will be added to the Warehouse Staff and Manager dashboards.

## Refined Data Model Changes

### New Models
- `Customer`: `id`, `name`, `business_address`, `phone`, `email`, `user_id` (FK).
- `Order`: `id`, `customer_id` (FK), `status` (pending, processing, dispatched, delivered, cancelled), `total_amount`, `shipping_address`, `created_by` (FK to User).
- `OrderItem`: `id`, `order_id` (FK), `product_id` (FK), `quantity`, `unit_price`, `subtotal`.

### Existing Model Extensions
- `Product`: Add logic to find and allocate stock from batches.
- `User`: Support linking to a `Customer`.

## UI/UX Patterns
- **Customer Portal**: A simplified version of the dashboard focusing on "My Orders" and "Place New Order".
- **Staff Fulfillment View**: A "Picking" list that shows which batches to pull from based on the allocation logic.

## Reusable Patterns from Phase 1
- **RBAC**: Use `RoleMiddleware` to restrict access to order management.
- **Bootstrap 5 + Blade**: Maintain the same aesthetic and layout established in the Foundation phase.
- **Movement Logging**: All outbound shipments must follow the `inventory_movements` pattern.
