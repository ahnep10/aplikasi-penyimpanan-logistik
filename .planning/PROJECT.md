# Project: Logistics MIS (B2B Distribution)

## What This Is
A centralized Logistics Management Information System (MIS) designed for a B2B distribution company. The system orchestrates the entire supply chain from procurement and supplier management to warehouse operations and "last-mile" delivery to small retail stores and SMEs. It replaces manual processes with real-time data visibility, providing managers with actionable dashboards to optimize inventory turnover, fulfillment rates, and delivery performance.

## Core Value
**Operational Transparency & Decision Support:** The system transforms fragmented manual data into a unified, real-time source of truth that enables managers to optimize stock levels and fleet efficiency while ensuring reliable fulfillment for B2B customers.

## Context
- **Target Users:** Warehouse managers, procurement officers, fleet coordinators, drivers, and executive management.
- **Scale:** Initial focus on a single centralized warehouse with a dedicated company-owned fleet; designed for future multi-warehouse and API-driven expansion.
- **Key Challenges:** Real-time inventory tracking, delivery visibility, driver performance monitoring, and manual procurement bottleneck.

## Requirements

### Validated
(None yet — ship to validate)

### Active
- [ ] **Real-time Inventory Management:** Track stock levels, batch/expiry (FIFO), and movements within a single warehouse.
- [ ] **Order Lifecycle Management:** Web portal for customers/staff to enter and track orders from placement to fulfillment.
- [ ] **Fleet & Delivery Orchestration:** Vehicle assignment, delivery scheduling, and mobile-responsive driver interface for Proof of Delivery (PoD).
- [ ] **Automated Procurement Planning:** System-generated replenishment alerts and purchase order (PO) workflows based on safety stock.
- [ ] **Managerial Dashboards:** Real-time KPIs for Inventory Turnover, Order Fulfillment Rate, and Delivery Performance.

### Out of Scope
- **Multi-warehouse Routing (v1):** Initial version focuses on one hub.
- **External API Integrations (v1):** Direct ERP/Customer system syncing deferred to v2.
- **Dynamic Route Optimization (v1):** Initial focus on manual/static assignment and tracking rather than complex AI routing.
- **Third-Party Logistics (3PL) Management:** System optimized for internal fleet operations.

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Internal Fleet Focus | Company owns vehicles; requires deep tracking of drivers and assignments. | Pending |
| Centralized Hub Model | MVP starts with one warehouse to simplify inventory logic before scaling to a network. | Pending |
| Web-First Portal | Ensures immediate accessibility for customers and staff without complex API overhead. | Pending |

## Evolution
This document evolves at phase transitions and milestone boundaries.

**After each phase transition** (via `/gsd-transition`):
1. Requirements invalidated? → Move to Out of Scope with reason
2. Requirements validated? → Move to Validated with phase reference
3. New requirements emerged? → Add to Active
4. Decisions to log? → Add to Key Decisions
5. "What This Is" still accurate? → Update if drifted

**After each milestone** (via `/gsd:complete-milestone`):
1. Full review of all sections
2. Core Value check — still the right priority?
3. Audit Out of Scope — reasons still valid?
4. Update Context with current state

---
*Last updated: Wednesday, 10 June 2026 after initialization*
