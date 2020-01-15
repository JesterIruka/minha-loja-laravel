<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
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
        if (User::where('email', $request->post('email'))->exists()) {
            flash('Já existe um usuário com este e-mail')->error();
        } else {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            User::create($data);
            flash('Usuário criado com sucesso!')->success();
        }
        return redirect()->route('admin.users.index');
    }

    public function show($id) {}

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        if (empty($data['password'])) unset($data['password']);
        else $data['password'] = bcrypt($data['password']);

        $user = User::find($id);

        if ((strtolower($data['email']) != strtolower($user->email)) and User::where('email', $data['email'])->exists()) {
            flash('Já existe um usuário com este e-mail')->error();
            return redirect()->route('admin.users.edit', ['user'=>$id]);
        }

        $user->update($data);
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
