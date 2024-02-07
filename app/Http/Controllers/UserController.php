<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Aindex()
    {
        if(request()->ajax()){
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" class="edit btn btn-primary" data-id="' . $row->id . '">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </button>
                    <form action="' . route('admin.user.destroy', $row->id) . '" method="POST" id="delete-form" style="display:none;">
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
        return view('pages.user.index');
    }

    public function Astore(Request $request) {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|unique:users|min:4|max:255',
            'email' => 'required|min:4|max:1000',
            'password' => 'required|min:4|max:1000',
            'type' => 'required|number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->description = $request->description;
        $user->save();

        Alert::success('Berhasil!', 'Tambah user berhasil');
        return redirect()->route('admin.user.index');
    }

        public function Aedit($id)
    {
        $user = User::find($id);
        return response()->json($user);
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

        $user = User::find($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->description = $request->description;

        if ($user) {
            $user->update();
            Alert::success('Berhasil!', 'Ubah user berhasil');
        } else {
            Alert::error('Gagal!', 'User tidak ditemukan');
        }
        return redirect()->route('admin.product_category.index');
    }

    public function Adestroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            Alert::success('Berhasil!', 'Hapus user berhasil');
        } else {
            Alert::error('Gagal!', 'User tidak ditemukan');
        }
        return redirect()->route('admin.user.index');
    }
}
