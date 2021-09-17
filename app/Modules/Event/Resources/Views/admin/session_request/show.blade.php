@extends('admin::layouts.admin')
@section('main')
    <div id="page-content">

        @include('admin::includes.header-section', ['name'   => $item->user->full_name ])
        <div class="row">
            <div class="col-xs-12">
                <div class="back-botton" style="text-align: right;margin-bottom: 15px;">
                    <a href="{{ route($baseRouteName . 'index') }}" size="medium" class="el-button el-button--text">
                        <i class="el-icon-back" style="margin-right: 6px;"></i><span>back to list</span>
                    </a>
                </div>
                <div class="row">
                    @can(getPermissionKey($moduleKey, 'update', true) && !$item->session)
                        <div class="col-md-6">
                            <a href="{{ route($baseRouteName . 'edit', $item['id']) }}" class="btn btn-primary"><i
                                        class="el-icon-edit"></i> {{ $trans_text['edit'] }}</a>
                        </div>
                    @endcan
                </div>
                <br>
                <div class="block">
                    <div class="row">
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['user_name'] }}</label>
                            <div class="col-md-9-medium">
                                <a href="{{ route('admin.customer.' . 'show_profile', $item->user->id) }}"
                                   target="_blank">
                                    {!! $item->user->full_name !!}
                                </a>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['training_title'] }}</label>
                            <div class="col-md-9-medium">
                                <a href="{{route('admin.event.show',$item->event->id)}}" target="_blank">
                                    {!! $item->event->title !!}
                                </a>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['session'] }}</label>
                            <div class="col-md-9-medium">
                                @if($item->session)
                                    <a href="{{route('admin.event_session.show',$item->session_id)}}" target="_blank">
                                        {!! $item->session->id !!}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['max_person'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->max_person !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['date'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->date !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['created_at'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->created_at !!}</span>
                            </div>
                        </div>

                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['status'] }}</label>
                            @if($item['form'] === \App\Modules\Event\Http\Resources\EventSessionRequest\EventSessionRequestStatusOptions::STATUS_SUCCESS)
                                <div class="col-md-9-medium ">
                                    {{$trans_text['status_success']}}
                                </div>
                            @elseif($item['form'] === \App\Modules\Event\Http\Resources\EventSessionRequest\EventSessionRequestStatusOptions::STATUS_DENIED)
                                <div class="col-md-9-medium">
                                    {{$trans_text['status_denied']}}
                                </div>
                            @else
                                <div class="col-md-9-medium">
                                    {{$trans_text['status_pending']}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

