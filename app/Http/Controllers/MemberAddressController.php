<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Addresses; // Pastikan Anda memiliki model Address

class MemberAddressController extends Controller
{
    /**
     * Menampilkan daftar semua alamat milik customer yang sedang login.
     */
    public function index()
    {
        // Mendapatkan customer yang sedang login
        $customer = Auth::guard('customer')->user()->id;
        
        // Ambil semua alamat customer tersebut, diurutkan agar yang default di atas.
        $addresses = Addresses::where('customer_id', $customer)->orderBy('is_default', 'desc')->get();

        return view('frontend.member.daftar-alamat', compact('addresses'));
        // Pastikan nama view ini sesuai dengan file blade Anda (contoh: member.addresses.blade.php)
    }

    /**
     * Menyimpan alamat baru yang ditambahkan melalui modal peta.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'label'       => 'required|string|max:255',
            'street'      => 'required|string',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'phone'       => 'required|string|max:20',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'is_default'  => 'nullable|boolean',
        ]);

        $customer = Auth::guard('customer')->user();

        // 2. Logika is_default
        $isDefault = $request->has('is_default');
        
        if ($isDefault) {
            // Jika alamat baru dijadikan default, set semua alamat lama menjadi non-default
            Addresses::where('customer_id', $customer->id)
                   ->update(['is_default' => false]);
        }

        // 3. Simpan Alamat Baru
        $address = new Addresses($validated);
        $address->customer_id = $customer->id;
        $address->is_default = $isDefault;
        $address->country = $request->country ?? 'ID'; // Set default jika tidak ada input country
        
        $address->save();

        return redirect()->route('member.addresses.index')->with('success', 'Alamat baru berhasil ditambahkan dan disimpan!');
    }

    public function update(Request $request, Addresses $address)
    {
        // 1. Verifikasi Kepemilikan (PENTING)
        if (Auth::guard('customer')->user()->id !== $address->customer_id) {
            return redirect()->route('member.addresses.index')->withErrors(['error' => 'Akses ditolak.']);
        }

        // 2. Validasi
        $validated = $request->validate([
            'label'       => 'required|string|max:255',
            'street'      => 'required|string',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'phone'       => 'required|string|max:20',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'is_default'  => 'nullable|boolean',
        ]);

        $isDefault = $request->has('is_default');

        // 3. Logika is_default
        if ($isDefault) {
            // Reset default alamat lain
            Addresses::where('customer_id', $address->customer_id)
                   ->where('id', '!=', $address->id)
                   ->update(['is_default' => false]);
        }
        
        // 4. Update Data
        $address->update($validated + ['is_default' => $isDefault]);

        return redirect()->route('member.addresses.index')->with('success', 'Alamat berhasil diperbarui!');
    }

    public function setAsDefault(Addresses $address)
    {
        // 1. Verifikasi Kepemilikan (PENTING)
        if (Auth::guard('customer')->user()->id !== $address->customer_id) {
            return redirect()->route('member.addresses.index')->withErrors(['error' => 'Akses ditolak.']);
        }
        
        // 2. Jika alamat sudah default, tidak perlu update
        if ($address->is_default) {
            return redirect()->route('member.addresses.index')->with('success', 'Alamat sudah menjadi alamat utama.');
        }

        // 3. Reset default alamat lain
        Addresses::where('customer_id', $address->customer_id)
               ->update(['is_default' => false]);

        // 4. Set alamat ini sebagai default
        $address->is_default = true;
        $address->save();

        return redirect()->route('member.addresses.index')->with('success', 'Alamat berhasil dijadikan alamat utama!');
    }

    public function destroy(Addresses $address)
    {
        // 1. Verifikasi Kepemilikan (PENTING)
        if (Auth::guard('customer')->user()->id !== $address->customer_id) {
            return redirect()->route('member.addresses.index')->withErrors(['error' => 'Akses ditolak.']);
        }

        // 2. Jangan izinkan menghapus alamat jika itu adalah satu-satunya atau default
        if ($address->is_default) {
             return redirect()->route('member.addresses.index')->withErrors(['error' => 'Alamat utama tidak dapat dihapus. Silakan jadikan alamat lain sebagai utama terlebih dahulu.']);
        }
        
        // 3. Hapus (soft delete)
        $address->delete();

        return redirect()->route('member.addresses.index')->with('success', 'Alamat berhasil dihapus!');
    }
}