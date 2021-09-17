@extends('admin::layouts.admin')
@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])

        <div class="block">
            <form action="{{ route($baseRouteName . 'index') }}" method="GET">

                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="event"  placeholder="@lang('admin.training.title')" class="form-control"
                                   value="{{ request()->get('event') }}">
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
                            <input type="text" name="user"  placeholder="@lang('admin.user.name')" class="form-control"
                                   value="{{ request()->get('user') }}">
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
        <br>
        <div class="block">
            @include('admin::includes.success')
            @if(count($allData) === 0)
                <br><h3 class="text-center">@lang('admin.result_not_found')</h3><br>
            @else
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>{{ $trans_text['id'] }}</th>
                            <th> {{ $trans_text['user'] }}</th>
                            <th> {{ $trans_text['training'] }}</th>
                            <th> {{ $trans_text['status'] }}</th>
                            <th width="10%" class="text-center">@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <a href="{{ route('admin.customer.' . 'show_profile', $item->user->id) }}"
                                       target="_blank">
                                        {!! $item->user->full_name !!}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('admin.event.show',$item->event->id)}}" target="_blank">
                                        {!! $item->event->title !!}
                                    </a>
                                </td>
                                <td>
                                    <session-request-status-update
                                            session-request-status="{{ $item->status_label }}"
                                            :url="'{{ route($baseRouteName . 'update_session_request_status_data') }}'"
                                            :id="{{ $item->id }}"
                                            :status="{{$item->status}}"
                                    >
                                    </session-request-status-update>
                                </td>
                                <td class="text-center">
                                    @can(getPermissionKey($moduleKey, 'show', false))
                                        @include('admin::includes.actions.view',['route' => route($baseRouteName . 'show', [ $item->id ])])
                                    @endcan
                                    @if(!$item->session)
                                        @can(getPermissionKey($moduleKey, 'update', true))
                                            <a href="{{ route($baseRouteName . 'edit',$item->id) }}"
                                               class="btn btn-primary"><i
                                                        class="el-icon-plus"></i></a>
                                        @endcan
                                    @endif
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
