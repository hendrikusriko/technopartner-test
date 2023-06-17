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
            $data = Transaction::with(['category'])->latest()
            ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('transaction.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('transaction.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->filter(function ($instance) use ($request) {
                    if ( !empty($request->get('start_date')) && !empty($request->get('end_date')) ) {
                            $instance->where(function($w) use($request){
                                $startDate = date('Y-m-d', strtotime($request->get('start_date')));
                                $endDate = date('Y-m-d', strtotime($request->get('end_date')));
                                $w->whereRaw("date(transaction.created_at) >= '" . $startDate . "' AND date(transaction.created_at) <= '" . $endDate . "'");
                            });
                   }
                    if (!empty($request->get('search'))) {
                         $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('id', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $cat = Category::all()->pluck('name', 'id');
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
        $cat = Category::all()->pluck('name', 'id');
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
