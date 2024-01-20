<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function Aindex()
    {
        $data = Product::with(['product_image', 'product_category'])->latest()->get();

        if(request()->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $firstImage = $row->product_image->first();
                    if ($firstImage) {
                        return '<img src="'. asset('images/products/' . $firstImage->image) .'" alt="gambar produk" style="width:7rem">';
                    } else {
                        return '<img src="path/to/default/image.jpg" alt="No Image">';
                    }
                })
                ->addColumn('price', function ($row) {
                    return Helpers::rupiah_format($row->price);
                })
                ->addColumn('product_category_id', function ($row) {
                    return $row->product_category->title;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <a href="' . route('admin.product.edit', $row->id) . '" class="edit btn btn-primary">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <form action="' . route('admin.product.destroy', $row->id) . '" method="POST" id="delete-form" style="display:none;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        </form>
                        <button type="button" class="delete-btn btn btn-danger">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    ';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('pages.product.index');
    }

    public function Aadd()
    {
        $productCategories = ProductCategory::all();
        return view('pages.product.add', ['productCategories' => $productCategories]);
    }

    public function Astore(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:products|min:4|max:255',
            'description' => 'required|min:4|max:1000',
            'price' => 'required|integer|min:2',
            'product_category_id' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->slug = Str::slug($request->title);
        $product->product_category_id = $request->product_category_id;
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $path = $image->move(public_path('images/products'), $filename);

                $productImage = new ProductImage;
                $productImage->image = $filename;
                $productImage->product_id = $product->id;
                $productImage->save();
            }
        }

        Alert::success('Berhasil!', 'Tambah produk berhasil');
        return redirect()->route('admin.product.index');
    }

    public function Aedit($id)
    {
        $product = Product::with(['product_image', 'product_category'])->find($id);
        $productCategories = ProductCategory::all();
        return view('pages.product.edit', ['product' => $product, 'productCategories' => $productCategories]);
    }

    public function Aupdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:4|max:255',
            'description' => 'required|min:4|max:1000',
            'price' => 'required|integer|min:2',
            'product_category_id' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->slug = Str::slug($request->title);
        $product->product_category_id = $request->product_category_id;
        $product->update();

        if ($request->hasFile('images')) {
            $productImageOld = ProductImage::where('product_id', $product->id)->get();
            foreach($productImageOld as $imageOld) {
                $imageOld->delete();
                File::delete(public_path('images/products/' . $imageOld->image));
            }
            foreach ($request->file('images') as $image) {
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $path = $image->move(public_path('images/products'), $filename);

                $productImage = new ProductImage;
                $productImage->image = $filename;
                $productImage->product_id = $product->id;
                $productImage->save();
            }
        }

        if ($product) {
            $product->update();
            Alert::success('Berhasil!', 'Ubah produk berhasil');
        } else {
            Alert::error('Gagal!', 'Produk tidak ditemukan');
        }
        return redirect()->route('admin.product.index');
    }

    public function Adestroy($id)
    {
        $product = Product::with(['product_image'])->find($id);
        if ($product) {
            if($product->product_image) {
                foreach ($product->product_image as $image) {
                    File::delete(public_path('images/products/' . $image->image));
                }
            }
            $product->delete();
            Alert::success('Berhasil!', 'Hapus produk berhasil');
        } else {
            Alert::error('Gagal!', 'Produk tidak ditemukan');
        }
        return redirect()->route('admin.product.index');
    }
}
