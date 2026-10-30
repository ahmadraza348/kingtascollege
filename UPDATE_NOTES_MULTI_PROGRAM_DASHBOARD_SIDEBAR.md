# King TAS College – Multi-program, Dashboard & Sidebar Update

## What changed

### 1. Multiple programs per student
- The student form now has a searchable multi-select **Programs** field.
- Selected programs are saved as individual rows in `student_programs`.
- The existing `students.program` column is retained for compatibility and stores the first selected program.
- The new migration copies each existing student's current `students.program` value into `student_programs`, so current program information is preserved.
- Student list, student profile, dashboard program statistics, and Excel import now support more than one program.
- Excel files can use the new **Programs** heading and separate multiple program names with `|`, for example: `BSN Generic | Post RN`. Existing files with the old **Program** heading remain supported.

**Important scope note:** This update makes the student's *program selection* multi-valued. The existing Class and Section fields remain a single primary placement, and current attendance and fee workflows continue to use that placement. It does not create separate attendance registers or separate fee plans per program.

### 2. Admin dashboard
The dashboard now includes:
- Total and active students, plus students admitted this month.
- Pending admission applications and total applications.
- Total outstanding voucher balances and fees collected this month.
- Overdue fee vouchers.
- Today's attendance rate and status breakdown.
- Recent admissions, recently added students, and active students by program.
- Quick links for common daily tasks.

### 3. Sidebar navigation
- Navigation is grouped into Admissions & Students, Academic Setup, Daily Operations, Fee Management, and Website & Support.
- Dropdowns include quick links for common pages such as adding/importing students, reviewing pending applications, marking attendance, creating vouchers, recording payments, opening account books, and viewing reports.
- The current module's dropdown remains expanded while navigating within that module.

## Apply the update

1. Back up the live project files and database first.
2. Copy the files from this package into the Laravel project, preserving their directory structure.
3. From the Laravel project root, run:

   ```bash
   php artisan migrate --force
   php artisan optimize:clear
   ```

4. Do **not** run `migrate:fresh`. The new migration adds the linked program table and backfills existing students; it does not require rebuilding the database.
5. Open an existing student, confirm their old program is still selected, add another program, save, and verify the Programs list on the profile.
6. Confirm the dashboard cards and sidebar links load correctly.

## Files included

Only the files changed or added for this update are included in the patch package. The existing `.env`, public assets, `vendor`, `artisan`, and Composer files were not part of the supplied ZIP and are not included here.

## Validation performed

All modified and added PHP source files passed `php -l` syntax checks. A full Laravel runtime test (migrations, route dispatch, Blade rendering, and database queries) could not be run because the supplied archive contains selected application files rather than the complete Laravel project (`artisan`, `composer.json`, and `vendor` were not supplied).
