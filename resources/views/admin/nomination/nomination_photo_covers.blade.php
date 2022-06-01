<div class="row">
    <div class="col-12">
        <div class="block block-rounded">
            <div class="block-content">

                @if(count($photoNominationCovers) == 0)
                    <div class="alert alert-success alert-dismissible" role="alert">
                        Номинация не имеет фотографий
                    </div>
                @endif

                @if(count($photoNominationCovers) > 0)
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th colspan="2">Номинированные фото</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($photoNominationCovers as $nextPhotoNominationCover)
                    <tr>
                        <td style="width: 60%;">
{{--                            {{$nextPhotoNominationCover['photo_id']}}::--}}
                            <a class="btn btn-sm btn-success btn-icon m-2" href="{{ route('photos.edit', $nextPhotoNominationCover['photo_id']) }}"  title="Открыть редактор фото" target="_blank">
                                <i class="fas fa-edit icon-nm"></i>
                            </a>
                            {{$nextPhotoNominationCover['photo_name'] }}
                        </td>
                        <td style="width: 40%;">
                            @if($nextPhotoNominationCover['is_selected'])
                                <i class="fa fa-check text-success"></i>
                                {{ __('Да') }}, {{ __('Прикреплена') }}

                                <button type="button" class="btn btn-sm btn-alt-secondary" onclick="revokeNominationPhotoCovers( {{ $nextPhotoNominationCover['photo_id'] }}, {{ $nextPhotoNominationCover['nomination_id'] }} )" id="btn_revoke_nomination_to_photo_8" style="display:  block ">
                                    Отменить прикрепление
                                </button>
                            @else

                                <button type="button" class="btn btn-sm btn-primary" onclick="assignNominationToPhotoCovers( {{ $nextPhotoNominationCover['photo_id'] }}, {{ $nextPhotoNominationCover['nomination_id'] }} )" id="btn_assign_nomination_to_photo_1" style="display:  block ">
                                    Прикрепить
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach


                    </tbody>
                </table>
                @endif

            </div>
        </div>
    </div>
</div>
