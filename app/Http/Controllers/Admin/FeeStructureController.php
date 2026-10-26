<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeeStructureRequest;
use App\Models\FeeHead;
use App\Models\FeeStructure;
use App\Models\SchoolClass;
use App\Services\Admin\StudentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FeeStructureController extends Controller
{
    public function index(): View
    {
        $structures = FeeStructure::with('schoolClass:id,name')->withSum('items as total', 'amount')
            ->orderByDesc('session')->orderBy('school_class_id')->get();

        return view('backend.fees.structures.index', compact('structures'));
    }

    public function create(): View
    {
        return $this->form(new FeeStructure(['session' => app(StudentService::class)->defaultSession(), 'is_active' => true]));
    }

    public function store(FeeStructureRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $structure = FeeStructure::create($this->fields($request));
            $this->saveItems($structure, $request->input('items', []));
        });

        toastr()->success('Fee structure saved.');

        return redirect()->route('fees.structures.index');
    }

    public function edit(FeeStructure $structure): View
    {
        return $this->form($structure);
    }

    public function update(FeeStructureRequest $request, FeeStructure $structure): RedirectResponse
    {
        DB::transaction(function () use ($request, $structure) {
            $structure->update($this->fields($request));
            $this->saveItems($structure, $request->input('items', []));
        });

        toastr()->success('Fee structure updated. Vouchers already created are not changed.');

        return redirect()->route('fees.structures.index');
    }

    public function destroy(FeeStructure $structure): RedirectResponse
    {
        $structure->delete(); // vouchers keep their own copy of every amount

        toastr()->success('Fee structure deleted.');

        return redirect()->route('fees.structures.index');
    }

    private function form(FeeStructure $structure): View
    {
        return view('backend.fees.structures.form', [
            'structure' => $structure,
            'classes'   => SchoolClass::orderBy('sort_order')->orderBy('name')->get(),
            'heads'     => FeeHead::forStructures()->orderBy('sort_order')->get(),
            'amounts'   => $structure->exists ? $structure->items()->pluck('amount', 'fee_head_id') : collect(),
        ]);
    }

    private function fields(FeeStructureRequest $request): array
    {
        $class = SchoolClass::findOrFail($request->input('school_class_id'));

        return [
            'name'            => $request->input('name') ?: $class->name . ' – ' . $request->input('session'),
            'school_class_id' => $class->id,
            'session'         => $request->input('session'),
            'is_active'       => $request->boolean('is_active'),
        ];
    }

    private function saveItems(FeeStructure $structure, array $items): void
    {
        foreach ($items as $headId => $amount) {
            if ((float) $amount > 0) {
                $structure->items()->updateOrCreate(['fee_head_id' => (int) $headId], ['amount' => round((float) $amount, 2)]);
            } else {
                $structure->items()->where('fee_head_id', (int) $headId)->delete();
            }
        }
    }
}