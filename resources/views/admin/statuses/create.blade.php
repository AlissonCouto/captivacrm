@extends('admin.master')

@section('content')

    <div class="toolbar w-100 d-flex justify-content-end">

        @include('admin.components.toolbar.notification')
        @include('admin.components.toolbar.account')

    </div><!-- .toolbar -->

    <div class="entity-container">

        <div class="header-container">

            <div class="meta-infos">

                <h2 class="title">Cadastrar Status</h2>

            </div> <!-- .meta-infos -->

        </div> <!-- .header-table -->

        <div class="container-fluid p-0">
            <div class="row">

            @if(session()->has('success'))
                <div class="col-12 m-b-5">
                    <div class="alert alert-{{ session('success')['success'] ? 'success' : 'danger' }}">
                        {{ session('success')['message'] }}
                    </div>
                </div>
            @endif

                <div class="col-12">
                    <form class="form-default" action="{{route('statuses.store')}}" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            
                            <div class="col-12 col-md-1 mb-5">
                                <div class="form-floating">
                                    <input type="color" name="color" id="color" class="form-control @error('color') is-invalid @enderror">
                                    <label for="color">Cor</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-11 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                                    <label for="name">Nome</label>
                                </div>
                            </div>

                            <div class="col-12 mb-5">
                                
                                <div class="form-floating">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status">
                                        <option value="1" selected>Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                    <label for="status">Status</label>
                                </div>

                            </div>
                        
                            <div class="col-12">

                                <div class="d-flex align-items-center justify-content-end">

                                    <a href="{{ route('statuses.index') }}" class="c-button btn-default">Voltar</a>
                                    <button type="submit" class="c-button btn-save">Salvar</button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>

@endsection