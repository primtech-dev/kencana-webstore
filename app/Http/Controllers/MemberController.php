<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index()
    {
        // 3 latestorder
        $latestOrders = Order::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        return view('frontend.member.profile' , compact('latestOrders'));
    }

    public function updateProfile(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore(Auth::guard('customer')->user()->id),
            ],
            'phone' => 'required|string|max:20',
        ]);

        // 2. Update Data
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $customer->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->password) {
            $customer->update([
                'password_hash' => Hash::make($request->password),
            ]);
        }

        // jika update data eror
        if ($customer->wasChanged() === false) {
            return redirect()->route('member.index')->with('error', 'Profil gagal diperbarui!');
        }

        return redirect()->route('member.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function showTransaction($id){
        $transaction = Order::find($id);
        return view('frontend.member.detail-transaksi', compact('transaction'));
    }
}
