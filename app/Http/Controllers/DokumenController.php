<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Peralatan;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd("hahaaha");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'id_peralatan' => 'required|exists:peralatans,id',
            'tanggal_dokumen' => 'nullable|date',
            'nama_dokumen' => 'required|string|max:255',
            'keterangan_dokumen' => 'nullable|string|max:500',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);
        $peralatan = Peralatan::where('id', $request['id_peralatan'])->first();
        $kode = $peralatan->kode;
        $time = time();

        if ($request->hasFile('file_dokumen')) {
            //  $validated['file_dokumen'] = $request->file('file_dokumen')->store('uploads/dokumen', 'public');
            
            $filename = 'dokumen_'.$kode . '_' . $request['tanggal_dokumen'] .'_'.$time. '.' . $request->file('file_dokumen')->getClientOriginalExtension();
            $validated['file_dokumen'] = $request->file('file_dokumen')->storeAs('uploads/dokumen', $filename, 'public');
        }
        $validated['author'] = $request->user()->id;
        $dokumen = Dokumen::create($validated);

        return response()->json([
            'success' => true,
            'dokumen' => $dokumen
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Dokumen $dokumen)
    {
         return response()->json($dokumen);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
      public function update(Request $request, Dokumen $dokumen)
    {
      $validated = $request->validate([
        
        'nama_dokumen' => 'required|string|max:255',
        'tanggal_dokumen' => 'nullable|date',
        'keterangan_dokumen' => 'nullable|string|max:500',
        'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
    ]);

    // $peralatan = Peralatan::where('id', $request['id_peralatan'])->first();
    $kode = $dokumen->peralatan->kode;
    $time = time();

    if ($request->hasFile('file_dokumen')) {
        if ($dokumen->file_dokumen && file_exists(storage_path('app/public/'.$dokumen->file_dokumen))) {
            unlink(storage_path('app/public/'.$dokumen->file_dokumen));
        }
        $filename = 'dokumen_'.$kode . '_' . $request['tanggal_dokumen'] .'_'.$time. '.' . $request->file('file_dokumen')->getClientOriginalExtension();
        $validated['file_dokumen'] = $request->file('file_dokumen')->storeAs('uploads/dokumen', $filename, 'public');
    }
    // $dokumen = Dokumen::findOrFail($id);
    // $dokumen->update($validated);
    $dokumen->update($validated);
    return response()->json([
        'success' => true,
        // 'dokumen' => $dokumen
    ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        if ($dokumen->file_dokumen && file_exists(storage_path('app/public/'.$dokumen->file_dokumen))) {
            unlink(storage_path('app/public/'.$dokumen->file_dokumen));
        }
        $dokumen->delete();
        return response()->json([
            'success' => true
        ]);
    }
}