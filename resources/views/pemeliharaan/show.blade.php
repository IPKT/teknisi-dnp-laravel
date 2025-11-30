@extends('layouts.app')

@section('title', 'Detail Peralatan')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            {{-- DETAIL PERALATAN --}}
            <h4 class="mb-4">Detail Pemeliharaan <a href="{{ route('peralatan.show', $pemeliharaan->peralatan->id) }}" class="">
                                        {{ $pemeliharaan->peralatan->kode }}
                                    </a> tanggal
                {{ \Carbon\Carbon::parse($pemeliharaan->tanggal)->translatedFormat('d F Y') }}
                @if (in_array(auth()->user()->role, ['admin', 'teknisi']) || $pemeliharaan->author == auth()->user()->id)
                    <a href="{{ route('pemeliharaan.edit', $pemeliharaan->id) }}"
                        class="btn btn-sm btn-warning mb-2 mb-md-0"><i class="bi bi-pencil-square"></i></a>
                @endif
            </h4>
            <div class="row g-2">
                <div class="col-md-4">
                    {{-- 🗺️ Peta Lokasi --}}
                    {{-- <div id="map" style="height: 350px;"></div> --}}
                    @if ($pemeliharaan->gambar)
                        <img src="{{ asset('storage/uploads/gambar_pemeliharaan/' . $pemeliharaan->gambar) }}" alt=""
                            class="img-fluid">
                    @else
                        <img src="{{ asset('assets/images/dummy_pm.png') }}" alt="" class="img-fluid">
                    @endif

                </div>
                <div class="col-md-8">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($pemeliharaan->tanggal)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Kondisi Awal</td>
                                <td>:</td>
                                <td>{{ $pemeliharaan->kondisi_awal }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Pemeliharaan</td>
                                <td>:</td>
                                <td>{{ $pemeliharaan->jenis_pemeliharaan }}</td>
                            </tr>
                            <tr>
                                <td>Pelaksana</td>
                                <td>:</td>
                                <td><?php
                                $pelaksana = str_replace("\r\n", '<br>', $pemeliharaan->pelaksana);
                                echo $pelaksana;
                                ?></td>
                            </tr>
                            <tr>
                                <td>Rekomendasi</td>
                                <td>:</td>
                                <td><?php
                                $rekomendasi = str_replace("\r\n", '<br>', $pemeliharaan->rekomendasi);
                                echo $rekomendasi;
                                ?></td>
                            </tr>
                            <tr>
                                <td>Kerusakan</td>
                                <td>:</td>
                                <td>{{ $pemeliharaan->kerusakan }}</td>
                            </tr>
                            {{-- <tr>
                            <td>Laporan WA</td>
                            <td>:</td>
                            <td>{{ $pemeliharaan->text_wa }}</td>
                        </tr> --}}
                            <tr>
                                <td>Catatan</td>
                                <td>:</td>
                                <td><?php
                                $catatan = str_replace("\r\n", '<br>', $pemeliharaan->catatan_pemeliharaan);
                                echo $catatan;
                                ?></td>
                            </tr>
                            <tr>
                                <td>Author</td>
                                <td>:</td>
                                <td>{{ $author }}</td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{-- <label class="ms-3 mb-2">Text WA</label> --}}
                        <textarea class="form-control textAreaMultiline" name="text_wa" rows="8" placeholder="" disabled><?= $pemeliharaan->text_wa ?></textarea>
                    </div>
                    {{-- <img src="{{ asset('storage/'.$pemeliharaan->gambar) }}" alt="" class="img-fluid"> --}}
                </div>
                <hr>
            </div>
            @if ($pemeliharaan->laporan)
                <div class="row my-2">
                    <div class="col-md-12">
                        <h4>LAPORAN 1</h4>
                        <iframe src="{{ asset('storage/uploads/laporan_pemeliharaan/' . $pemeliharaan->laporan) }}"
                            height="500px" width="100%" title="Iframe Example"></iframe>
                    </div>
                </div>
            @endif
            @if ($pemeliharaan->laporan2)
                <div class="row my-2">
                    <div class="col-md-12">
                        <h4>LAPORAN 2</h4>
                        <iframe src="{{ asset('storage/uploads/laporan_pemeliharaan/' . $pemeliharaan->laporan2) }}"
                            height="500px" width="100%" title="Iframe Example"></iframe>
                    </div>
                </div>
            @endif


        </div>
    </div>




@endsection
