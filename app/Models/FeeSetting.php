<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeSetting extends Model
{
    protected $fillable = ['name', 'value'];

    public const DEFAULT_VOUCHER_NOTES = "1. The voucher must be deposited within validity date.\n2. No one is authorized to receive the fee without voucher.\n3. If a student is absent more than two weeks without notice and fee is not paid his/her name will be struck off the rolls. (Readmission Fee Rs.2000)\n4. Student will not be allowed to attend/join the class after validity date.\n5. Fee once deposited will be non refundable/non transferable.\n6. Duplicate voucher charges will be Rs.50.\n7. Receive your Roll No. slip after clearance.";

    /** Basic school details, bank details, and the few fee rules used by the module. */
    public const DEFAULTS = [
        'college_name'             => 'King TAS College of Nursing & Allied Health Sciences',
        'college_address'          => 'Main Painsara Road, College Road, Near Model City Phase 3, Gojra, Toba Tek Singh, Punjab',
        'college_phone'            => '0302-8098542 | 0326-0298542',
        'college_email'            => 'info@kingtascollege.com',
        'bank_name'                => 'Bank Alfalah',
        'bank_branch'              => '',
        'account_title'            => '',
        'account_number'           => 'PK43ALFH0160001008136019',
        'due_day'                  => '10',
        'late_fee_enabled'         => '1',
        'late_fee_per_day'         => '100',
        'absent_fine_per_day'      => '0',
        'readmission_fee'          => '2000',
        'voucher_notes'            => self::DEFAULT_VOUCHER_NOTES,
    ];

    private static ?array $cache = null;

    public static function flush(): void
    {
        self::$cache = null;
    }

    public static function get(string $name): string
    {
        self::$cache ??= self::query()->pluck('value', 'name')->all();

        return (string) (self::$cache[$name] ?? self::DEFAULTS[$name] ?? '');
    }

    public static function number(string $name): float
    {
        return (float) self::get($name);
    }

    public static function enabled(string $name): bool
    {
        return self::get($name) === '1';
    }

    public static function store(array $values): void
    {
        foreach ($values as $name => $value) {
            if (array_key_exists($name, self::DEFAULTS)) {
                self::updateOrCreate(['name' => $name], ['value' => (string) $value]);
            }
        }

        self::flush();
    }

    /** Terms printed on each voucher. One sentence per line. */
    public static function policyLines(): array
    {
        $notes = trim(self::get('voucher_notes'));
        $notes = $notes !== '' ? $notes : self::DEFAULT_VOUCHER_NOTES;

        return array_values(array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n/', $notes) ?: []),
            fn (string $line) => $line !== ''
        ));
    }
}
