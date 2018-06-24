@extends('layouts.admin')

@section('content')

    Dashboard

    <button data-popshow="test1">open</button>

    <div id="test1" class="popup">

        <div class="popup__overlay"></div>

        <div class="popup__body">

            <div data-pophide="test1" class="popup__close-icon fas fa-times"></div>

        </div>

    </div>

    @component('admin/components/message')@endcomponent

@endsection
