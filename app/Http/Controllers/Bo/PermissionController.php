<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission; 
use Yajra\DataTables\Facades\DataTables; 

class PermissionController extends Controller
{
    public function index()
    {
        return view('bo.permission.index');
    }

    public function data()
    {
        $query = Permission::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button onclick="editForm(`' . route('permission.show', $row->id) . '`, `' . route('permission.update', $row->id) . '`, `EDIT PERMISSION`)" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-outline ki-pencil fs-2"></i></button>';
                $btn .= '<button onclick="deleteData(`' . route('permission.destroy', $row->id) . '`)" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"><i class="ki-outline ki-trash fs-2"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique'   => 'Nama permission sudah ada di database.',
        ]);

        // Simpan via Spatie Model
        Permission::create([
            'name'       => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Permission berhasil ditambahkan!',
        ]);
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $permission,
        ]);
    }

    public function update(Request $request,$id)
    {
        $permission = Permission::findOrFail($id);

        // Validasi unik (abaikan id yang sedang di-edit)
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique'   => 'Nama permission sudah dipakai.',
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Permission berhasil diperbarui!',
        ]);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);$permission->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Permission berhasil dihapus!',
        ]);
    }

}