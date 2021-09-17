@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])

        <div class="block">
            <form action="{{ route($baseRouteName . 'index') }}" method="GET">

                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="name"  placeholder="{{ $trans_text['name'] }}" class="form-control"
                                   value="{{ request()->get('name') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="surname"  placeholder="{{ $trans_text['surname'] }}" class="form-control"
                                   value="{{ request()->get('surname') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="phone_number"  placeholder="{{ $trans_text['phone_number'] }}" class="form-control"
                                   value="{{ request()->get('phone_number') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-select-component
                                label-name="label"
                                placeholder="{{ $trans_text['verifies'] }}"
                                name="is_verify"
                                _value="{{ request()->get('is_verify') ? request()->get('is_verify') : '' }}"
                                :list="{{ json_encode($options['verifies'],JSON_UNESCAPED_UNICODE) }}">
                            </admin-select-component>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="email"  placeholder="{{ $trans_text['email'] }}" class="form-control"
                                   value="{{ request()->get('email') }}">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-date-component
                                placeholder="{{ $trans_text['register_date_from'] }}"
                                name="date_from"
                                _value="{!!  request()->get('date_from') ? request()->get('date_from') : '' !!}">
                            </admin-date-component>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-date-component
                                placeholder="{{ $trans_text['register_date_to'] }}"
                                name="date_to"
                                _value="{!!  request()->get('date_to') ? request()->get('date_to') : '' !!}">
                            </admin-date-component>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div class="form-group">
                            <a href="{{ route($baseRouteName . 'index', []) }}" class="btn btn-warning" type="button"><i
                                    class="fa fa-refresh"></i>  @lang($langFolderName . '.reset')
                            </a>
                            <button class="btn btn-info" type="submit"><i
                                    class="fa fa-search"></i> @lang($langFolderName . '.search')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="block">
            @can(getPermissionKey($moduleKey, 'update_status', false))
                <a class="btn btn-info" href="{{ route($baseRouteName . 'export', request()->all()) }}"><i class="fa fa-file"></i>{{ $trans_text['export'] }}</a>
            @endcan
            @include('admin::includes.success')
            @if(count($allData) == 0)
                <br><h3 class="text-center">@lang('admin.result_not_found')</h3><br>
            @else
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>{{ $trans_text['id'] }}</th>
                            <th> {{ $trans_text['email'] }}</th>
                            <th> {{ $trans_text['name'] }}</th>
                            <th> {{ $trans_text['phone_number'] }}</th>
                            @can(getPermissionKey($moduleKey, 'update_status', false))
                                <th> {{ $trans_text['status'] }}</th>
                            @endcan
                            <th width="10%" class="text-center">@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->full_name }}</td>
                                <td> {{ $item->phone_number }}</td>
                                @can(getPermissionKey($moduleKey, 'update_status', false))
                                    <td>
                                        <status-component
                                            :active="'{{ $item->status ? true : false }}'"
                                            :route="'{{ route($baseRouteName . 'update_status') }}'"
                                            :id="{{ $item->id }}">
                                        </status-component>
                                    </td>
                                @endcan
                                <td class="text-center">
                                    @can(getPermissionKey($moduleKey, 'show_profile', false))
                                        <a class="btn btn-secondary" href="{{ route($baseRouteName . 'show_profile', $item->id) }}"><i title="{{ $trans_text['show_profile'] }}" class="fa fa-eye"></i></a>
                                    @endcan
                                    @can(getPermissionKey($moduleKey, 'update', true))
                                        @include('admin::includes.actions.edit',['route' => route($baseRouteName . 'edit', [ $item->id ])])
                                    @endcan
                                    @can(getPermissionKey($moduleKey, 'login_as_customer', false))
                                        <a class="btn btn-warning" href="{{ route($baseRouteName . 'login_as_customer', $item->id) }}" target="_blank">
                                            <i title="Login as customer" class="fa fa-user"></i>
                                        </a>
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
