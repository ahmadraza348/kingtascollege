<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpenseCategoryRequest;
use App\Models\ExpenseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExpenseCategoryController extends Controller
{
    public function index(): View
    {
        return view('backend.expenses.categories', [
            'categories' => ExpenseCategory::withCount('expenses')->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function store(ExpenseCategoryRequest $request): RedirectResponse
    {
        ExpenseCategory::create([
            'name'       => trim($request->validated('name')),
            'is_active'  => true,
            'sort_order' => (int) ExpenseCategory::max('sort_order') + 1,
        ]);

        toastr()->success('Category added.');

        return redirect()->route('expenses.categories');
    }

    public function update(ExpenseCategoryRequest $request, ExpenseCategory $category): RedirectResponse
    {
        $category->update([
            'name'      => trim($request->validated('name')),
            'is_active' => $request->boolean('is_active'),
        ]);

        toastr()->success('Category updated.');

        return redirect()->route('expenses.categories');
    }

    public function destroy(ExpenseCategory $category): RedirectResponse
    {
        if ($category->expenses()->exists()) {
            toastr()->error('This category already has expenses, so it cannot be deleted. Switch it off instead.');

            return back();
        }

        $category->delete();
        toastr()->success('Category deleted.');

        return redirect()->route('expenses.categories');
    }
}
