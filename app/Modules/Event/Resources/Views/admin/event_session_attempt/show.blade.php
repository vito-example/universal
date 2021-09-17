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
                <br>
                <div class="block">
                    <div class="row">
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['id'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{{ $item->id }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['user'] }}</label>
                            <div class="col-md-9-medium">
                                <a href="{{ route('admin.customer.' . 'show_profile', $item->user->id) }}"
                                   target="_blank">
                                    {!! $item->user->full_name !!}
                                </a>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['session'] }}</label>
                            <div class="col-md-9-medium">
                                <a href="{{ route('admin.event_session.show', $item->session->id) }}"
                                   target="_blank">
                                    {!! $item->session->start_date !!}
                                </a></div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['person_total'] }}</label>
                            <div class="col-md-9-medium">
                                {!! $item->person_total !!}
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['created_at'] }}</label>
                            <div class="col-md-9-medium">
                                <span>{!! $item->created_at !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

