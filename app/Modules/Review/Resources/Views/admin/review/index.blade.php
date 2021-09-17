@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])

        <div class="block">
            @include('admin::includes.success')

            <reviews-table :reviews="{{ $reviews }}" update-route="{{ $updateRoute }}"></reviews-table>

            <br>
        </div>
    </div>
@endsection
