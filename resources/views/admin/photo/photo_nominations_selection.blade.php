<div class="row">
    <div class="col-12">
        <div class="block block-rounded">
            <div class="block-content">

                <!-- Striped Table -->
                <div class="block block-rounded">

                    <div class="block-header block-header-default ms-4 me-4">
                        <h3 class="block-title">{{ __('Каждая номинация может быть присвоена(очищенна от) выбранной фотографии') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="si si-settings"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-content">
                        <table class="table table-striped table-vcenter">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>{{ __('Номинация') }}</th>
                                <th>{{ __('Прикреплена') }}</th>
                                <th class="text-center" style="width: 100px;">{{ __('Операции') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($nominations as $nextNomination)
                                <tr>
                                    <td class="text-center">{{ $nextNomination['id'] }}</td>
                                    <td class="fw-semibold fs-sm text-nowrap">
                                        {{ $nextNomination['title'] }}
                                    </td>

                                    <td class="fw-semibold fs-sm text-nowrap">
                                        <span id="btn_assign_nomination_to_photo_{{ $nextNomination['id'] }}_label"
                                              style="display: @if($nextNomination['photo_nominations_count'] > 0) block @else none @endif">
                                            {{ __('Да') }}, {{ __('Прикреплена') }}
                                        </span>
                                        <span id="btn_revoke_nomination_to_photo_{{ $nextNomination['id'] }}_label"
                                              style="display: @if($nextNomination['photo_nominations_count'] == 0) block @else none @endif">
                                            {{ __('Нет') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="assignNominationToPhoto( {{ $nextNomination['id']  }} )"
                                                    id="btn_assign_nomination_to_photo_{{ $nextNomination['id'] }}"
                                                    style="display: @if($nextNomination['photo_nominations_count'] == 0) block @else none @endif">
                                                {{ __('Прикрепить') }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-alt-secondary"
                                                    onclick="revokeNominationFromPhoto( {{ $nextNomination['id'] }} )"
                                                    id="btn_revoke_nomination_to_photo_{{ $nextNomination['id'] }}"
                                                    style="display: @if($nextNomination['photo_nominations_count'] > 0) block @else none @endif"
                                            >
                                                {{ __('Отменить прикрепление') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Striped Table -->


            </div>
        </div>
    </div>
</div>
