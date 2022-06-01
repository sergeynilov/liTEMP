@extends('layouts.frontend')


@section('content')

    <x-frontend.nomination :defaultNomination="$defaultNomination"  :nominatedPhotos="$nominatedPhotos" :nominatedPhotosPagination="$nominatedPhotosPagination"  />

@endsection

