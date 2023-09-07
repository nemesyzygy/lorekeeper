@if ($character->genomes->count())
    @foreach ($character->genomes as $genome)
        @include('character._genes', ['genome' => $genome])
    @endforeach
@else
    <div>This character's genes are hidden!</div>
    <div>
    @php
    $button = "";
    if (Auth::user() && Auth::user()->hasPower('manage_characters') && Auth::user()->hasPower('view_hidden_genetics')) {
        $button .= "<a href=\"#\" class=\"btn btn-link btn-sm ";
            $button .= "add-genome\"><i class=\"fas fa-plus\"";

        $button .= "></i></a>";
    }
@endphp


    Unknown {!! $button !!}

</div>
@endif

