<?php

namespace App\Http\Controllers;

use App\Export;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    //
    public function index()
    {
        $exports = Export::orderBy('status', 'ASC')->paginate(20);
        return view('admin.exports.index')->with('exports', $exports);
    }
}
