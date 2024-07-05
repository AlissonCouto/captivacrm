@php
    $timezone = new \DateTimeZone('America/Campo_Grande');
    $date = new \DateTime($message->created_at);
    $date->setTimezone($timezone);
@endphp
<div class="line -{{ $message->from }}" id="{{$message->sid}}">
    <span class="message">
        {{$message->message}}

        <div class="meta-infos">
            <span class="hour">{{$date->format('H:i')}}</span>
                                            
            @if($message->from == 'company')
                @if($message->status == 'read' || $message->status == 'delivered')
                    <span class="status"><i class="mdi mdi-check-all {{ $message->status == 'read' ? 'read' : '' }}"></i></span>
                @else
                    <span class="status"><i class="mdi mdi-check {{ $message->status == 'failed' ? 'failed' : '' }}"></i></span>
                @endif
            @endif
        </div>
    </span>
</div>