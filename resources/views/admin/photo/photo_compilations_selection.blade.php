<div class="row">
    <div class="col-12">
        <div class="block block-rounded">
            <div class="block-content">

                <!-- Striped Table -->
                <div class="block block-rounded">

                    <div class="block-header block-header-default ms-4 me-4">
                        <h3 class="block-title">{{ __('Каждая подборка может быть присвоена(очищенна от) выбранной фотографии') }}</h3>
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
                                <th>{{ __('Подборка') }}</th>
                                <th>{{ __('Прикреплена') }}</th>
                                <th class="text-center" style="width: 100px;">{{ __('Операции') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($compilations as $nextCompilation)
                                <tr>
                                    <td class="text-center">{{ $nextCompilation['id'] }}</td>
                                    <td class="fw-semibold fs-sm text-nowrap">
                                        {{ $nextCompilation['title'] }}
                                    </td>

                                    <td class="fw-semibold fs-sm text-nowrap">
                                        <span id="btn_assign_compilation_to_photo_{{ $nextCompilation['id'] }}_label"
                                              style="display: @if($nextCompilation['photo_compilations_count'] > 0) block @else none @endif">
                                            {{ __('Да') }}, {{ __('Прикреплена') }}
                                        </span>
                                        <span id="btn_revoke_compilation_to_photo_{{ $nextCompilation['id'] }}_label"
                                              style="display: @if($nextCompilation['photo_compilations_count'] == 0) block @else none @endif">
                                            {{ __('Нет') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="assignCompilationToPhoto( {{ $nextCompilation['id']  }} )"
                                                    id="btn_assign_compilation_to_photo_{{ $nextCompilation['id'] }}"
                                                    style="display: @if($nextCompilation['photo_compilations_count'] == 0) block @else none @endif">
                                                {{ __('Прикрепить') }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-alt-secondary"
                                                    onclick="revokeCompilationFromPhoto( {{ $nextCompilation['id'] }} )"
                                                    id="btn_revoke_compilation_to_photo_{{ $nextCompilation['id'] }}"
                                                    style="display: @if($nextCompilation['photo_compilations_count'] > 0) block @else none @endif"
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
