@extends('admin.master')

@section('content')

<div class="toolbar w-100 d-flex justify-content-end">

    @include('admin.components.toolbar.notification')
    @include('admin.components.toolbar.account')

</div><!-- .toolbar -->

<div class="entity-container">

    <div class="header-container">

        <div class="meta-infos">

            <h2 class="title">Upload de planilha</h2>

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
                <form class="form-default" action="{{route('leads.spreadsheet.store')}}" method="post" enctype="multipart/form-data">

                    @csrf
                    <div class="row">

                        <div class="col-12 mb-5">
                            <label for="spreadsheet-field" class="input-file-spreadsheet">
                                <input type="file" id="spreadsheet-field" name="spreadsheet" class="d-none">
                                <strong>Escolher arquivo</strong>
                                <div class="icon">
                                    <i class="mdi mdi-file-excel"></i>
                                </div>
                            </label>
                        </div>

                        <div class="col-12 col-md-6 mb-5">

                            <div class="form-floating">
                                <select id="nicheId" class="form-control @error('nicheId') is-invalid @enderror" name="nicheId" required>
                                    <option value="" selected>Selecione</option>

                                    @foreach($niches as $niche)
                                    <option value="{{$niche->id}}" {{ old('nicheId') == $niche->id ? 'selected' : '' }}>{{$niche->name}}</option>
                                    @endforeach
                                </select>
                                <label for="nicheId">Nicho</label>
                            </div>

                        </div>

                        <div class="col-12 col-md-6 mb-5">

                            <div class="form-floating">
                                <select id="cityId" class="form-control @error('cityId') is-invalid @enderror" name="cityId" required>
                                    <option value="" selected>Selecione</option>

                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{ old('cityId') == $city->id ? 'selected' : '' }}>{{$city->nome}}</option>
                                    @endforeach
                                </select>
                                <label for="cityId">Cidade</label>
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="d-flex align-items-center justify-content-end">

                                <a href="{{ route('dashboard') }}" class="c-button btn-default">Voltar</a>
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