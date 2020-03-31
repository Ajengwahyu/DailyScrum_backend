<?php

namespace App\Http\Controllers;
use App\Daily;
use Auth;
use Illuminate\Http\Request;

class DailyController extends Controller
{
    public function index(){
        $data = Daily::all();
        return response ($data);
    }
    public function show($id){
        $data = Daily::where('id', $id)->get();
        return response ($data);
    }
    public function store (Request $request) {
        try{
            $data = new Daily();
            $data->judul = $request->input('judul');
            $data->deskripsi = $request->input('deskripsi');
            $data->harga = $request->input('harga');
            $data->gambar = $request->input('gambar');
            $data->save();
            return response()->json([
                'status'    => '1',
                'message'   => 'berhasil'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'    => '0',
                'message'   => $e->getMessage()
            ]);
        }
    }
    public function update(Request $request, $id){
        try {
            $data = Barang::where('id',$id)->first;
            $data->judul = $request->input('judul');
            $data->deskripsi = $request->input('deskripsi');
            $data->harga = $request->input('harga');
            $data->gambar = $request->input('gambar');
            $data->save();
            return response()->json([
                'status'    => '1',
                'message'   => 'berhasil'
            ]);
        } catch(\Exceptions $e) {
            return response()->json([
                'status'    => '0',
                'message'   => $e->getMessage()
            ]);
        }
    }
    public function destroy($id){
        try {
            $data = Barang::where('id',$id)->first;
            $data->delete();
            return response()->json([
                'status'    => '1',
                'message'   => 'berhasil'
            ]);
        } catch(\Exceptions $e) {
            return response()->json([
                'status'    => '0',
                'message'   => $e->getMessage()
            ]);
        }
    }
}
