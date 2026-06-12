# Phase 1: Inventory & Procurement Foundation - Discussion Log

> **Audit trail only.** Do not use as input to planning, research, or execution agents.
> Decisions are captured in CONTEXT.md — this log preserves the alternatives considered.

**Date:** 2026-06-12
**Phase:** 1-Inventory & Procurement Foundation
**Areas discussed:** Catalog Details, Batch Tracking & Expiry, PO Reconciliation & Discrepancies, Supplier-Product Catalog

---

## Catalog Details

| Option | Description | Selected |
|--------|-------------|----------|
| Flat attributes | Add nullable string columns for category and description to products table | ✓ |
| Category table | Create a separate Category model/table with FK | |

**User's choice:** Flat attributes (auto-selected)
**Notes:** Selected the recommended option automatically under --auto mode.

---

## Batch Tracking & Expiry

| Option | Description | Selected |
|--------|-------------|----------|
| Optional at DB level | Make batch numbers and expiry dates optional; system-generate if missing | ✓ |
| Mandatory at validation | Require batch number and expiry date at the validation level | |

**User's choice:** Optional at DB level (auto-selected)
**Notes:** Selected the recommended option automatically under --auto mode.

---

## PO Reconciliation & Discrepancies

| Option | Description | Selected |
|--------|-------------|----------|
| Accumulate received | Allow short-shipments; mark PO received with discrepancies and remarks | ✓ |
| Exact receiving only | Reject over-shipments, leave PO open until fully fulfilled | |

**User's choice:** Accumulate received (auto-selected)
**Notes:** Selected the recommended option automatically under --auto mode.

---

## Supplier-Product Catalog

| Option | Description | Selected |
|--------|-------------|----------|
| Loose catalog link | Allow any product from catalog on any PO, supplier ID on PO only | ✓ |
| Strict mapping | Define many-to-many relationship mapping products to suppliers | |

**User's choice:** Loose catalog link (auto-selected)
**Notes:** Selected the recommended option automatically under --auto mode.

---

## Claude's Discretion

Standard controllers, views, layouts, and style implementations are deferred to Claude.

## Deferred Ideas

None.
