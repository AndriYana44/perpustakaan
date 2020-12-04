<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home | Beranda'
        ];
        return view('buku.index', compact('data'));
    }

    public function buku()
    {
        $batas = 5;
        $data_buku = Buku::orderBy('id', 'desc')->simplePaginate($batas);
        $jumlah_buku = Buku::count();
        if($data_buku->currentPage() == 1) {
            $no = 1;
        }else {
            $no = ($data_buku->currentPage() * $batas) - $batas + 1;
        };

        $data = [
            'title' => 'Data Buku'
        ];
        return view('buku.buku', compact('data', 'data_buku', 'jumlah_buku', 'no'));
    }

    public function store(Request $request) 
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'harga' => 'required',
            'tgl' => 'required|date'
        ]);

        $buku = new Buku;
        
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl;
        $buku->save();
        return redirect('/buku')->with('status', 'Buku berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $buku = new Buku;
        $buku->find($id)->delete();
        return redirect('/buku')->with('delete', 'Data berhasil dihapus!');
    }

    public function update(Request $request, $id) 
    {
        $buku = Buku::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl;
        $buku->update();
        return redirect('/buku')->with('update', 'Buku berhasil diubah!');
    }
    public function search(Request $request) {
        $buku = $request->key;
        $data = [
            'no' => '1',
            'title' => 'search'
        ];
        $data_buku = Buku::where('judul', 'like', '%'.$buku.'%')->get();

        return view('buku.buku', compact('data_buku', 'data'));
    }
}
