@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $item->id ])
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
                            <a href="{{ route($baseRouteName . 'edit', $item->id) }}" class="btn btn-primary"><i class="el-icon-edit"></i> {{ $trans_text['edit'] }}</a>
                        </div>
                    @endcan
                </div>
                <br>
                <div class="block">
                    <div class="row">
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['company'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <a href="{{ route('admin.company.show',[$item->company->id]) }}" target="_blank">
                                    {{ $item->company->title }}
                                </a>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['name'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{{ $item->name }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['email'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{!! $item->email !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['phone'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{!! $item->phone !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['role'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{!! $item->role !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['specialty'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{!! $item->specialty !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

