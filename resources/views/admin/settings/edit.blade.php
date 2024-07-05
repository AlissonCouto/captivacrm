@extends('admin.master')

@section('content')

    <div class="toolbar w-100 d-flex justify-content-end">

        @include('admin.components.toolbar.notification')
        @include('admin.components.toolbar.account')

    </div><!-- .toolbar -->

    <div class="entity-container">

        <div class="header-container">

            <div class="meta-infos">

                <h2 class="title">Configurações</h2>

            </div> <!-- .meta-infos -->

        </div> <!-- .header-table -->

        <div class="container-fluid p-0">
            <div class="row">

            @if(session()->has('success'))
                <div class="col-12 m-b-5">
                    <div class="popup popup-{{ session('success')['success'] ? 'success' : 'danger' }}">
                        {{ session('success')['message'] }}
                    </div>
                </div>
            @endif

                <div class="col-12">
                    <form class="form-default" action="{{route('settings.update')}}" method="post" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')
                        <div class="row">
                            
                            <div class="col-12 col-md-6 mb-5">

                                <div class="form-floating">
                                    <select  id="searchType" class="form-control @error('searchType') is-invalid @enderror" name="searchType">
                                        <option value="text" {{ $setting->searchType == 'text' ? 'selected' : '' }}>Texto</option>
                                        <option value="parameters" {{ $setting->searchType == 'parameters' ? 'selected' : '' }}>Parâmetros</option>
                                    </select>
                                    <label for="searchType">Tipo de busca</label>
                                </div>

                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                
                                <div class="form-floating">
                                    <select id="messageType" class="form-control @error('messageType') is-invalid @enderror" name="messageType">
                                        <option value="replace" {{ $setting->messageTyoe == 'replace' ? 'selected' : '' }}>Tipo de mensagem padrão</option>
                                        <option value="chatgpt" {{ $setting->messageTyoe == 'chatgpt' ? 'selected' : '' }}>Chat GPT</option>
                                    </select>
                                    <label for="messageType">Tipo de mensagem</label>
                                </div>

                            </div>

                            <div class="col-12 mb-5">
                                
                                <div class="form-floating">
                                    <textarea rows="30" class="form-control" placeholder="Digite a mensagem base para seus contatos" id="messageDefault" name="messageDefault">{{ $setting->messageDefault }}</textarea>
                                    <label for="messageDefault">Mensagem Padrão</label>
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