<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RumahSakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rumahSakits = RumahSakit::latest()->paginate(10);
        return view('rumah-sakits.index', compact('rumahSakits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rumah-sakits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'email' => 'required|email|unique:rumah_sakits,email',
            'telepon' => 'required|string|max:20'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        RumahSakit::create($request->all());

        return redirect()->route('rumah-sakits.index')
            ->with('success', 'Rumah Sakit berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RumahSakit $rumahSakit)
    {
        return view('rumah-sakits.show', compact('rumahSakit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RumahSakit $rumahSakit)
    {
        return view('rumah-sakits.edit', compact('rumahSakit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RumahSakit $rumahSakit)
    {
        $validator = Validator::make($request->all(), [
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'email' => 'required|email|unique:rumah_sakits,email,' . $rumahSakit->id,
            'telepon' => 'required|string|max:20'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $rumahSakit->update($request->all());

        return redirect()->route('rumah-sakits.index')
            ->with('success', 'Rumah Sakit berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage using AJAX.
     */
    public function destroy(RumahSakit $rumahSakit)
    {
        try {
            $rumahSakit->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rumah Sakit berhasil dihapus.'
                ]);
            }

            return redirect()->route('rumah-sakits.index')
                ->with('success', 'Rumah Sakit berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data. Data masih digunakan oleh tabel lain.'
                ]);
            }

            return redirect()->route('rumah-sakits.index')
                ->with('error', 'Gagal menghapus data. Data masih digunakan oleh tabel lain.');
        }
    }

    /**
     * Get rumah sakit data for AJAX requests
     */
    public function getRumahSakits()
    {
        $rumahSakits = RumahSakit::select('id', 'nama_rumah_sakit')->get();
        return response()->json($rumahSakits);
    }
}
