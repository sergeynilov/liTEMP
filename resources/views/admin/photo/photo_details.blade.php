<div class="row">
    <div class="col-12">
        <div class="block block-rounded">
            <div class="block-content">

                <div class="row push">
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label" style="width:120px;">{{ __('ID фотографии') }}</label>
                            <span class="fs-sm text-muted" id="photo_id">
                                {{ $photoDetails['id'] }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="width:120px;">{{ __('Наименование фотографии') }}</label>
                            <span class="fs-sm text-muted" id="photo_name">
                                {{ $photoDetails['name'] }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="width:120px;">{{ __('Опубликовал') }}</label>
                            <span class="fs-sm text-muted" id="photo_name">
                                {{ $photoDetails['owner']['name'] }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="width:120px;">{{ __('Дата публикации') }}</label>
                            <span class="fs-sm text-muted" id="photo_published_at">
                                {{ getFormattedDateTime($photoDetails['published_at']) }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="width:120px;">{{ __('Активен') }}</label>
                            <span class="fs-sm text-muted" id="photo_active">
                                {{ \App\Models\Photo::getPhotoStatusLabel($photoDetails['active']) }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="width:120px;">{{ __('Кол-во симпатий') }}</label>
                            <span class="fs-sm text-muted" id="photo_active">
                                {{ $photoDetails['photo_likes_count'] }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="width:120px;">{{ __('Создан') }}</label>
                            <span class="fs-sm text-muted" id="photo_created_at">
                                {{ getFormattedDateTime($photoDetails['created_at']) }}
                            </span>
                        </div>

                        @if(!empty($photoDetails['photo_tags']))
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">
                                        <i class="fa fa-briefcase text-muted me-1"></i> {{ __('Теги') }}
                                    </h3>
                                </div>
                                <div class="block-content">

                                    @foreach($photoDetails['photo_tags'] as $photoTag)
                                        <div class="d-flex align-items-center push">
                                            <div class="flex-grow-1">
                                                <div class="fs-sm">
                                                    {{ $photoTag['tag']['title']  }},&nbsp;&nbsp;
                                                    {{ App\Models\Tag::getTagStatusLabel($photoTag['tag']['active'])  }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endif


                        @if(!empty($photoDetails['photo_nominations']))
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">
                                        <i class="fa fa-bolt fa-2x text-muted fa-lg p-1 mt-1 mb-1"></i> {{ __('Номинации') }}
                                    </h3>
                                </div>
                                <div class="block-content">
                                    @foreach($photoDetails['photo_nominations'] as $photoNomination)
                                        <div class="d-flex align-items-center push">
                                            <div class="flex-grow-1">
                                                <div class="fs-sm">
                                                    <i class="fa fa-bolt fa-2x text-muted  fa-lg p-1 mt-1 mb-1"
                                                       style="background-color:{{ $photoNomination['nomination']['color'] ?? '#ffffff' }} !important; color: #ffffff !important;">
                                                    </i>
                                                    {{ $photoNomination['nomination']['title']  }},&nbsp;&nbsp;
                                                    {{ App\Models\Nomination::getNominationStatusLabel($photoNomination['nomination']['active'])  }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty($photoDetails['photo_compilations']))
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">
                                        <i class="fa fa-database fa-2x text-muted fa-lg p-1 mt-1 mb-1"></i> {{ __('Подборки') }}
                                    </h3>
                                </div>
                                <div class="block-content">
                                    @foreach($photoDetails['photo_compilations'] as $photoNomination)
                                        <div class="d-flex align-items-center push">
                                            <div class="flex-grow-1">
                                                <div class="fs-sm">
                                                    <i class="fa fa-database fa-2x text-muted  fa-lg p-1 mt-1 mb-1"
                                                       style="background-color:green !important; color: #ffffff !important;">
                                                    </i>
                                                    {{ $photoNomination['compilation']['title']  }},&nbsp;&nbsp;
                                                    {{ App\Models\Nomination::getNominationStatusLabel($photoNomination['compilation']['active'])  }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif


            </div>
        </div>

    </div>
</div>
</div>
</div>
