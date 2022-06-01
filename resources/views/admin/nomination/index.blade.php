@extends('layouts.backend')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="/css/select.dataTables.min.css">
    <link rel="stylesheet" href="/css/rowReorder.dataTables.min.css">
@endsection

@section('js_after')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
    <script src="/js/dataTables.select.min.js"></script>
    <script src="/js/dataTables.rowReorder.min.js"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>


    <script>
        var oTable = null
        var set_ordering_mode_on_change = false
        $('#set_ordering_mode').prop('checked', set_ordering_mode_on_change);

        initNominations()

        function deleteNomination(nomination_id) {

            Swal.fire({
                title: "{{ __('Вы хотите удалить выбранную номинацию') }} ?",
                text: "{{ __('Вы удалите номинацию и очистите все фотографии с этой номинацией') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, удалить номинацию') }} !"
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        type: "DELETE",
                        dataType: "json",
                        url: '/admin/nominations/' + nomination_id,
                        data: {"nomination": nomination_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            loadNominations()
                            Swal.fire({
                                title: '{{ __('Список номинаций') }} !',
                                text: '{{ __('Номинация удалена') }} !',
                                icon: 'success',
                            })
                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка удаления номинацию') }} ',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });
                }

            });

        } // function deleteNomination(nomination_id) {

        function initNominations() {

            var url = "{!!route('NominationsGetFilter')!!}";
            var table = $('#nominationsDataTable').DataTable({
                select: set_ordering_mode_on_change,
                rowReorder: set_ordering_mode_on_change,

                "bServerSide": true,
                "sAjaxSource": url,

                "bProcessing": true,
                "bDestroy": true,

                "aoColumns": [
                    {
                        "sWidth": "10%",
                        "mData": 'id',
                        "bSortable": true
                    },
                    {
                        "sWidth": "30%",
                        "mData": 'title',
                        "bSortable": true
                    },
                    {
                        "sWidth": "20%",
                        "mData": 'active_label',
                        "bSortable": true
                    },
                    {
                        "sWidth": "10%",
                        "mData": 'ordering',
                        "bSortable": true
                    },
                    {
                        "sWidth": "20%",
                        "mData": 'created_at_formatted',
                        "bSortable": true
                    },

                    {
                        "sWidth": "10%",
                        "mData": null,
                        "bSortable": false,
                        "mRender": function (data, type, full) {

                            return '<div class="text-nowrap">\n\
        <a class="btn btn-sm btn-success btn-icon m-2" href="' + data['edit_url'] + '"  title="Edit nomination"><i class="fas fa-edit icon-nm"></i></a>\n\
        <a class="btn btn-sm btn-danger btn-icon m-2" onclick="deleteNomination(' + data.id + ')"  title="Удалить номинацию"><i class="fas fa-trash-alt icon-nm mb-1 "></i></a>\n\
    </div>';
                        }

                    }]

            })

            table.on('row-reorder', function (e, diff, edit) {
                if (!set_ordering_mode_on_change) return

                var rowsToReorder = []
                for (var i = 0, ien = diff.length; i < ien; i++) {
                    if (typeof diff[i].node.cells[0].textContent != undefined) {
                        rowsToReorder.push(
                            {
                                'id': diff[i].node.cells[0].textContent,
                                'new_position': diff[i].newPosition,
                                'old_position': diff[i].oldPosition,
                            })
                    }

                }

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '/admin/nominations/set_reordering',
                    data: {"rowsToReorder": rowsToReorder, "_token": $('meta[name="csrf-token"]').attr('content')},
                    success: function (response) {
                        loadNominations()
                        Swal.fire({
                            title: '{{ __('Список номинаций') }} !',
                            text: '{{ __('Изменения в номинациях сохранены') }} !',
                            icon: 'success',
                        })
                        set_ordering_mode_on_change = false
                        $('#set_ordering_mode').prop('checked', set_ordering_mode_on_change);
                    },
                    error: function (error) {
                        console.error(error)
                        Swal.fire({
                            title: '{{ __('Ошибка удаления номинацию') }} ',
                            text: getErrorMessage(error),
                            type: 'danger',
                            icon: 'warning',
                        })
                    }
                });

            });

        } // function initNominations() {

        function loadNominations() {
            $('#nominationsDataTable').DataTable().clear();
            $('#nominationsDataTable').DataTable().ajax.reload();
        } //#nominationsDataTable

        function setOrderingModeOnChange() {
            set_ordering_mode_on_change = !set_ordering_mode_on_change
            console.log('setOrderingModeOnChange set_ordering_mode_on_change::')
            console.log(set_ordering_mode_on_change)
            if (set_ordering_mode_on_change) { // add_nomination

            }
            // document.getElementById('nominationsDataTable')= null
            initNominations()
            loadNominations()
        }

    </script>


@endsection

@section('content')
    <!-- NOMINATIONS LISTING TITLE BLOCK-->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Список номинаций') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __('Используются для описания загруженных фотографий') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">{{ __('Домой') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Список номинаций') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END NOMINATIONS LENSES LISTING TITLE BLOCK-->

    <!-- NOMINATIONS LISTING -->
    <div class="content">

        <div class="block block-rounded">

            @if(session()->has('success_message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <p class="mb-0">
                        {{ session()->get('success_message') }}
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <small>{{ __('Вы можете искать, создавать, редактировать, менять порядковый номер, удалять номинации') }}</small>
                </h3>
                <div class="d-flex justify-content-end add_nomination">
                    <a href="{!!route('nominations.create')!!}" class="btn-sm btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Добавить') }}
                    </a>
                </div>
            </div>


            <div class="block p-0 m-0">
                <h3 class="block-title ps-3 pt-3">
                    <label class="form-check-label" for="set_ordering_mode">
                        <small>{{ __('Изменить порядковые номера перетаскиванием') }}</small>
                    </label>
                    <input class="form-check-input" type="checkbox" value="1"
                           id="set_ordering_mode" name="set_ordering_mode"
                           onchange="setOrderingModeOnChange()"
                    >
                </h3>
            </div>

            <div class="block-content block-content-full">
                <table id="nominationsDataTable">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>{{ __('Наименование') }}</th>
                        <th>{{ __('Активен') }}</th>
                        <th>{{ __('Порядковый номер') }}</th>
                        <th>{{ __('Создан') }}</th>
                        <th>{{ __('Операции') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>


        </div>

    </div>

    <!-- END NOMINATIONS LISTING -->

@endsection
