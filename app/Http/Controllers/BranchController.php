<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
{
    $query = Branches::query();

    // Filter Pencarian
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('city', 'like', '%' . $request->search . '%');
    }

    $branches = $query->where('is_active', true)->get();

    return view('frontend.daftar-toko', compact('branches'));
}
}
