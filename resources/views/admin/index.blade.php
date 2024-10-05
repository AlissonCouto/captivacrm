@extends('admin.master')

@section('content')
    <div class="toolbar">
        @include('admin.components.toolbar.operations')

        <div class="toolbar d-flex align-items-center justify-content-end mt-0">
            @include('admin.components.toolbar.notification')
            @include('admin.components.toolbar.account')
        </div>
    </div><!-- .toolbar -->

    <div class="table-container">

    <div class="header-table">

        <div class="meta-infos">

        <h2 class="title">Leads <span id="entity-quantity">({{ $total }})</span></h2>

        <div class="filter">

            <form class="search-container" action="{{route('leads.consult')}}" method="post" id="search-entity">
                <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pesquisar" name="search" id="search">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                </div>
            </form>

        </div>

        </div> <!-- .meta-infos -->

        <div class="pagination">
            <div class="from">{{ $entity->firstItem() }}</div> - 
            <div class="to">{{ $entity->lastItem() }}</div>
            <span>de</span>
            <div class="total">{{ $entity->total() }}</div>

            <div class="navigations">
                <a href="#" class="prev {{ $entity->onFirstPage() ? '-inactive' : '' }}" data-page="{{ $entity->currentPage() - 1 }}">
                    <i class="mdi mdi-chevron-left icon"></i>
                </a>

                <a href="#" class="next {{ $entity->hasMorePages() ? '' : '-inactive' }}" data-page="{{ $entity->currentPage() + 1 }}">
                    <i class="mdi mdi-chevron-right icon"></i>
                </a>
            </div>
        </div> <!-- pagination -->

    </div> <!-- .header-table -->

    <div class="header-table">

    <div class="meta-infos">

        <div class="filter">

            <div class="form-floating">
                <select  id="withWhatsapp" class="form-control" name="withWhatsapp">
                    <option value="" selected>Selecione...</option>    
                    <option value="yes">Sim</option>
                    <option value="no">Não</option>
                </select>
                <label for="withWhatsapp">Whatsapp?</label>
            </div>

            <div class="form-floating">
                <select  id="status" class="form-control" name="status">
                    <option value="" selected>Selecione...</option>    
                    @foreach($statuses as $status)
                        <option value="{{$status->id}}">{{$status->name}}</option>
                    @endforeach
                </select>
                <label for="status">Status</label>
            </div>

            <div class="form-floating">
                <input id="lastContact" type="date" name="lastContact">
                <label for="lastContact">Último contato</label>
            </div>

            <div class="form-floating">
                <input id="callScheduled" type="date" name="callScheduled">
                <label for="callScheduled">Chamada agendada</label>
            </div>

            <div class="form-floating">
                <input id="created_at" type="date" name="created_at">
                <label for="created_at">Salvo em</label>
            </div>

            <button type="button" class="filter-button"><i class="mdi mdi-magnify"></i></button>

        </div>

    </div>

    </div>

    <div class="body-table">

        <table class="table responsive-table table-striped">
            <thead>

                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Site</th>
                    <th>Nicho</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>Ativo?</th>
                </tr>

            </thead>

            <tbody>

                @if($entity->count())
                @foreach($entity as $row)
                <tr>
                    <td>{{$row->name}}</td>
                    <td>

                        @if($row->phone)
                        <a href="https://api.whatsapp.com/send?phone=55{{ str_replace(['(', ')', '-', ' '], ['', '', '', ''], $row->phone) }}" target="_blank"><span class="whatsapp"><i class="mdi mdi-whatsapp icon"></i></span> {{$row->phone}}</a>
                        @else
                        --
                        @endif

                    </td>
                    
                    <td class="website">

                        @if($row->website)
                        <a href="{{$row->website}}" target="_blank">{{$row->website}}</a>
                        @else
                        ----
                        @endif

                    </td>

                    <td>

                        @php
                        $niche = $row->niche()->first();
                        @endphp

                        {{ $niche ? $niche->name : '--' }}
                    </td>

                    <td>

                        @php
                        $city = $row->city()->first();
                        @endphp

                        {{ $city ? $city->nome : '--' }}
                    </td>

                    <td>
                        {{ $city ? $city->uf : '--' }}
                    </td>

                    <td>
                        {{ $row->status == 1 ? 'Sim' : 'Não' }}
                    </td>

                    <td>
                        <div class="actions">

                            <div class="action chat">
                                <a href="{{route('chat.index', $row->id)}}"><i class="mdi mdi-chat"></i></a>
                            </div>

                            <div class="action details">
                                <a href="{{route('leads.show', $row->id)}}"><i class="mdi mdi-magnify"></i></a>
                            </div>

                            <div class="action edit">
                                <a href="{{route('leads.edit', $row->id)}}"><i class="mdi mdi-pencil icon"></i></a>
                            </div>

                            <div class="action delete">
                                <a href="{{route('leads.destroy', $row->id)}}"><i class="mdi mdi-delete icon"></i></a>
                            </div>

                        </div>
                    </td>

                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center pt-5">
                        <h1 class="h1">Nenhum registro encontrado</h1>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>

    </div>

@endsection