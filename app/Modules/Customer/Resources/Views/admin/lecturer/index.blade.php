@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])

        <div class="block">
            <form action="{{ route($baseRouteName . 'index') }}" method="GET">

                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="full_name" placeholder="{{ $trans_text['full_name'] }}"
                                   class="form-control"
                                   value="{{ request()->get('full_name') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-select-component
                                label-name="label"
                                placeholder="{{ $trans_text['statuses'] }}"
                                name="status"
                                _value="{{ request()->get('status') ? request()->get('status') : '' }}"
                                :list="{{ json_encode($options['statuses'],JSON_UNESCAPED_UNICODE) }}">
                            </admin-select-component>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div class="form-group">
                            <a href="{{ route($baseRouteName . 'index', []) }}" class="btn btn-warning" type="button"><i
                                    class="fa fa-refresh"></i> @lang($langFolderName . '.reset')
                            </a>
                            <button class="btn btn-info" type="submit"><i
                                    class="fa fa-search"></i> @lang($langFolderName . '.search')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            @can(getPermissionKey($moduleKey, 'create', true))
                <div class="col-md-6">
                    <a href="{{ route($baseRouteName . 'create') }}" class="btn btn-primary"><i
                            class="el-icon-plus"></i> {{ $trans_text['create'] }}</a>
                </div>
            @endcan
            @can(getPermissionKey($moduleKey, 'update_status', false))
                <a class="btn btn-info" href="{{ route($baseRouteName . 'export', request()->all()) }}"><i
                        class="fa fa-file"></i>{{ $trans_text['export'] }}</a>
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
                            <th> {{ $trans_text['full_name'] }}</th>
                            <th> {{ $trans_text['status'] }}</th>
                            <th> {{ $trans_text['lecturer_directions'] }}</th>
                            <th width="10%" class="text-center">@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{!! $item->full_name !!}</td>
                                <td>
                                    <status-component
                                        :active="'{{ $item->status ? true : false }}'"
                                        :route="'{{ route($baseRouteName . 'update_status') }}'"
                                        :id="{{ $item->id }}">
                                    </status-component>
                                </td>
                                <td>
                                    @foreach($item->directions as $direction)
                                        <a href="{{ route('admin.direction.edit',[$direction->id]) }}" target="_blank">
                                            {{ $direction->title }}
                                        </a>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @can(getPermissionKey($moduleKey, 'show', false))
                                        <a class="btn btn-secondary"
                                           href="{{ route($baseRouteName . 'show', $item->id) }}"><i
                                                class="fa fa-eye"></i></a>
                                    @endcan
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
