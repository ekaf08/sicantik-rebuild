<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        $datas = [
            'role' => $role,
        ];
        return view('bo.user.index', $datas);
    }

    public function data(Request $request)
    {
        $query = User::forDatatable();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('password', function ($row) {
                return '••••••••';
            })
            ->editColumn('role', function ($row) {
                return $row->role ?? '-';
            })
            ->editColumn('nama_kec', function ($row) {
                return $row->nama_kec ?? '-';
            })
            ->editColumn('nama_kel', function ($row) {
                return $row->nama_kel ?? '-';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Actions
                        <i class="ki-outline ki-down fs-5 ms-1"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 btn-view" data-id="' . $row->id . '">View</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 btn-edit" data-id="' . $row->id . '">Edit</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 text-danger btn-delete" data-id="' . $row->id . '">Delete</a>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->rawColumns(['action'])
            ->make(true);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
