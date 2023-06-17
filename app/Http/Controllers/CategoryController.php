<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getCatByType(Request $request) {
        //abort_unless(\Gate::allows('category_access'), 401);

        if (!$request->type) {
            $html = '<option value="">'.trans('global.pleaseSelect').'</option>';
        } else {
            $html = '';
            $category = Category::where('type', $request->type)->get();
            foreach ($category as $cat) {
                $html .= '<option value="'.$cat->id.'">'.$cat->name.'</option>';
            }
        }
        return response()->json(['html' => $html]);
    }

    public function index() 
    {
        return view('category.index'); 
    }

    public function dataTables(Request $request) 
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('category.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('category.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'type' => $request->input('type'),
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
        ];

        Validator::make($request->all(), [
            'type' => 'required',
            'name' => 'required',
            'desc' => 'required',
        ])->validate();

        try {
            Category::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('category.create');
        }
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'type' => $request->input('type'),
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
        ];

        Validator::make($request->all(), [
            'type' => 'required',
            'name' => 'required',
            'desc' => 'required',
        ])->validate();

        try {
            Category::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('category.edit');
        }
        return redirect()->route('category.index');
    }

    public function delete($id)
    {
        try {
            Category::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('category.index');
        }
        return redirect()->route('category.index');
    }
}
