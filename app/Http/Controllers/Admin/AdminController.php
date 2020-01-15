<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sale;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    private $aprovados = [Sale::APROVADO, Sale::DESPACHADO, Sale::ENTREGUE];

    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $user = User::where('email', $data['email'])->first();
            if ($user == null or !Hash::check($data['password'], $user->password)) {
                flash('Usuário não encontrado')->error();
            } else {
                auth()->login($user, isset($data['remember']));
                return redirect()->route('admin.dashboard');
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function index()
    {
        $month_start = Carbon::now()->firstOfMonth();
        $month_end = Carbon::now()->lastOfMonth();
        $month_orders = 0;

        $graph = [];

        $sales = Sale::whereDate('created_at', '>=', $month_start)->whereDate('created_at', '<=', $month_end)->select('total', 'status', 'created_at')->get();
        for ($x = 1; $x <= $month_end->day; $x++) $graph[$x]=0;
        foreach ($sales as $sale) {
            if (in_array($sale->status, $this->aprovados)) {
                $graph[$sale->created_at->day] += $sale->total;
                $month_orders++;
            }
        }
        $graph = array_map(function ($el) { return round($el, 2); }, $graph);

        $orders = Sale::whereDate('created_at', Carbon::today())->count();

        $total = Sale::whereDate('created_at', '>=', $month_start)->whereDate('created_at', '<=', $month_end)->
        whereIn('status', $this->aprovados)->sum('total');

        $dispatch = Sale::where('status', Sale::APROVADO)->count();

        return view('admin.dashboard', compact('orders', 'month_orders', 'total', 'dispatch', 'graph'));
    }
}
