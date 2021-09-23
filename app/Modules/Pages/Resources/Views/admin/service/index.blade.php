@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])
        <div class="row">
            @can(getPermissionKey($moduleKey, 'create', true))
                <div class="col-md-6">
                    <a href="{{ route($baseRouteName . 'create') }}" class="btn btn-primary"><i class="el-icon-plus"></i> {{ $trans_text['create'] }}</a>
                </div>
            @endcan
        </div>
        <br>
        <div class="block">
            @include('admin::includes.success')
            @if(count($allData) == 0)
                <br><h3 class="text-center">@lang('admin.result_not_found')</h3><br>
            @else
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>{{ $trans_text['id'] }}</th>
                            <th> {{ $trans_text['title'] }}</th>
                            <th> {{ $trans_text['status'] }}</th>
                            <th width="10%" class="text-center">@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{!! $item->title !!}</td>
                                <td>
                                    <status-component
                                        :active="'{{ $item->status ? true : false }}'"
                                        :route="'{{ route($baseRouteName . 'update_status') }}'"
                                        :id="{{ $item->id }}">
                                    </status-component>
                                </td>
                                <td class="text-center">
                                    @can(getPermissionKey($moduleKey, 'update', true))
                                        @include('admin::includes.actions.edit',['route' => route($baseRouteName . 'edit', [ $item->id ])])
                                    @endcan
                                    @can(getPermissionKey($moduleKey, 'delete', true))
                                        <delete-component
                                            :url="'{{ route($baseRouteName . 'delete') }}'"
                                            :id="{{ $item->id }}"
                                        ></delete-component>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @include('admin::includes.paginate', ['data' => $allData ])
            <br>
        </div>
    </div>
@endsection
