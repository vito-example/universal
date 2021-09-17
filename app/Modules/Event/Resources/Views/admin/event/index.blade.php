@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])

        <div class="block">
            <form action="{{ route($baseRouteName . 'index') }}" method="GET">

                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="title" placeholder="@lang('admin.training.title')"
                                   class="form-control"
                                   value="{{ request()->get('title') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-select-component
                                label-name="label"
                                :multiple="true"
                                placeholder="{{ $trans_text['status'] }}"
                                name="statuses"
                                _value="{{ request()->get('statuses') ? request()->get('statuses') : '' }}"
                                :list="{{ json_encode($options['statuses'],JSON_UNESCAPED_UNICODE) }}">
                            </admin-select-component>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-date-component
                                placeholder="{{ $trans_text['date_from'] }}"
                                name="date_from"
                                _value="{!! request()->get('date_from') ? request()->get('date_from') : '' !!}">
                            </admin-date-component>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-date-component
                                placeholder="{{ $trans_text['date_to'] }}"
                                name="date_to"
                                _value="{!!  request()->get('date_to') ? request()->get('date_to') : '' !!}">
                            </admin-date-component>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-select-component
                                label-name="label"
                                :multiple="true"
                                placeholder="{{ $trans_text['type'] }}"
                                name="types"
                                _value="{{ request()->get('types') ? request()->get('types') : '' }}"
                                :list="{{ json_encode($options['types'],JSON_UNESCAPED_UNICODE) }}">
                            </admin-select-component>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-select-component
                                label-name="label"
                                :multiple="true"
                                placeholder="{{ $trans_text['form'] }}"
                                name="forms"
                                _value="{{ request()->get('forms') ? request()->get('forms') : '' }}"
                                :list="{{ json_encode($options['types'],JSON_UNESCAPED_UNICODE) }}">
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
                <div class="col-md-2">
                    <a href="{{ route($baseRouteName . 'create') }}" class="btn btn-primary"><i
                            class="el-icon-plus"></i> {{ $trans_text['create'] }}</a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route($baseRouteName . 'calendar') }}" class="btn btn-primary"><i
                            class="fa fa-calendar"></i> {{ $trans_text['calendar'] }}</a>
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
                            <th> {{ $trans_text['moderator'] }}</th>
                            <th> {{ $trans_text['status'] }}</th>
                            <th> {{ $trans_text['galleries'] }}</th>
                            <th width="10%" class="text-center">@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{!! $item->title !!}</td>
                                <td>{!! $item->moderator ? $item->moderator->name : '' !!}</td>
                                <td>
                                    <event-status-update
                                        event-status="{{ $item->status_label }}"
                                        :url="'{{ route($baseRouteName . 'update_status_data') }}'"
                                        :id="{{ $item->id }}">
                                    </event-status-update>
                                </td>
                                <td>
                                    <a title="ბანერის მართვა"
                                       href="{{ route($baseRouteName . 'edit',['id' => $item->id,'tab' => 'banners']) }}"
                                       class="btn btn-secondary"><i class="el-icon-picture"></i></a>
                                </td>
                                <td class="text-center">
                                    @can(getPermissionKey($moduleKey, 'show', false))
                                        @include('admin::includes.actions.view',['route' => route($baseRouteName . 'show', [ $item->id ])])
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
