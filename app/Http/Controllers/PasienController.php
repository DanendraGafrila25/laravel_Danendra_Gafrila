<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RumahSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pasien::with('rumahSakit');

        // Filter by Rumah Sakit if provided
        if ($request->has('rumah_sakit') && $request->rumah_sakit != '') {
            $query->where('id_rumah_sakit', $request->rumah_sakit);
        }

        $pasiens = $query->latest()->paginate(10);
        $rumahSakits = RumahSakit::select('id', 'nama_rumah_sakit')->get();

        return view('pasiens.index', compact('pasiens', 'rumahSakits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rumahSakits = RumahSakit::select('id', 'nama_rumah_sakit')->get();
        return view('pasiens.create', compact('rumahSakits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_telepon' => 'required|string|max:20',
            'id_rumah_sakit' => 'required|exists:rumah_sakits,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pasien::create($request->all());

        return redirect()->route('pasiens.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        $pasien->load('rumahSakit');
        return view('pasiens.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        $rumahSakits = RumahSakit::select('id', 'nama_rumah_sakit')->get();
        return view('pasiens.edit', compact('pasien', 'rumahSakits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_telepon' => 'required|string|max:20',
            'id_rumah_sakit' => 'required|exists:rumah_sakits,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pasien->update($request->all());

        return redirect()->route('pasiens.index')
            ->with('success', 'Data pasien berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage using AJAX.
     */
    public function destroy(Pasien $pasien)
    {
        try {
            $pasien->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data pasien berhasil dihapus.'
                ]);
            }

            return redirect()->route('pasiens.index')
                ->with('success', 'Data pasien berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data pasien.'
                ]);
            }

            return redirect()->route('pasiens.index')
                ->with('error', 'Gagal menghapus data pasien.');
        }
    }

    /**
     * Filter pasien by rumah sakit using AJAX
     */
    public function filterByRumahSakit(Request $request)
    {
        $rumahSakitId = $request->get('rumah_sakit_id');

        $query = Pasien::with('rumahSakit');

        if ($rumahSakitId && $rumahSakitId != '') {
            $query->where('id_rumah_sakit', $rumahSakitId);
        }

        $pasiens = $query->get();

        return response()->json([
            'success' => true,
            'data' => $pasiens
        ]);
    }
}
