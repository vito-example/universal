@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])

        <div class="block">
            <form action="{{ route($baseRouteName . 'index') }}" method="GET">

                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="name" placeholder="{{ $trans_text['name'] }}" class="form-control"
                                   value="{{ request()->get('name') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="email" placeholder="{{ $trans_text['email'] }}"
                                   class="form-control"
                                   value="{{ request()->get('email') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <input type="text" name="phone" placeholder="{{ $trans_text['phone'] }}"
                                   class="form-control"
                                   value="{{ request()->get('phone') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <admin-select-component
                                    label-name="label"
                                    :multiple="true"
                                    placeholder="{{ $trans_text['companies'] }}"
                                    name="company_ids"
                                    _value="{{ request()->get('company_ids') ?? '' }}"
                                    :list="{{ json_encode($options['companies'],JSON_UNESCAPED_UNICODE) }}">
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

        <br>
        <div class="block">
            @can(getPermissionKey($moduleKey, 'update_status', false))
                <a class="btn btn-info" href="{{ route($baseRouteName . 'export', request()->all()) }}"><i class="fa fa-file"></i>{{ $trans_text['export'] }}</a>
            @endcan
            @include('admin::includes.success')
            @if(count($allData) === 0)
                <br><h3 class="text-center">@lang('admin.result_not_found')</h3><br>
            @else
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th>{{ $trans_text['id'] }}</th>
                            <th> {{ $trans_text['company'] }}</th>
                            <th> {{ $trans_text['name'] }}</th>
                            <th> {{ $trans_text['email'] }}</th>
                            <th> {{ $trans_text['phone'] }}</th>
                            <th width="10%" class="text-center">@lang('admin.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <a href="{{ route('admin.company.show',[$item->company->id]) }}" target="_blank">
                                        {{ $item->company->title }}
                                    </a>
                                </td>
                                <td>{!! $item->name !!}</td>
                                <td>{!! $item->email !!}</td>
                                <td>{!! $item->phone !!}</td>
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
