@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])

        <div class="block">
            <form action="{{ route($baseRouteName . 'index') }}" method="GET">

                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="title"  placeholder="{{ $trans_text['title'] }}" class="form-control"
                                   value="{{ request()->get('title') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="owner"  placeholder="{{ $trans_text['owner_name'] }}" class="form-control"
                                   value="{{ request()->get('owner') }}">
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
                            <th> {{ $trans_text['description'] }}</th>
                            <th> {{ $trans_text['company_owners'] }}</th>
                            <th width="10%" class="text-center">@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{!! $item->title !!}</td>
                                <td>{!! $item->description !!}</td>
                                <td>
                                    @foreach($item->ownerMembers as $ownerMembers)
                                        <a href="{{ route('admin.customer.show_profile',[$ownerMembers->user_id]) }}" target="_blank">
                                            {{ $ownerMembers->user->full_name }}
                                        </a>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @can(getPermissionKey($moduleKey, 'show', false))
                                        <a class="btn btn-secondary" href="{{ route($baseRouteName . 'show', $item->id) }}"><i class="fa fa-eye"></i></a>
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
