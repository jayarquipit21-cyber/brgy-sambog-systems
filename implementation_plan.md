# Import and Export All Resident Columns in RBI Manager

Extend the CLI import and export commands to handle all available columns in the `residents` database table.

## Proposed Changes

### Artisan Console Commands

#### [MODIFY] [ManageRbiDatabase.php](file:///c:/Users/brgy/my-blade-app/app/Console/Commands/ManageRbiDatabase.php)
* Update `processImportRows` to map all 66+ columns defined in the `residents` migration.
* Update `handleExport` to include all 66+ columns in the CSV headers and export data rows.

## Verification Plan

### Automated Tests
* Run the Artisan import/export commands using test files containing all fields.

### Manual Verification
* Perform a trial export of existing data to check the output CSV schema.
* Perform a truncate of the residents table, then import the exported CSV to verify that all data (including previously ignored fields) is restored perfectly without loss.

## Status Update (in-repo changes found)

- `app/Console/Commands/ManageRbiDatabase.php`: import and export routines already include mappings for ~66 columns (household/resident fields). The command writes full CSV headers and maps many resident fields on import.

## Remaining Work

- Verify the `Resident` model supports mass-assignment and casting for the added fields.
- Add automated tests to cover import/export roundtrip (CSV/XLSX) including edge cases: missing columns, extra columns, malformed dates.
- Ensure migrations/schema include the fields expected by the import (confirm column names and types).
- Run manual verification: export current data, truncate, import, and compare counts and key field samples.
- Update documentation and `README.md` with new CLI usage and the full CSV schema.
- Commit changes and open a PR for review.

## Acceptance Criteria

- `php artisan rbi:manage export` produces a CSV with the full set of headers.
- Importing that CSV recreates households and residents without loss of non-empty fields.
- Automated tests pass that assert exported headers and import roundtrip integrity.

## Quick Commands

Run export (default file):

```
php artisan rbi:manage export
```

Run import from a CSV file:

```
php artisan rbi:manage import storage/app/exports/rbi_export_2026-06-08_000000.csv
```

## Notes

- The command already handles XLSX via `Shuchkin\SimpleXLSX` and supports multi-sheet imports.
- When adding tests, prefer creating small sample fixtures in `tests/Feature` that assert header presence and roundtrip integrity.

