# Phase 1: Inventory & Procurement Foundation - Context

**Gathered:** 2026-06-12
**Status:** Ready for planning

<domain>
## Phase Boundary

This phase establishes the master SKU catalog, supplier directory, manual purchase order (PO) workflows, goods receiving/reconciliation into inventory batches, and FIFO movement logs in the single centralized warehouse.

</domain>

<decisions>
## Implementation Decisions

### Catalog Details
- **D-01:** Add nullable string/text columns for category and description to the `products` table for simple cataloging. This keeps the schema simple for the initial MVP while satisfying INV-01.

### Batch Tracking & Expiry
- **D-02:** Make batch numbers and expiry dates optional (nullable) at the database level. If empty at receipt, the system can automatically generate a timestamp-based batch number.

### PO Reconciliation & Discrepancies
- **D-03:** Allow short-shipments; accumulate received quantities on purchase order items. The PO can be marked as 'received' with discrepancies, logging the mismatch in a remarks/adjustment log.

### Supplier-Product Catalog
- **D-04:** Allow any product from the catalog to be added to any supplier's PO (loose association), while recording the supplier ID on the PO itself. Explicit supplier-product mapping is deferred.

### Claude's Discretion
- Standard Laravel Breeze controllers, resource route conventions, and Tailwind/Bootstrap/Alpine.js stack will be used for layouts.

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Core Planning Docs
- `.planning/ROADMAP.md` — Phase 1 definition and success criteria
- `.planning/REQUIREMENTS.md` — INV-01, INV-02, INV-03, INV-04, PRO-01, PRO-02, PRO-03, PRO-05

</canonical_refs>

<code_context>
## Existing Code Insights

### Reusable Assets
- [Product](file:///C:/Users/LENOVO/logistic-management-system/app/Models/Product.php): Existing model containing relations to batch and movement logs.
- [Supplier](file:///C:/Users/LENOVO/logistic-management-system/app/Models/Supplier.php): Existing model representing B2B suppliers.
- [PurchaseOrder](file:///C:/Users/LENOVO/logistic-management-system/app/Models/PurchaseOrder.php): Existing model defining the lifecycle of procurement.

### Established Patterns
- Laravel MVC controllers with Breeze middleware-based route guarding ([web.php](file:///C:/Users/LENOVO/logistic-management-system/routes/web.php)).
- Database transactions used during critical operations like creating PO items or receiving goods.

### Integration Points
- `/products` route: catalog management UI.
- `/suppliers` route: supplier directory UI.
- `/purchase-orders` route: PO workflow and receiving operations UI.

</code_context>

<specifics>
## Specific Ideas

No specific requirements — open to standard approaches.

</specifics>

<deferred>
## Deferred Ideas

None — discussion stayed within phase scope.

</deferred>

---

*Phase: 1-Inventory & Procurement Foundation*
*Context gathered: 2026-06-12*
