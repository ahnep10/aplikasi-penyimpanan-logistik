# Roadmap: Logistics MIS (B2B Distribution)

## Phases

- [ ] **Phase 1: Inventory & Procurement Foundation** - Establish the master catalog and inbound supply chain foundation.
- [ ] **Phase 2: Order Management & Fulfillment** - Enable customers and staff to place and manage orders with inventory validation.
- [ ] **Phase 3: Fleet Management & Delivery** - Orchestrate last-mile delivery with vehicle assignment and mobile driver interface.
- [ ] **Phase 4: Analytics & Smart Replenishment** - Provide actionable dashboards and automated procurement planning.

## Phase Details

### Phase 1: Inventory & Procurement Foundation
**Goal**: Establish the master catalog and inbound supply chain.
**Depends on**: Nothing
**Requirements**: INV-01, INV-02, INV-03, INV-04, PRO-01, PRO-02, PRO-03, PRO-05
**Success Criteria** (what must be TRUE):
  1. Warehouse staff can manage a master SKU catalog and see real-time stock levels.
  2. Procurement officers can create Purchase Orders and receive inventory from suppliers.
  3. Inventory movements are tracked using FIFO (First-In, First-Out) batch logic.
  4. User can view a complete history of stock adjustments and inbound receipts.
**Plans**: TBD
**UI hint**: yes

### Phase 2: Order Management & Fulfillment
**Goal**: Enable customers and staff to place and manage orders.
**Depends on**: Phase 1
**Requirements**: ORD-01, ORD-02, ORD-03, ORD-04, ORD-05, INV-05
**Success Criteria** (what must be TRUE):
  1. Customers (SMEs) can place orders through a dedicated web portal.
  2. Staff can enter orders on behalf of customers and validate them against stock levels.
  3. Order lifecycle is tracked from pending to packing slip generation.
  4. System triggers low-stock alerts when safety stock thresholds are breached.
**Plans**: TBD
**UI hint**: yes

### Phase 3: Fleet Management & Delivery
**Goal**: Orchestrate the last-mile delivery and proof-of-delivery process.
**Depends on**: Phase 2
**Requirements**: DEL-01, DEL-02, DEL-03, DEL-04, DEL-05
**Success Criteria** (what must be TRUE):
  1. Fleet coordinators can assign orders to vehicles and drivers for daily runs.
  2. Drivers can view their assigned delivery routes on a mobile-responsive interface.
  3. Drivers can capture proof of delivery (PoD) with timestamps and signatures/photos.
  4. Real-time delivery status is visible to both warehouse staff and customers.
**Plans**: TBD
**UI hint**: yes

### Phase 4: Analytics & Smart Replenishment
**Goal**: Provide actionable insights and automate replenishment planning.
**Depends on**: Phase 3
**Requirements**: PRO-04, ANA-01, ANA-02, ANA-03, ANA-04
**Success Criteria** (what must be TRUE):
  1. Managers can view real-time KPIs for inventory turnover and fulfillment rates.
  2. Delivery performance is tracked per driver and route on a dashboard.
  3. System generates automated draft POs based on current sales velocity.
  4. Users can export reports for inventory and sales history in CSV/PDF formats.
**Plans**: TBD
**UI hint**: yes

## Progress

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Inventory & Procurement Foundation | 0/1 | Not started | - |
| 2. Order Management & Fulfillment | 0/1 | Not started | - |
| 3. Fleet Management & Delivery | 0/1 | Not started | - |
| 4. Analytics & Smart Replenishment | 0/1 | Not started | - |
