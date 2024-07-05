@extends('admin.master')

@section('content')

    <div class="toolbar w-100 d-flex justify-content-end">

        @include('admin.components.toolbar.notification')
        @include('admin.components.toolbar.account')

    </div><!-- .toolbar -->

    <div class="entity-container">

        <div class="header-container">

            <div class="meta-infos">

                <h2 class="title">Cadastrar Lead</h2>

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
                    <form class="form-default" action="{{route('leads.store')}}" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            
                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                                    <label for="name">Nome</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="phone" id="phone" class="form-control phoneMask @error('phone') is-invalid @enderror" value="{{old('phone')}}">
                                    <label for="phone">Telefone</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}">
                                    <label for="address">Endereço</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                                    <label for="email">E-mail</label>
                                </div>
                            </div>

                            <div class="col-12 mb-5">
                                <div class="form-floating">
                                    <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{old('website')}}">
                                    <label for="website">Website</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="date" name="lastContact" id="lastContact" class="form-control @error('lastContact') is-invalid @enderror" value="{{old('lastContact')}}">
                                    <label for="lastContact">Último contato</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="date" name="callScheduled" id="callScheduled" class="form-control @error('callScheduled') is-invalid @enderror" value="{{old('callScheduled')}}">
                                    <label for="callScheduled">Chamada agendada</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                
                                <div class="form-floating">
                                    <select id="statusId" class="form-control @error('statusId') is-invalid @enderror" name="statusId">
                                        <option value="" selected>Selecione</option>
                                        
                                        @foreach($statuses as $status)
                                            <option value="{{$status->id}}" {{ old('statusId') == $status->id ? 'selected' : '' }}>{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="statusId">Status</label>
                                </div>

                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                
                                <div class="form-floating">
                                    <select id="nicheId" class="form-control @error('nicheId') is-invalid @enderror" name="nicheId">
                                        <option value="" selected>Selecione...</option>
                                        @foreach($niches as $niche)
                                            <option value="{{$niche->id}}" {{ old('nicheId') == $niche->id ? 'selected' : '' }}>{{$niche->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="nicheId">Nicho</label>
                                </div>

                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                
                                <div class="form-floating">
                                    <select id="uf" class="form-control states @error('uf') is-invalid @enderror" name="uf">
                                        @foreach($states as $k => $state)
                                            <option value="{{$state->uf}}" {{ old('uf') == $state->uf || $k == 0 ? 'selected' : '' }}>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="uf">Estado</label>
                                </div>

                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                
                                <div class="form-floating">
                                    <select id="cityId" class="form-control cities @error('cityId') is-invalid @enderror" name="cityId">
                                        @foreach($cities as $k => $city)
                                            <option value="{{$city->id}}" {{ old('cityId') == $city->id || $k == 0 ? 'selected' : '' }}>{{$city->nome}}</option>
                                        @endforeach
                                    </select>
                                    <label for="cityId">Cidade</label>
                                </div>

                            </div>

                            <div class="col-12 mb-5">
                                
                                <div class="form-floating">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status">
                                        <option value="1" selected>Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                    <label for="status">Ativo?</label>
                                </div>

                            </div>
                        
                            <div class="col-12">

                                <div class="d-flex align-items-center justify-content-end">

                                    <a href="{{ route('leads.index') }}" class="c-button btn-default">Voltar</a>
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