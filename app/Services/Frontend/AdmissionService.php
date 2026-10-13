<?php

namespace App\Services\Frontend;

use App\Models\Admission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class AdmissionService
{
    /**
     * Store an admission application's documents and persist the application.
     * Uploaded records are stored on the private local disk, not in public storage.
     *
     * @param array<string, mixed> $validated
     */
    public function create(array $validated): Admission
    {
        $storedPaths = [];

        try {
            $cnicFrontPath = $this->storeFile(
                $validated['cnic_front'],
                'admissions/cnic',
                $storedPaths
            );

            $cnicBackPath = $this->storeFile(
                $validated['cnic_back'],
                'admissions/cnic',
                $storedPaths
            );

            $domicilePath = $this->storeFile(
                $validated['domicile_document'],
                'admissions/domicile',
                $storedPaths
            );

            $degreeDocumentPaths = $this->storeFiles(
                $validated['degree_documents'],
                'admissions/education',
                $storedPaths
            );

            $picturePath = $this->storeFile(
                $validated['personal_picture'],
                'admissions/photos',
                $storedPaths
            );

            $otherDocumentPaths = $this->storeFiles(
                $validated['other_documents'] ?? [],
                'admissions/additional',
                $storedPaths
            );

            return DB::transaction(function () use (
                $validated,
                $cnicFrontPath,
                $cnicBackPath,
                $domicilePath,
                $degreeDocumentPaths,
                $picturePath,
                $otherDocumentPaths
            ): Admission {
                return Admission::create([
                    'full_name' => $validated['fullName'],
                    'father_name' => $validated['fatherName'],
                    'date_of_birth' => $validated['dob'],
                    'gender' => $validated['gender'],
                    'cnic' => $validated['cnic'],
                    'phone' => $validated['phone'],
                    'whatsapp' => $validated['whatsapp'] ?? null,
                    'email' => $validated['email'] ?? null,

                    'qualification' => $validated['qualification'],
                    'institution' => $validated['institution'],
                    'obtained_marks' => $validated['obtained'] ?? null,
                    'total_marks' => $validated['total'] ?? null,
                    'percentage' => $validated['percentage'] ?? null,

                    'program' => $validated['program'],
                    'session' => '2026–27',
                    'notes' => $validated['notes'] ?? null,

                    'street' => $validated['street'],
                    'city' => $validated['city'],
                    'district' => $validated['district'] ?? null,
                    'province' => $validated['province'] ?? null,

                    'cnic_front_path' => $cnicFrontPath,
                    'cnic_back_path' => $cnicBackPath,
                    'domicile_document_path' => $domicilePath,
                    'degree_documents' => $degreeDocumentPaths,
                    'personal_picture_path' => $picturePath,
                    'other_documents' => $otherDocumentPaths,

                    'terms_accepted' => true,
                    'status' => 'pending',
                ]);
            });
        } catch (Throwable $exception) {
            // If storage or database persistence fails, remove files uploaded for this attempt.
            if ($storedPaths !== []) {
                Storage::disk('local')->delete($storedPaths);
            }

            throw $exception;
        }
    }

    /**
     * Store one uploaded file and track it for cleanup in case persistence fails.
     *
     * @param array<int, string> $storedPaths
     */
    private function storeFile(UploadedFile $file, string $directory, array &$storedPaths): string
    {
        $path = $file->store($directory, 'local');

        if (! is_string($path) || $path === '') {
            throw new RuntimeException('An admission document could not be stored.');
        }

        $storedPaths[] = $path;

        return $path;
    }

    /**
     * @param array<int, UploadedFile> $files
     * @param array<int, string> $storedPaths
     * @return array<int, string>
     */
    private function storeFiles(array $files, string $directory, array &$storedPaths): array
    {
        $paths = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                throw new RuntimeException('An admission document upload is invalid.');
            }

            $paths[] = $this->storeFile($file, $directory, $storedPaths);
        }

        return $paths;
    }
}
