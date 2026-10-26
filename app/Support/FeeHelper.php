<?php

namespace App\Support;

use App\Models\FeeSetting;
use Carbon\CarbonImmutable;

class FeeHelper
{
    /** "Today" in the college's timezone (the app itself stays on UTC). */
    public static function today(): CarbonImmutable
    {
        return CarbonImmutable::now(config('fees.timezone', 'UTC'))->startOfDay();
    }

    /** Rs. 5,000  or  Rs. 5,000.50 */
    public static function money(float|int|string|null $amount): string
    {
        return 'Rs. ' . self::number($amount);
    }

    public static function number(float|int|string|null $amount): string
    {
        $amount = (float) $amount;

        return number_format($amount, fmod($amount, 1) == 0.0 ? 0 : 2);
    }

    // Money is added up in paisa (whole numbers) so there are never rounding surprises.
    public static function paisa(float|int|string|null $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    public static function rupees(int $paisa): float
    {
        return round($paisa / 100, 2);
    }

    /** Days from $from to $to (positive when $to is later). Both are Y-m-d. */
    public static function daysBetween(string $from, string $to): int
    {
        return (int) round(CarbonImmutable::parse($from)->diffInDays(CarbonImmutable::parse($to), false));
    }

    /** "2026-10" -> "October 2026" */
    public static function periodLabel(string $period): string
    {
        return CarbonImmutable::createFromFormat('Y-m-d', $period . '-01')->format('F Y');
    }

    /** College details for the top of every PDF. */
    public static function letterhead(): array
    {
        $logo = public_path('frontend/assets/images/logo/logo.png');

        return [
            'name'    => FeeSetting::get('college_name'),
            'address' => FeeSetting::get('college_address'),
            'phone'   => FeeSetting::get('college_phone'),
            'email'   => FeeSetting::get('college_email'),
            'logo'    => is_file($logo) ? $logo : null,
        ];
    }

    /** 12500 -> "Twelve Thousand Five Hundred Rupees Only" (lakh / crore style). */
    public static function words(float $amount): string
    {
        $n = (int) round($amount);

        if ($n <= 0) {
            return 'Zero Rupees Only';
        }

        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve',
            'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        $two  = fn (int $x) => $x < 20 ? $ones[$x] : trim($tens[intdiv($x, 10)] . ' ' . $ones[$x % 10]);

        $parts = [];
        foreach ([[10000000, 'Crore'], [100000, 'Lakh'], [1000, 'Thousand']] as [$size, $label]) {
            if ($n >= $size) {
                $parts[] = $two(intdiv($n, $size)) . ' ' . $label;
                $n %= $size;
            }
        }
        if ($n >= 100) {
            $parts[] = $ones[intdiv($n, 100)] . ' Hundred';
            $n %= 100;
        }
        if ($n > 0) {
            $parts[] = $two($n);
        }

        return trim(implode(' ', $parts)) . ' Rupees Only';
    }
}