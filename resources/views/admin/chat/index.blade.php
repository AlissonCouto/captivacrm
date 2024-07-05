@extends('admin.master')

@php
    $timezone = new \DateTimeZone('America/Campo_Grande');
@endphp

@section('content')

    <div class="toolbar w-100 d-flex justify-content-end">

        @include('admin.components.toolbar.notification')
        @include('admin.components.toolbar.account')

    </div><!-- .toolbar -->

    <div class="entity-container">

        <div class="header-container">

            <div class="meta-infos">

                <h2 class="title">Chat com {{$lead->name}}</h2>

            </div> <!-- .meta-infos -->

        </div> <!-- .header-table -->

        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-12">
                    
                    <div class="chat">

                        <div id="messages" class="messages">

                            @foreach($messages as $k => $message)

                                @if($k == 0)
                                    @php
                                        $current = new \DateTime($message->created_at);
                                        $current->setTimezone($timezone);
                                    @endphp
                                    <span class="messages-date"><?= $current->format('d/m'); ?></span>
                                @endif
                                
                                @if((new DateTime($message->created_at))->setTimezone($timezone)->format('d/m/Y') != $current->format('d/m/Y'))

                                    @php
                                        $current = new \DateTime($message->created_at);
                                        $current->setTimezone($timezone);
                                    @endphp
                                    <span class="messages-date"><?= $current->format('d/m'); ?></span>
                                @endif
                                

                                @include('admin.chat.line', ['message' => $message])

                            @endforeach

                        </div>

                        <div class="field">
                            <form action="{{route('chat.store', $lead->id)}}" method="post" id="chat">
                                <textarea name="message" id="message" placeholder="Digite uma mensagem"></textarea>
                                <button type="submit">Enviar</button>
                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection