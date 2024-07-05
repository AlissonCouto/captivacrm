@extends('admin.master')

@section('content')

    <div class="toolbar w-100 d-flex justify-content-end">

        @include('admin.components.toolbar.notification')
        @include('admin.components.toolbar.account')

    </div><!-- .toolbar -->

    <div class="entity-container">

        <div class="header-container">

            <div class="meta-infos">

                <h2 class="title">Detalhes do Lead</h2>

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
                        <div class="row form-default">
                            
                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name') ? old('name') : $entity->name}}" disabled>
                                    <label for="name">Nome</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone') ? old('phone') : $entity->phone}}" disabled>
                                    <label for="phone">Telefone</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address') ? old('address') : $entity->address}}" disabled>
                                    <label for="address">Endereço</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email') ? old('email') : $entity->email}}" disabled>
                                    <label for="email">E-mail</label>
                                </div>
                            </div>

                            <div class="col-12 mb-5">
                                <div class="form-floating">
                                    <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{old('website') ? old('website') : $entity->website}}" disabled>
                                    <label for="website">Website</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="date" name="lastContact" id="lastContact" class="form-control @error('lastContact') is-invalid @enderror" value="{{date('Y-m-d', strtotime($entity->lastContact))}}" disabled>
                                    <label for="lastContact">Último contato</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="date" name="callScheduled" id="callScheduled" class="form-control @error('callScheduled') is-invalid @enderror" value="{{date('Y-m-d', strtotime($entity->callScheduled))}}" disabled>
                                    <label for="callScheduled">Chamada agendada</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="statusId" id="statusId" class="form-control @error('statusId') is-invalid @enderror" value="{{$entity->status()->first()->name ?? '--'}}" disabled>
                                    <label for="statusId">Status</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="nicheId" id="nicheId" class="form-control @error('nicheId') is-invalid @enderror" value="{{$entity->niche()->first()->name ?? '--'}}" disabled>
                                    <label for="nicheId">Nicho</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror" value="{{$entity->city()->first()->uf ?? '--'}}" disabled>
                                    <label for="state">Estado</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="cityId" id="cityId" class="form-control @error('cityId') is-invalid @enderror" value="{{$entity->city()->first()->nome ?? '--'}}" disabled>
                                    <label for="cityId">Cidade</label>
                                </div>
                            </div>

                            <div class="col-12 mb-5">
                                <div class="form-floating">
                                    <input type="text" name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{$entity->status == 1 ? 'Sim' : 'Não'}}" disabled>
                                    <label for="status">Ativo?</label>
                                </div>
                            </div>
                        
                            <div class="col-12">

                                <div class="d-flex align-items-center justify-content-end">

                                    <a href="{{ route('leads.index') }}" class="c-button btn-default">Voltar</a>

                                </div>

                            </div>

                        </div>

                </div>

            </div>
        </div>

    </div>

@endsection