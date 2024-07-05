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
                            <td>{{$row->website ? $row->website : '--'}}</td>
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
                                <div class="actions">

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