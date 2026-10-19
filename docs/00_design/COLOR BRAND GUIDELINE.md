# 🏢 CorporateFE Color & Brand Identity Guideline
## Enterprise Design Tokens & Visual Hierarchy

> **Target Directory:** `d:\DevMuncen\CorporateFE/docs/00_design/COLOR BRAND GUIDELINE.md`  
> **Brand Identity:** Corporate Enterprise Shipper (`Korporasi Merah Putih`)  
> **Ecosystem Alignment:** Aligned with `BackendCorporateLogistic/docs/COLOR BRAND GUIDELINE.md` and `AgregatorFE`/`LogisticFE` UI engine.

---

## 1. Executive Brand Identity

The **Corporate Portal (`CorporateFE`)** serves enterprise corporate shippers, national manufacturers, FMCG brands, and distribution principals. The design communicates **solidity, executive precision, enterprise reliability, and operational clarity**.

Unlike the Carrier portal (`LogisticFE` - Teal/Amber) or Aggregator portal (`AgregatorFE` - Teal), **CorporateFE** is themed around **Deep Corporate Navy & Enterprise Blue**, accented by crisp **Sky Blue** and soft executive tints.

```
+--------------------------------------------------------------------------+
|  CORPORATE ENTERPRISE PALETTE MATRIX                                     |
+-------------------+----------------+-----------+-------------------------+
| Token Role        | Hex Value      | Tailwind  | Purpose                 |
+-------------------+----------------+-----------+-------------------------+
| PRIMARY           | #1E3A8A        | blue-900  | Main Brand, Sidebar Nav |
| PRIMARY DARK      | #102A5C        | custom    | Topbar, Active Headers  |
| SECONDARY         | #3155A6        | blue-800  | Buttons, Focus Rings    |
| ACCENT            | #60A5FA        | blue-400  | Badges, Live Status     |
| ACCENT SOFT       | #DBEAFE        | blue-100  | Table Hover, Pill Tints |
| BACKGROUND        | #F5F8FC        | custom    | Main Page Shell         |
| SURFACE / CARD    | #FFFFFF        | white     | Content Cards, Modals   |
| TEXT PRIMARY      | #172033        | custom    | Primary Headings, Data  |
| TEXT MUTED        | #64748B        | slate-500 | Labels, Subtitles       |
| BORDER            | #E2E8F0        | slate-200 | Table & Card Borders    |
+-------------------+----------------+-----------+-------------------------+
```

---

## 2. Master Color Tokens

### 2.1 Primary Brand Hierarchy
```css
/* Core Palette */
--color-corp-primary: #1E3A8A;       /* Corporate Navy */
--color-corp-primary-dark: #102A5C;  /* Deep Corporate */
--color-corp-secondary: #3155A6;     /* Enterprise Blue */
--color-corp-accent: #60A5FA;        /* Sky Blue */
--color-corp-accent-soft: #DBEAFE;   /* Soft Blue Tint */
--color-corp-bg: #F5F8FC;            /* Corporate Cool White */
--color-corp-text: #172033;          /* Dark Navy Text */
--color-corp-text-muted: #64748B;    /* Neutral Slate */
```

### 2.2 Semantic Status & Lifecycle Badges
Every operational order and child waybill state uses semantic badges:

| Order / Waybill Status | Badge Background | Badge Text | Border | Description |
| :--- | :--- | :--- | :--- | :--- |
| **`draft`** | `bg-slate-100` | `text-slate-700` | `border-slate-300` | Initial order intake draft |
| **`confirmed`** | `bg-blue-50` | `text-blue-700` | `border-blue-200` | Approved by corporate, awaiting pickup |
| **`scheduled`** | `bg-indigo-50` | `text-indigo-700` | `border-indigo-200` | Linked distributor order scheduled |
| **`pickup` / `transit`** | `bg-amber-50` | `text-amber-700` | `border-amber-200` | In transit on carrier fleet |
| **`delivered`** | `bg-teal-50` | `text-teal-700` | `border-teal-200` | Dropped at delivery point, POD verified |
| **`finalized` / `completed`** | `bg-emerald-50`| `text-emerald-700`| `border-emerald-200` | All drops delivered & RO closed |
| **`hold`** | `bg-orange-50` | `text-orange-700` | `border-orange-200` | Shipment paused by dispatcher |
| **`cancelled`** | `bg-rose-50` | `text-rose-700` | `border-rose-200` | Voided request order |

---

## 3. Typography & UI Spacing

- **Primary Font Family:** `Inter`, `Plus Jakarta Sans`, system-ui, sans-serif.
- **Headings:**
  - `h1` (Page Title): `text-2xl font-bold tracking-tight text-[#172033]`
  - `h2` (Card / Section Title): `text-lg font-semibold text-[#172033]`
  - `h3` (Modal Header): `text-base font-semibold text-[#172033]`
- **Body & Data Grid:**
  - Standard Body: `text-sm text-slate-700 leading-relaxed`
  - Table Data Cells: `text-xs md:text-sm font-medium text-slate-800`
  - Captions & Form Hints: `text-xs text-slate-500`

---

## 4. Unconstrained Modal Stacking Hierarchy (`z-index`)

To eliminate fixed modal backdrops trapping or clipping selection pickers (e.g. Product Pickers, Warehouse Selectors, City Pickers):
- The root `<div class="page-wrapper">` is kept free of arbitrary `z-10` stacking contexts.
- Strict z-index tokens across all layout layers:

```css
/* Z-Index Hierarchy Standard */
--z-header: 20;               /* Sticky Top Navigation */
--z-sidebar: 30;              /* Left Sidebar Drawer */
--z-overlay-backdrop: 40;     /* Darkened Modal Backdrop (!z-[40]) */
--z-modal-dialog: 60;         /* Primary Form Modals (!z-[60]) */
--z-modal-picker: 80;         /* High-Layer Relational Pickers (!z-[80]) */
--z-toast-notification: 100;  /* System Feedback & Toasts (!z-[100]) */
```

---

## 5. Tailwind CSS v4 Theme Integration

In `resources/css/app.css`:
```css
@import "tailwindcss";

@theme {
  --color-corporate-50: #eff6ff;
  --color-corporate-100: #dbeafe;
  --color-corporate-200: #bfdbfe;
  --color-corporate-300: #93c5fd;
  --color-corporate-400: #60a5fa;
  --color-corporate-500: #3b82f6;
  --color-corporate-600: #2563eb;
  --color-corporate-700: #1d4ed8;
  --color-corporate-800: #1e3a8a; /* Brand Primary */
  --color-corporate-900: #102a5c; /* Brand Primary Dark */
  --color-corporate-950: #0b1a3a;
}
```
