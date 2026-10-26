<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateFeeSettingsRequest;
use App\Models\FeeSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeeSettingController extends Controller
{
    public function edit(): View
    {
        $values = [];
        foreach (array_keys(FeeSetting::DEFAULTS) as $name) {
            $values[$name] = FeeSetting::get($name);
        }

        return view('backend.fees.settings', ['v' => $values]);
    }

    public function update(UpdateFeeSettingsRequest $request): RedirectResponse
    {
        FeeSetting::store($request->validated());

        toastr()->success('Fee settings saved.');

        return redirect()->route('fees.settings');
    }
}