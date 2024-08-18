<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }
    // This method will show permission page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);
        return view('permissions.index', compact('permissions'));
    }
    // This method will show create permission page
    public function create()
    {
        return view('permissions.create');
    }
    // This method will insert a permission in DB
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required|unique:permissions,name|min:3',
        ]);
        if($validate->passes()){
            Permission::create([ 'name'=> $request->name ]);
            return redirect()->route('permissions.index')->with('success','Permission created successfully');
        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validate);
        }
    }
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $validate = Validator::make($request->all(),[
            'name' => 'required|unique:permissions,name|min:3,'.$id.',id',
        ]);
        if($validate->passes()){
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success','Permission updated successfully');
        }else{
            return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validate);
        }
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $permission = Permission::find($id);
        if($permission == null){
            session()->flash('error','Permission not found!');
            return response()->json([
                'status' => false
            ]);
        }
        $permission->delete();
        session()->flash('success','Permission deleted successfully');
        return response()->json([
            'status' => true
        ]);
    }

}
