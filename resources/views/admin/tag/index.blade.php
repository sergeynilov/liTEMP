@extends('layouts.backend')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
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

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>


    <script>
        initTags()


        function deleteTag(tag_id) {

            Swal.fire({
                title: "{{ __('Вы хотите удалить выбранный тег') }} ?",
                text: "{{ __('Вы удалите тег и очистите все фотографии с этим тегом') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, удалить тег') }} !"
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        type: "DELETE",
                        dataType: "json",
                        url: '/admin/tags/'+tag_id,
                        data: {"tag": tag_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            loadTags()
                            Swal.fire({
                                title: '{{ __('Список тегов') }}!',
                                text: '{{ __('Тег удален') }}!',
                                icon: 'success',
                            })
                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка удаления тега') }} ',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });
                }

            });

        }

        function initTags() {
            var url = "{!!route('TagsGetFilter')!!}";
            oTable = $('.js-dataTable-full').dataTable({
                "language": {
                    "emptyTable": "{{ __('Теги не найдены') }}",
                    "processing": "{{ __('Теги загружаются...') }}"
                },
                "bServerSide": true,
                "sAjaxSource": url,

                "bProcessing": true,
                "aoColumns": [
                    {
                        "sWidth": "10%",
                        "mData": 'id',
                        "bSortable": true
                    },
                    {
                        "sWidth": "40%",
                        "mData": 'title',
                        "bSortable": true
                    },
                    {
                        "sWidth": "20%",
                        "mData": 'active_label',
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
        <a class="btn btn-sm btn-success btn-icon m-2" href="' + data['edit_url'] + '"  title="Редактировать тег"><i class="fas fa-edit icon-nm"></i></a>\n\
        <a class="btn btn-sm btn-danger btn-icon m-2" onclick="deleteTag(' + data.id + ')"  title="Удалить тег"><i class="fas fa-trash-alt icon-nm mb-1 "></i></a>\n\
    </div>';
                        }

                    }]
            });
        } // function initTags() {

        function loadTags() {
            $('.js-dataTable-full').DataTable().clear();
            $('.js-dataTable-full').DataTable().ajax.reload();
        }
    </script>


@endsection

@section('content')
    <!-- TAG LISTING TITLE BLOCK-->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Список тегов') }}
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
                            {{ __('Список тегов') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END TAG LISTING TITLE BLOCK-->

    <!-- TAGS LISTING -->
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
                    <small>{{ __('Вы можете искать, создавать, редактировать, удалять теги') }}</small>
                </h3>
                <div class="d-flex justify-content-end">
                    <a href="{!!route('tags.create')!!}" class="btn-sm btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Добавить') }}
                    </a>
                </div>
            </div>


            <div class="block-content block-content-full">

                <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>{{ __('Наименование') }}</th>
                        <th>{{ __('Активен') }}</th>
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

    <!-- END TAGS LISTING -->

@endsection
