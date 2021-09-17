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
                            <label class="col-md-2 control-label">{{ $trans_text['title'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{{ $item->title }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['identify_id'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{{ $item->identify_id }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['address'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{{ $item->address }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['description'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{!! $item->description !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['profile_image'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                @if($profile_image)
                                    <a href="{{ $profile_image }}" target="_blank">
                                        <img width="300" height="200" src="{{ $profile_image }}">
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if(!empty($item['ownerMembers']))
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label">{{ $trans_text['company_owners'] }}</label>
                                <div class="col-md-10 uppercase-medium">
                                    <table class="table">
                                        <tbody>
                                        @foreach($item->ownerMembers as $member)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.customer.show_profile',[$member->user_id]) }}" target="_blank">
                                                        {{ $member->user->full_name }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

