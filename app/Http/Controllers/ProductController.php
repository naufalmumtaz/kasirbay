<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function Aindex()
    {
        if(\request()->ajax()){
            $data = Product::latest()->get();
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
}
