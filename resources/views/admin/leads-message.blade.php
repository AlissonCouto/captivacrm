@extends('admin.master')

@section('content')

    <div class="toolbar">

        <div class="account justify-content-end">

            <div class="edit-account">

                <a href="#">
                    <i class="mdi mdi-account icon"></i>
                </a>

            </div>

            <div class="items">
                <a href="#">
                    <i class="mdi mdi-cogs icon"></i> Configurações
                </a>

                <a href="#">
                    <i class="mdi mdi-logout icon"></i> Sair
                </a>
            </div>

        </div> <!-- .account -->

    </div><!-- .toolbar -->

    <div class="table-container">

    <div class="header-table">

        <div class="meta-infos">

            <h2 class="title">Leads ({{ isset($leads) ? count($leads) : 0 }})</h2>

        </div> <!-- .meta-infos -->

    </div> <!-- .header-table -->

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
                </tr>

            </thead>

            <tbody>

                @if($leads)
                    @foreach($leads as $lead)
                        <tr>
                            <td>{{$lead->name}}</td>
                            
                            <td> 

                                @if($lead->phone)
                                    <a href="https://api.whatsapp.com/send?phone=55{{ str_replace(['(', ')', '-', ' '], ['', '', '', ''], $lead->phone) }}" target="_blank"><span class="whatsapp"><i class="mdi mdi-whatsapp icon"></i></span> {{$lead->phone}}</a>
                                @else
                                --
                                @endif
                            
                            </td>

                            <td>{{$lead->website}}</td>
                            <td>{{$lead->niche()->first()->name}}</td>
                            <td>{{$lead->city()->first()->nome}}</td>
                            <td>{{$lead->city()->first()->uf}}</td>

                            <td>
                                <div class="actions">

                                    <div class="action details">
                                        <a href="#"><i class="mdi mdi-magnify"></i></a>
                                    </div>

                                    <div class="action edit">
                                        <a href="#"><i class="mdi mdi-pencil icon"></i></a>
                                    </div>

                                    <div class="action delete">
                                        <a href="#"><i class="mdi mdi-delete icon"></i></a>
                                    </div>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                @else

                    <tr>
                        <td colspan="6">Nenhum registro econtrado!</td>
                    </tr>

                @endif

            </tbody>
        </table>

    </div>

    </div>

@endsection