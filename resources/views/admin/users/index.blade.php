@extends('layouts.panel')

@section('content')
    @if (auth()->user()->role >= 2)
    <div class="text-right mb-2">
        <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#criar">Criar Usuário</button>
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-Mail</th>
                    <th>Função</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count())
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{config('store.messages')['roles'][$user->role]}}</td>
                            <td class="text-nowrap">
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="{{route('admin.users.edit', ['user'=>$user->id])}}">EDITAR</a>
                                    @if ($user != auth()->user() and auth()->user()->role >= 2)
                                    <form action="{{route('admin.users.destroy', ['user'=>$user->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">EXCLUIR</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="3">Nenhum usuário encontrado!</td>
                @endif
            </tbody>
        </table>
    </div>
    <div>
        {{$users->links()}}
    </div>

    <div class="modal fade" id="criar">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.users.store')}}" method="post">
                    @csrf
                    <div class="modal-header text-center">
                        <h1>Criar Usuário</h1>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>E-Mail</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" minlength="8" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Permissão</label>
                            <select name="role" class="form-control" required>
                                <option value="1">{{config('store.messages')['roles'][1]}}</option>
                                <option value="2">{{config('store.messages')['roles'][2]}}</option>
                                <option value="3">{{config('store.messages')['roles'][3]}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary mr-auto" data-dismiss="modal">FECHAR</button>
                        <button type="submit" class="btn btn-primary">CRIAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
