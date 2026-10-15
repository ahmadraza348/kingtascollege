<?php

namespace App\Services\Admin;

use App\Mail\AdmissionStatusMail;
use App\Models\Admission;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AdmissionManagementService
{
    /**
     * Move an application to a new status and keep a history record.
     * Business rules live here, so the controller stays thin.
     *
     * @throws DomainException when the change is not allowed
     */
    public function changeStatus(Admission $admission, string $status, ?string $remarks, ?int $adminId): void
    {
        if ($status === $admission->status) {
            throw new DomainException('This application is already "' . Admission::STATUSES[$status] . '".');
        }

        if ($status === 'approved' && ! $admission->requiredDocumentsVerified()) {
            throw new DomainException('Verify all required documents before approving this application.');
        }

        if ($status === 'enrolled' && $admission->status !== 'approved') {
            throw new DomainException('Only an approved application can be enrolled.');
        }

        DB::transaction(function () use ($admission, $status, $remarks, $adminId) {
            $from = $admission->status;

            $admission->status = $status;
            $admission->status_updated_at = now();
            $admission->status_updated_by = $adminId;

            // The roll number is created once, when the student is enrolled. It is based on the
            // record id, so it can never clash and needs no counter logic.
            if ($status === 'enrolled' && ! $admission->roll_number) {
                $admission->roll_number = sprintf('KT-%s-%04d', now()->format('y'), $admission->id);
            }

            $admission->save();

            $admission->logs()->create([
                'admin_id'    => $adminId,
                'from_status' => $from,
                'to_status'   => $status,
                'remarks'     => $remarks,
            ]);
        });
    }

    /** Tick / untick one document as verified. Returns the new state. */
    public function toggleDocument(Admission $admission, string $key): bool
    {
        abort_unless($admission->documents()->contains('key', $key), 404);

        $verified = collect($admission->verified_documents ?? []);

        $isNowVerified = ! $verified->contains($key);
        $verified = $isNowVerified ? $verified->push($key) : $verified->reject(fn ($k) => $k === $key);

        $admission->update(['verified_documents' => $verified->unique()->values()->all()]);

        return $isNowVerified;
    }

    /** Email the student about the new status. Never throws. */
    public function notifyStudent(Admission $admission, ?string $remarks): void
    {
        if (empty($admission->email)) {
            return;
        }

        try {
            Mail::to($admission->email)->send(new AdmissionStatusMail($admission, $remarks));
        } catch (Throwable $e) {
            Log::error('Admission status email failed', [
                'admission_id' => $admission->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /** Delete the application together with every uploaded file. */
    public function delete(Admission $admission): void
    {
        $paths = $admission->documents()->pluck('path')->all();

        $admission->delete(); // logs are removed by the cascade

        Storage::disk('local')->delete($paths);
    }

    public function csvHeaders(): array
    {
        return ['Form No', 'Roll No', 'Full Name', 'Father Name', 'CNIC', 'Gender', 'Date of Birth', 'Phone', 'WhatsApp',
            'Email', 'Qualification', 'Institution', 'Percentage', 'Program', 'Session', 'City', 'District', 'Province',
            'Status', 'Submitted On'];
    }

    public function csvRow(Admission $a): array
    {
        return [$a->form_number, $a->roll_number, $a->full_name, $a->father_name, $a->cnic, $a->gender,
            $a->date_of_birth->format('d-m-Y'), $a->phone, $a->whatsapp, $a->email, $a->qualification, $a->institution,
            $a->percentage, $a->program, $a->session, $a->city, $a->district, $a->province,
            $a->status_label, $a->created_at->format('d-m-Y H:i')];
    }
}
