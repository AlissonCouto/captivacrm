@extends('admin.master')

@section('content')

    <div class="toolbar w-100 d-flex justify-content-end">

        @include('admin.components.toolbar.notification')
        @include('admin.components.toolbar.account')

    </div><!-- .toolbar -->

    <div class="entity-container">

        <div class="header-container">

            <div class="meta-infos">

                <h2 class="title">Detalhes do Nicho</h2>

            </div> <!-- .meta-infos -->

        </div> <!-- .header-table -->

        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-12">
                    <div class="form-default">

                        <div class="row">
                            
                            <div class="col-12 col-md-1 mb-5">
                                <div class="form-floating">
                                    <input type="color" class="form-control" value="{{$entity->color}}" disabled>
                                    <label for="color">Cor</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-11 mb-5">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="{{$entity->name}}" disabled>
                                    <label for="name">Nome</label>
                                </div>
                            </div>

                            <div class="col-12 mb-5">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="{{$entity->status == 1 ? 'Sim' : 'Não'}}" disabled>
                                    <label for="name">Status</label>
                                </div>
                            </div>
                        
                            <div class="col-12">

                                <div class="d-flex align-items-center justify-content-end">

                                    <a href="{{ route('niches.index') }}" class="c-button btn-default">Voltar</a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection