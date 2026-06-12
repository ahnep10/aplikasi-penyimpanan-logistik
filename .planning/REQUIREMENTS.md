# Requirements: Logistics MIS (B2B Distribution)

## v1 Requirements

### Inventory Management (INV)
- [ ] **INV-01**: Maintain a real-time master product catalog (SKUs, descriptions, categories).
- [ ] **INV-02**: Track current stock levels for each SKU in the centralized warehouse.
- [ ] **INV-03**: Support Batch/Lot tracking for FIFO (First-In, First-Out) inventory movement.
- [ ] **INV-04**: Record all inventory movements (Inbound from suppliers, Outbound to customers, internal adjustments).
- [ ] **INV-05**: Define safety stock levels per SKU and trigger low-stock alerts.

### Order Management (ORD)
- [ ] **ORD-01**: Web portal for customers (SMEs/Retailers) to place orders.
- [ ] **ORD-02**: Web portal for staff to enter orders on behalf of customers.
- [ ] **ORD-03**: Track order status lifecycle: Pending, Processing, Dispatched, Delivered, Cancelled.
- [ ] **ORD-04**: Validate orders against current inventory levels before confirmation.
- [ ] **ORD-05**: Generate packing slips and invoices for each order.

### Fleet & Delivery (DEL)
- [ ] **DEL-01**: Manage vehicle registry (type, capacity, status) and driver profiles.
- [ ] **DEL-02**: Assign orders to specific vehicles and drivers for daily delivery runs.
- [ ] **DEL-03**: Mobile-responsive driver interface to view assigned delivery routes and order details.
- [ ] **DEL-04**: Proof of Delivery (PoD) capture (Status: Delivered, Timestamp, Digital Signature/Photo).
- [ ] **DEL-05**: Real-time delivery status updates visible to warehouse staff and customers.

### Procurement & Supplier Management (PRO)
- [ ] **PRO-01**: Maintain a directory of suppliers and their associated products.
- [ ] **PRO-02**: Manual Purchase Order (PO) creation for stock replenishment.
- [ ] **PRO-03**: Track PO status from "Ordered" to "Received" in the warehouse.
- [ ] **PRO-04**: Automated replenishment planning: Generate draft POs based on safety stock and current velocity.
- [ ] **PRO-05**: Reconcile received goods against original POs to update inventory.

### Reporting & Analytics (ANA)
- [ ] **ANA-01**: Inventory Turnover Dashboard (Monitor stock movement efficiency).
- [ ] **ANA-02**: Order Fulfillment Dashboard (Track on-time and successful completion rates).
- [ ] **ANA-03**: Delivery Performance Dashboard (On-time delivery rate, average delivery time per driver).
- [ ] **ANA-04**: Exportable reports (CSV/PDF) for inventory levels and sales history.

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| INV-01 | Phase 1 | Pending |
| INV-02 | Phase 1 | Pending |
| INV-03 | Phase 1 | Pending |
| INV-04 | Phase 1 | Pending |
| INV-05 | Phase 2 | Pending |
| ORD-01 | Phase 2 | Pending |
| ORD-02 | Phase 2 | Pending |
| ORD-03 | Phase 2 | Pending |
| ORD-04 | Phase 2 | Pending |
| ORD-05 | Phase 2 | Pending |
| DEL-01 | Phase 3 | Pending |
| DEL-02 | Phase 3 | Pending |
| DEL-03 | Phase 3 | Pending |
| DEL-04 | Phase 3 | Pending |
| DEL-05 | Phase 3 | Pending |
| PRO-01 | Phase 1 | Pending |
| PRO-02 | Phase 1 | Pending |
| PRO-03 | Phase 1 | Pending |
| PRO-04 | Phase 4 | Pending |
| PRO-05 | Phase 1 | Pending |
| ANA-01 | Phase 4 | Pending |
| ANA-02 | Phase 4 | Pending |
| ANA-03 | Phase 4 | Pending |
| ANA-04 | Phase 4 | Pending |

## v2 Requirements (Deferred)
- [ ] **Multi-Warehouse Support**: Cross-docking and inter-warehouse transfers.
- [ ] **External API Integration**: Sync orders and inventory with customer ERPs.
- [ ] **Dynamic Route Optimization**: AI-driven pathfinding for delivery efficiency.
- [ ] **Warehouse Mapping**: Bin-level location tracking and optimized picking routes.

## Out of Scope
- **3PL Management**: This version is strictly for the internal fleet.
- **Consumer (B2C) E-commerce**: This is a B2B system only.
- **Manufacturing/Production**: No support for raw material transformation.

## Definition of Done (Project-Wide)
- Code follows project standards and passes linter/type checks.
- Every requirement has a corresponding automated test.
- Features verified through the "Verifier" agent if enabled.
- UI components (where applicable) meet design specs.

---
*Last updated: Wednesday, 10 June 2026*
