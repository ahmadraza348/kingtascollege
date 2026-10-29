# King TAS College — Individual Student Monthly Tuition Fee Update

This is a partial update bundle, not a complete Laravel project. Copy these files into the matching paths of your existing project. It intentionally contains only the files required for this change.

## What changed

- The class/session fee structure remains the default; no existing table is recreated or replaced.
- An additive migration adds a nullable `monthly_tuition_fee` column to `students`. No new table is created.
- On the student create/edit form, leave **Monthly Tuition Fee Override (PKR)** blank to inherit the class/session Tuition Fee. Enter an amount to set a custom monthly tuition fee for that student. `0` explicitly waives the tuition line.
- Single and bulk voucher generation both use the same `FeeVoucherService`, so the individual rate flows through voucher item totals, payments, fee statements and reports via the saved voucher snapshot.
- Bulk voucher preview shows the student's selected tuition setting and the calculated voucher total.
- Student import template supports an optional `Monthly Tuition Fee` column.
- Admission and examination fee heads, fines and other non-tuition fee heads continue to follow their existing rules/class fee structure.
- Vouchers already created are not recalculated. If a voucher for a period already exists, the current duplicate-voucher rules still apply; cancel/recreate it through the existing workflow if it must reflect a newly assigned amount.

## Apply safely

1. Back up your database and current project files.
2. Copy the bundle's files/folders into the Laravel project root, preserving paths.
3. From the actual Laravel project root, run:

   ```bash
   php artisan migrate
   ```

4. Edit a student and set the per-student monthly tuition amount in **Fee assignment**. Leave it blank to use the class/session default.
5. Open **Fees → Generate Monthly Vouchers**, select the class and period, review the per-student amounts, and generate vouchers.

Existing students will have `monthly_tuition_fee = NULL` after migration and will therefore continue using the class/session amount until an override is entered.

## Validation performed here

PHP syntax checks passed for all changed PHP files. The provided ZIP is a partial project and does not include the application entry point, `composer.json`, installed dependencies, or a runnable test suite, so a full Laravel migration/integration test could not be run in this environment. Run the migration on a backed-up staging database first.
