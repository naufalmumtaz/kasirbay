<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function Aindex()
    {
        if(request()->ajax()){
            $data = ProductCategory::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" class="edit btn btn-primary" data-id="' . $row->id . '">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </button>
                    <form action="' . route('admin.product_category.destroy', $row->id) . '" method="POST" id="delete-form" style="display:none;">
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
        return view('pages.product_category.index');
    }

    public function Astore(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:product_categories|min:4|max:255',
            'description' => 'required|min:4|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $productCategory = new ProductCategory;
        $productCategory->title = $request->title;
        $productCategory->description = $request->description;
        $productCategory->save();

        Alert::success('Berhasil!', 'Tambah produk kategori berhasil');
        return redirect()->route('admin.product_category.index');
    }

    public function Aedit($id)
    {
        $productCategory = ProductCategory::find($id);
        return response()->json($productCategory);
    }

    public function Aupdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:4|max:255',
            'description' => 'required|min:4|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $productCategory = ProductCategory::find($id);
        $productCategory->title = $request->title;
        $productCategory->description = $request->description;

        if ($productCategory) {
            $productCategory->update();
            Alert::success('Berhasil!', 'Ubah produk kategori berhasil');
        } else {
            Alert::error('Gagal!', 'Produk kategori tidak ditemukan');
        }
        return redirect()->route('admin.product_category.index');
    }

    public function Adestroy($id)
    {
        $productCategory = ProductCategory::find($id);
        if ($productCategory) {
            $productCategory->delete();
            Alert::success('Berhasil!', 'Hapus produk kategori berhasil');
        } else {
            Alert::error('Gagal!', 'Produk kategori tidak ditemukan');
        }
        return redirect()->route('admin.product_category.index');
    }
}
