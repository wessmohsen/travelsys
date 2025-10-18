# Drag & Drop Ordering for Program Families

## Overview
Added drag-and-drop functionality to reorder program families in trip programs with automatic ordering persistence.

## Changes Made

### 1. Database Migration
- **File**: `database/migrations/2025_10_18_015733_add_ordering_to_program_families_table.php`
- Added `ordering` column (integer with default 0) to `program_families` table
- Added index on `ordering` for better query performance

### 2. Model Updates

#### ProgramFamily Model
- **File**: `app/Models/ProgramFamily.php`
- Added `ordering` to the `$fillable` array

#### TripProgram Model
- **File**: `app/Models/TripProgram.php`
- Updated `families()` relationship to include `->orderBy('ordering')`
- This ensures families are always loaded in the correct order

### 3. View Updates

#### _family_row.blade.php
- Added hidden input field for `ordering` value
- Added drag handle column (☰ icon) with cursor styling
- The ordering value defaults to the row index if not set

#### _form.blade.php
- Added "Order" column header in the table
- Integrated **SortableJS** library via CDN for drag-and-drop functionality
- Added JavaScript functions:
  - `updateOrdering()`: Updates all ordering inputs based on current row positions
  - Drag-and-drop event handler that calls `updateOrdering()` after reordering
  - Updated "Add Family/Group" button to include drag handle and ordering field
  - Updated "Duplicate Row" functionality to handle ordering
  - Updated "Delete Row" functionality to recalculate ordering after deletion

### 4. Controller
- **File**: `app/Http/Controllers/TripProgramController.php`
- No changes needed! The `ordering` field is automatically saved because:
  - It's in the `$fillable` array
  - Form submission includes the ordering values
  - Laravel mass assignment handles the rest

## How It Works

### User Experience
1. Users see a **☰** icon in the first column of each family row
2. Click and drag the icon to reorder rows
3. Rows smoothly animate to their new positions
4. When "Save Changes" is pressed, the ordering is persisted to the database
5. On page reload, families appear in the saved order

### Technical Flow
1. **Initial Load**: Families load ordered by the `ordering` column
2. **Drag Event**: SortableJS handles the visual reordering
3. **After Drop**: `updateOrdering()` function updates all hidden ordering inputs (0, 1, 2, ...)
4. **Form Submit**: Ordering values are submitted with the form
5. **Database Save**: Controller saves ordering values via mass assignment
6. **Next Load**: Families load in the new order via `orderBy('ordering')`

### Add/Duplicate/Delete
- **Add New Row**: New row gets ordering value = current row count
- **Duplicate Row**: Duplicated row gets ordering value = next available index, then all rows are reordered
- **Delete Row**: After deletion, `updateOrdering()` recalculates all ordering values

## Dependencies
- **SortableJS**: v1.15.0 (loaded via CDN)
  - Library: https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js
  - No additional installation needed

## Browser Compatibility
SortableJS supports:
- Chrome, Firefox, Safari, Edge (modern versions)
- Mobile touch events (iOS Safari, Chrome Mobile)

## Future Enhancements
- Add up/down arrow buttons as alternative to drag-and-drop
- Add "Reset Order" button to reorder alphabetically or by another field
- Show visual feedback (row numbers) that update during drag
