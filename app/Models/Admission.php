<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Admission extends Model
{
    /** status key => label */
    public const STATUSES = [
        'pending'            => 'Pending',
        'under_review'       => 'Under Review',
        'documents_required' => 'Documents Required',
        'approved'           => 'Approved',
        'rejected'           => 'Rejected',
        'enrolled'           => 'Enrolled',
    ];

    /** status key => bootstrap colour */
    public const STATUS_COLORS = [
        'pending'            => 'warning',
        'under_review'       => 'info',
        'documents_required' => 'secondary',
        'approved'           => 'success',
        'rejected'           => 'danger',
        'enrolled'           => 'primary',
    ];

    protected $fillable = [
        'full_name',
        'father_name',
        'date_of_birth',
        'gender',
        'cnic',
        'phone',
        'whatsapp',
        'email',
        'qualification',
        'institution',
        'obtained_marks',
        'total_marks',
        'percentage',
        'program',
        'session',
        'notes',
        'street',
        'city',
        'district',
        'province',
        'cnic_front_path',
        'cnic_back_path',
        'domicile_document_path',
        'degree_documents',
        'personal_picture_path',
        'other_documents',
        'terms_accepted',
        'status',
        'roll_number',
        'verified_documents',
        'internal_notes',
        'status_updated_at',
        'status_updated_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'obtained_marks' => 'decimal:2',
        'total_marks' => 'decimal:2',
        'percentage' => 'decimal:2',
        'degree_documents' => 'array',
        'other_documents' => 'array',
        'verified_documents' => 'array',
        'terms_accepted' => 'boolean',
        'status_updated_at' => 'datetime',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(AdmissionLog::class)->latest();
    }

    /**
     * Human-friendly admission form number, e.g. KTC-2026-00042.
     * Derived from the record id + year, so it is stable and needs no extra column.
     */
    protected function formNumber(): Attribute
    {
        return Attribute::get(function () {
            $year = ($this->created_at ?? now())->format('Y');

            return sprintf('KTC-%s-%05d', $year, $this->id);
        });
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::STATUSES[$this->status] ?? ucfirst($this->status));
    }

    protected function statusColor(): Attribute
    {
        return Attribute::get(fn () => self::STATUS_COLORS[$this->status] ?? 'secondary');
    }

    /** wa.me link built from the WhatsApp number (or phone when none given). */
    protected function whatsappLink(): Attribute
    {
        return Attribute::get(function () {
            $digits = preg_replace('/\D/', '', $this->whatsapp ?: $this->phone);

            if (str_starts_with($digits, '0')) {
                $digits = '92' . substr($digits, 1);
            }

            return 'https://wa.me/' . $digits;
        });
    }

    /**
     * Every uploaded file as a flat list: key, label, path, required.
     * The key is what the admin routes use, so raw paths are never exposed in URLs.
     *
     * @return Collection<int, array{key:string,label:string,path:string,required:bool}>
     */
    public function documents(): Collection
    {
        $docs = collect([
            ['key' => 'cnic_front', 'label' => 'CNIC / B-Form (front)', 'path' => $this->cnic_front_path, 'required' => true],
            ['key' => 'cnic_back', 'label' => 'CNIC / B-Form (back)', 'path' => $this->cnic_back_path, 'required' => true],
            ['key' => 'domicile', 'label' => 'Domicile certificate', 'path' => $this->domicile_document_path, 'required' => true],
            ['key' => 'photo', 'label' => 'Personal photograph', 'path' => $this->personal_picture_path, 'required' => true],
        ]);

        foreach (($this->degree_documents ?? []) as $i => $path) {
            $docs->push(['key' => 'degree_' . $i, 'label' => 'Educational document ' . ($i + 1), 'path' => $path, 'required' => true]);
        }

        foreach (($this->other_documents ?? []) as $i => $path) {
            $docs->push(['key' => 'other_' . $i, 'label' => 'Additional document ' . ($i + 1), 'path' => $path, 'required' => false]);
        }

        return $docs->filter(fn ($d) => ! empty($d['path']))->values();
    }

    public function isDocumentVerified(string $key): bool
    {
        return in_array($key, $this->verified_documents ?? [], true);
    }

    /** True when every required document has been ticked as verified. */
    public function requiredDocumentsVerified(): bool
    {
        return $this->documents()
            ->where('required', true)
            ->every(fn ($d) => $this->isDocumentVerified($d['key']));
    }

    // student relationship: one admission can become one student, but not all admissions do.

        public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Find an application from its form number (KTC-2026-00042).
     * The number is built from the id and year, so we read the id back and re-check the whole string.
     */
    public static function findByFormNumber(string $formNumber): ?self
    {
        $formNumber = strtoupper(trim($formNumber));

        if (! preg_match('/^KTC-\d{4}-(\d+)$/', $formNumber, $m)) {
            return null;
        }

        $admission = static::find((int) $m[1]);

        return $admission && $admission->form_number === $formNumber ? $admission : null;
    }
}
