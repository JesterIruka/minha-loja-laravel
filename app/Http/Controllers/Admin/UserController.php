<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth_admin');
    }

    public function index()
    {
        return view('admin.users.index', ['users' => User::paginate(10)]);
    }

    public function create() {}

    public function store(Request $request)
    {
        User::create($request->all());
        flash('Usuário criado com sucesso!')->success();
        return redirect()->route('admin.users.index');
    }

    public function show($id) {}

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        flash('Usuário atualizado com sucesso!')->success();
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        if ($id != auth()->user()->id) {
            User::destroy($id);
            flash('Usuário removido com sucesso!')->success();
        } else flash('Você não pode excluir seu próprio usuário.')->error();
        return redirect()->route('admin.users.index');
    }
}
