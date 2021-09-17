@extends('admin::layouts.admin')
@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $item->event->title ])
        <div class="row">
            <div class="col-xs-12">
                <div class="back-botton" style="text-align: right;margin-bottom: 15px;">
                    <a href="{{ route($baseRouteName . 'index') }}" size="medium" class="el-button el-button--text">
                        <i class="el-icon-back" style="margin-right: 6px;"></i><span>back to list</span>
                    </a>
                </div>
                <div class="row">
                    @can(getPermissionKey($moduleKey, 'update', true))
                        <div class="col-md-6">
                            <a href="{{ route($baseRouteName . 'edit', $item['id']) }}" class="btn btn-primary"><i
                                    class="el-icon-edit"></i> {{ $trans_text['edit'] }}</a>

                            <a href="{{ route($baseRouteName . 'get_attends', $item['id']) }}" class="btn btn-primary p-1"><i
                                    class="el-icon-edit"></i> {{ $trans_text['addAttends'] }}</a>
                        </div>
                    @endcan
                </div>
                <br>
                <div class="block">
                    <div class="row">
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['training_title'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{{ $item->event->title }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['max_person'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->max_person !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['register_persons'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->register_personCount !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['start_date'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->start_date !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['end_date'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->end_date !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['timezone'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->timezone !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['price'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->price !!}</span>
                            </div>
                        </div>

                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['status'] }}</label>
                            @if($item['form'] === \App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions::STATUS_ACTIVE)
                                <div class="col-md-9-medium ">
                                    {{$trans_text['status_active']}}
                                </div>
                            @else
                                <div class="col-md-9-medium">
                                    {{$trans_text['status_completed']}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['type'] }}</label>
                            @if($item['form'] === \App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions::SESSION_TYPE_PLANNED)
                                <div class="col-md-9-medium ">
                                    {{$trans_text['type_planed']}}
                                </div>
                            @else
                                <div class="col-md-9-medium">
                                    {{$trans_text['type_request']}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group dashed col-md-12">
                            <div class="col-md-8 uppercase-medium">
                                <h3>{{$trans_text['attendees_list']}}</h3>

                            </div>
                        </div>
                        @if(!empty($item->userAttendees))
                            <div class="form-group dashed col-md-12">
                                <div class="col-md-8 uppercase-medium">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ $trans_text['user_attendees'] }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>
                                                {{$trans_text['full_name']}}
                                            </th>
                                            <th>
                                                {{$trans_text['phone']}}
                                            </th>
                                            <th>
                                                {{$trans_text['actions']}}
                                            </th>
                                        </tr>
                                        @foreach($item->userAttendees as $user)
                                            <tr>
                                                <td>
                                                    {!! $user->morphable->name !!}
                                                </td>
                                                <td>
                                                    {!! $user->morphable->phone_number !!}
                                                </td>
                                                <td class="text-center">
                                                    @can(getPermissionKey('customer', 'show_profile', false))
                                                        <a class="btn btn-secondary"
                                                           href="{{ route('admin.customer.' . 'show_profile', $user->id) }}"><i
                                                                title="{{ $trans_text['show_profile'] }}"
                                                                class="fa fa-eye"></i></a>
                                                    @endcan
                                                    @can(getPermissionKey('customer', 'update', true))
                                                        @include('admin::includes.actions.edit',['route' => route('admin.customer.edit', [ $user->id ])])
                                                    @endcan
                                                        @can(getPermissionKey('event_session', 'delete_attendees', false))
                                                            <delete-component
                                                                :url="'{{ route($baseRouteName . 'deleteAttendees',[$item->id,$user->id]) }}'"
                                                                :id="{{ $user->id }}"
                                                            ></delete-component>
                                                        @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if(!empty($item->employeeAttendees))
                            <div class="form-group dashed col-md-12">
                                <div class="col-md-8 uppercase-medium">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ $trans_text['employee_attendees'] }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>
                                                {{$trans_text['company']}}
                                            </th>
                                            <th>
                                                {{$trans_text['full_name']}}
                                            </th>
                                            <th>
                                                {{$trans_text['email']}}
                                            </th>
                                            <th>
                                                {{$trans_text['actions']}}
                                            </th>
                                        </tr>
                                        @foreach($item->employeeAttendees as $employee)
                                            <tr>
                                                <td>
                                                    <a href="{{route('admin.company.edit',$employee->morphable->company->id)}}"
                                                       target="_blank">
                                                        {!! $employee->morphable->company->title !!}
                                                    </a>
                                                </td>
                                                <td>
                                                    {!! $employee->morphable->name !!}
                                                </td>
                                                <td>
                                                    {!! $employee->morphable->email !!}
                                                </td>
                                                <td class="text-center">
                                                    @can(getPermissionKey('company_employee', 'show', false))
                                                        <a class="btn btn-secondary"
                                                           href="{{ route('admin.company_employee.show', $employee->morphable->id) }}"><i
                                                                title="{{ $trans_text['show'] }}" class="fa fa-eye"></i></a>
                                                    @endcan
                                                    @can(getPermissionKey('company_employee', 'update', true))
                                                        @include('admin::includes.actions.edit',['route' => route('admin.company_employee.edit', [ $employee->morphable->id ])])
                                                    @endcan
                                                    @can(getPermissionKey('event_session', 'delete_attendees', false))
                                                        <delete-component
                                                            :url="'{{ route($baseRouteName . 'deleteAttendees',[$item->id,$employee->id]) }}'"
                                                            :id="{{ $employee->id }}"
                                                        ></delete-component>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if($item->type === \App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions::SESSION_TYPE_REQUEST)
                            <div class="form-group dashed col-md-12">
                                <div class="col-md-8 uppercase-medium">
                                    <h3>{{$trans_text['can_register_list']}}</h3>
                                </div>
                            </div>
                            @if(!empty($item->userPermissions))
                                <div class="form-group dashed col-md-12">
                                    <div class="col-md-8 uppercase-medium">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{ $trans_text['users_can_registers'] }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th>
                                                    {{$trans_text['full_name']}}
                                                </th>
                                                <th>
                                                    {{$trans_text['phone']}}
                                                </th>
                                                <th>
                                                    {{$trans_text['actions']}}
                                                </th>
                                            </tr>
                                            @foreach($item->userPermissions as $user)
                                                <tr>
                                                    <td>
                                                        {!! $user->name !!}
                                                    </td>
                                                    <td>
                                                        {!! $user->phone_number !!}
                                                    </td>
                                                    <td class="text-center">
                                                        @can(getPermissionKey('customer', 'show_profile', false))
                                                            <a class="btn btn-secondary"
                                                               href="{{ route('admin.customer.' . 'show_profile', $user->id) }}"><i
                                                                        title="{{ $trans_text['show_profile'] }}"
                                                                        class="fa fa-eye"></i></a>
                                                        @endcan
                                                        @can(getPermissionKey('customer', 'update', true))
                                                            @include('admin::includes.actions.edit',['route' => route('admin.customer.edit', [ $user->id ])])
                                                        @endcan
{{--                                                        @can(getPermissionKey('event_session', 'delete_attendees', false))--}}
{{--                                                            <delete-component--}}
{{--                                                                    :url="'{{ route($baseRouteName . 'deleteAttendees',[$item->id,$user->id]) }}'"--}}
{{--                                                                    :id="{{ $user->id }}"--}}
{{--                                                            ></delete-component>--}}
{{--                                                        @endcan--}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

