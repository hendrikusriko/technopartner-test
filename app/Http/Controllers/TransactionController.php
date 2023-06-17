<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;
use DataTables;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index() 
    {
        $in = Transaction::where('type', 'pemasukan')->whereMonth('created_at', date('m'))->sum('nominal');
        $out = Transaction::where('type', 'pengeluaran')->whereMonth('created_at', date('m'))->sum('nominal');
        $saldo = $in - $out;
        return view('transaction.index', ['saldo' => $saldo]); 
    }

    public function dataTables(Request $request) 
    {
        if ($request->ajax()) {
            $data = Transaction::with(['category'])->latest()->whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('transaction.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('transaction.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        //abort_unless(\Gate::allows('transaction_create'), 401);
        $cat = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('transaction.create', ['category' => $cat]);
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'type' => $request->input('type'),
            'category_id' => $request->input('category_id'),
            'nominal' => $request->input('nominal'),
            'desc' => $request->input('desc'),
        ];

        Validator::make($request->all(), [
            'type' => 'required',
            'category_id' => 'required',
            'nominal' => 'required',
            'desc' => 'required',
        ])->validate();

        try {
            Transaction::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('transaction.create');
        }
        return redirect()->route('transaction.index');
    }

    public function edit($id)
    {
        $cat = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $transaction = Transaction::find($id);
        return view('transaction.edit', ['category' => $cat, 'transaction' => $transaction]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'type' => $request->input('type'),
            'category_id' => $request->input('category_id'),
            'nominal' => $request->input('nominal'),
            'desc' => $request->input('desc'),
        ];

        Validator::make($request->all(), [
            'type' => 'required',
            'category_id' => 'required',
            'nominal' => 'required',
            'desc' => 'required',
        ])->validate();

        try {
            Transaction::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('transaction.edit');
        }
        return redirect()->route('transaction.index');
    }

    public function delete($id)
    {
        try {
            Transaction::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('transaction.index');
        }
        return redirect()->route('transaction.index');
    }
}
