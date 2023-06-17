<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function dashboard() {
        $in = Transaction::where('type', 'pemasukan')->sum('nominal');
        $out = Transaction::where('type', 'pengeluaran')->sum('nominal');
        $saldo = $in - $out;
        return view('dashboard', ['in' => $in, 'out' => $out, 'saldo' => $saldo]); 
    }
}
