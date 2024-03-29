<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function Aindex()
    {
        if(request()->ajax()){
            $data = Supplier::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" class="edit btn btn-primary" data-id="' . $row->id . '">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </button>
                    <form action="' . route('admin.supplier.destroy', $row->id) . '" method="POST" id="delete-form" style="display:none;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        </form>
                        <button type="button" class="delete-btn btn btn-danger">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.supplier.index');
    }

    public function Astore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:suppliers|min:4|max:255',
            'phone' => 'required|min:4|max:20',
            'address' => 'required|min:4|max:1000',
            'description' => 'required|min:4|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->description = $request->description;
        $supplier->save();

        Alert::success('Berhasil!', 'Tambah supplier berhasil');
        return redirect()->route('admin.supplier.index');
    }

        public function Aedit($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    public function Aupdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:255',
            'phone' => 'required|min:4|max:20',
            'address' => 'required|min:4|max:1000',
            'description' => 'required|min:4|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->description = $request->description;

        if ($supplier) {
            $supplier->update();
            Alert::success('Berhasil!', 'Ubah supplier berhasil');
        } else {
            Alert::error('Gagal!', 'Supplier tidak ditemukan');
        }
        return redirect()->route('admin.product_category.index');
    }

    public function Adestroy($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->delete();
            Alert::success('Berhasil!', 'Hapus supplier berhasil');
        } else {
            Alert::error('Gagal!', 'Supplier tidak ditemukan');
        }
        return redirect()->route('admin.supplier.index');
    }
}
