@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title') {{ $character->fullName }} @endsection

@section('meta-img') {{ $character->image->thumbnailUrl }} @endsection

@section('profile-content')

@include('widgets._awardcase_feature', ['target' => $character, 'count' => Config::get('lorekeeper.extensions.awards.character_featured'), 'float' => true])

@if($character->is_myo_slot)
{!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url]) !!}
@else
{!! breadcrumbs([($character->category->masterlist_sub_id ? $character->category->sublist->name.' Masterlist' : 'Character masterlist') => ($character->category->masterlist_sub_id ? 'sublist/'.$character->category->sublist->key : 'masterlist' ), $character->fullName => $character->url]) !!}
@endif

@if(!$character->isAvailable)
<div class="alert alert-info">
    This {{ $character->is_myo_slot ? 'MYO' : 'Character' }} is currently either in an active trade, transfer, design update, or is wrapped in a box.
</div>
@endif   

@include('character._header', ['character' => $character])

        <div class="card-header mb-2">
            <ul class="nav nav-tabs card-header-tabs">
                @foreach ($character->images()->where('is_valid', 1)->get() as $image)
                    <li class="nav-item">
                        <a class="nav-link form-data-button {{ $image->id == $character->image->id ? 'active' : '' }}" data-toggle="tab" role="tab" data-id="{{ $image->id }}">
                            {{ $image->transformation_id ? $image->transformation->name : 'Main' }}
                        </a>
                    </li>
                @endforeach
                <li>
                    <h3>{!! add_help('Click on a '.__('transformations.transformation').' to view the image. If you don\'t see the '.__('transformations.transformation').' you\'re looking for, it may not have been uploaded yet.') !!}</h3>
                </li>
            </ul>
        </div>


{{-- Main Image --}}
<div class="row mb-3" id="main-tab" style="clear:both;">
         <div class="col-md-6">
    @if(isset($background) && Config::get('lorekeeper.extensions.character_backgrounds.enabled'))
    <div class="text-center" style="{{ implode('; ',$background) }}; background-size: cover; background-repeat:no-repeat; width: 650px; height: 750px; background-position: center; border-radius: 20px;">
            <a href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" data-lightbox="entry" data-title="{{ $character->fullName }}">
                <img src="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" class="image" style="max-height: 720px; width: auto;" alt="{{ $character->fullName }}" />
            </a>
        </div>
        @else
        <div class="text-center">
            <a href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" data-lightbox="entry" data-title="{{ $character->fullName }}">
                <img src="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" class="image" style="max-height: 720px; width: auto;" alt="{{ $character->fullName }}" />
            </a>
        </div>
        @endif
        @if($character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)))
            <div class="text-right">You are viewing the full-size image. <a href="{{ $character->image->imageUrl }}">View watermarked image</a>?</div>
        @endif
    </div>
    @include('character._image_info', ['image' => $character->image])
</div>

{{-- Info --}}
<div class="card character-bio">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="statsTab" data-toggle="tab" href="#stats" role="tab">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="logsTab" data-toggle="tab" href="#logs" role="tab">Ownership</a>
            </li>
            @if($character->getLineageBlacklistLevel() < 2)
                <li class="nav-item">
                    <a class="nav-link" id="lineageTab" data-toggle="tab" href="#lineage" role="tab">Genetics</a>
                </li>
            @endif
            @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                <li class="nav-item">
                    <a class="nav-link" id="settingsTab" data-toggle="tab" href="#settings-{{ $character->slug }}" role="tab"><i class="fas fa-cog"></i></a>
                </li>
            @endif
        </ul>
    </div>
    <div class="card-body tab-content">
        <div class="tab-pane fade show active" id="stats">
            @include('character._tab_stats', ['character' => $character])
        </div>
        <div class="tab-pane fade" id="logs">
            @include('character._tab_logs', ['character' => $character])
        </div>
        @if($character->getLineageBlacklistLevel() < 2)
            <div class="tab-pane fade" id="lineage">
                @include('character._tab_lineage', ['character' => $character])
            </div>
        @endif
        @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
            <div class="tab-pane fade" id="settings-{{ $character->slug }}">
                {!! Form::open(['url' => $character->is_myo_slot ? 'admin/myo/'.$character->id.'/settings' : 'admin/character/'.$character->slug.'/settings']) !!}
                    <div class="form-group">
                        {!! Form::checkbox('is_visible', 1, $character->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                        {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Turn this off to hide the character. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the character\'s page.') !!}
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
                <hr />
                <div class="text-right">
                    <a href="#" class="btn btn-outline-danger btn-sm delete-character" data-slug="{{ $character->slug }}">Delete</a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
    @parent
    @include('character._image_js', ['character' => $character])
    @include('character._transformation_js')
@endsection