@extends('layouts.app')

@section('content')
    <pagina tamanho="12">
        @if($errors-> all())
            <div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                @foreach($errors-> all() as $key => $value)
                <li><strong>{{ $value }}</strong></li>
                @endforeach
            </div>
        @endif
        <painel titulo="Lista de Usuários">
            <migalhas v-bind:lista="{{$listaMigalhas}}"></migalhas>
            {{-- #meuModalTeste está mais abaixo em <modal> --}}

            <tabela-lista
                v-bind:titulos="['#', 'Nome', 'Email']"
                {{-- precisa ser em json abaixo; vem vindo de controller index--}}
                v-bind:itens="{{json_encode($listaModelo)}}"
                ordem="desc" ordemcol="1"
                criar="#criar" detalhe="/admin/usuarios/"  editar="/admin/usuarios/" deletar="/admin/usuarios/" token="{{csrf_token()}}"
                modal="sim"
            ></tabela-lista>
            <div align="center">
                {{$listaModelo->links()}}
            </div>
        </painel>
    </pagina>
    <modal nome="adicionar" titulo="Adicionar">
        {{-- para apresentar melhor a form q ficaria bugada: usa <painel> --}}
        <formulario id="formAdicionar" css="" action="{{route('usuarios.store')}}" method="post" enctype="" token="{{csrf_token()}}">
                <div class="form-group">
                    <label for="addName">Nome</label>
                    <input type="text" class="form-control" id="addName" name="name" placeholder="Nome" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="addEmail">Email</label>
                    <input type="email" class="form-control" id="addEmail" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="addAutor">Autor</label>
                    <select class="form-control" id="addAutor" name="autor">
                      <option {{(old('autor') && old('autor') == 'N' ? 'selected' : '' )}} value="N">Não</option>
                      <option {{(old('autor') && old('autor') == 'S' ? 'selected' : ''  )}} value="S">Sim</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="admin">Admin</label>
                    <select class="form-control" id="admin" name="admin">
                        <option {{(old('admin') && old('admin') == 'N' ? 'selected' : '')}} value="N">Não</option>
                        <option {{(old('admin') && old('admin') == 'S' ? 'selected' : '')}} value="S">Sim</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="addPassword">Senha</label>
                    <input type="password" class="form-control" id="addPassword" name="password" value="{{ old('password') }}">
                </div>
            </formulario>
            {{-- vai em <slot name="botoes"></slot> de Modal.vue--}}
            <span slot="botoes">
                {{-- html5 reconhece o button abaixo como submit e form relacionado ao id da form--}}
            <button form="formAdicionar" class="btn btn-info">Adicionar</button>
            </span>

    </modal>
    <modal nome="editar" titulo="Editar">
        {{-- não pode usar mesmo metodo de adicionar com {{}} pq teria php com js! então vai com link manueal; v-bind: ou simplesmente : torna dinâmico e apto p js, faz string com '' e concatena com + td js--}}
        <formulario id="formEditar" v-bind:action="'/admin/usuarios/' + $store.state.item.id" method="put" enctype="" token="{{csrf_token()}}">
                <div class="form-group">
                    <label for="editName">Nome</label>
                    <input type="text" class="form-control" id="editName" name="name" v-model="$store.state.item.name" placeholder="NOme">
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" class="form-control" id="editEemail" name="email" v-model="$store.state.item.email" placeholder="email">
                </div>
                <div class="form-group">
                    <label for="editAutor">Autor</label>
                    {{-- o select será controlado pelo v-model --}}
                    <select class="form-control" id="editAutor" name="autor" v-model="$store.state.item.autor">
                        <option value="N">Não</option>
                        <option value="S">Sim</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="admin">Admin</label>
                    {{-- o select será controlado pelo v-model --}}
                    <select class="form-control" id="admin" name="admin" v-model="$store.state.item.admin">
                        <option value="N">Não</option>
                        <option value="S">Sim</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editPassword">Senha</label>
                    <input type="password" class="form-control" id="editPassword" name="password">
                </div>
                {{-- html5 reconhece o button abaixo como submit --}}
        </formulario>
        <span slot="botoes">
            <button form="formEditar" class="btn btn-info">Atualizar</button>
        </span>
    </modal>
    <modal nome="detalhe" v-bind:titulo="$store.state.item.name">
       {{-- colocou @ p avisar q é javascript; não confundir com vue --}}
            <p>@{{$store.state.item.email}}</p>
    </modal>
@endsection
