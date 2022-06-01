@extends('layouts.frontend')

@section('content')

    <x-frontend.compilation_with_photos :default-compilation="$defaultCompilation"/>

@endsection
