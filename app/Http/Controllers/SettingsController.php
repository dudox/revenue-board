<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Settings\StoreStartScreen;
use App\Screen;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //
    public function updateStartScreen(StoreStartScreen $request)
    {
        $screenOne = Screen::where('type', 1)->first();
        $screenTwo = Screen::where('type', 2)->first();
        $screenOne->update([
            'message' => $request->first,
        ]);

        $screenTwo->update([
            'message' => $request->second,
        ]);

        return back()->with('suucess', 'Updated Successfully');
    }
}
