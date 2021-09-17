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
                            <a href="{{ route($baseRouteName . 'edit', $item->id) }}" class="btn btn-primary"><i
                                    class="el-icon-edit"></i> {{ $trans_text['edit'] }}</a>
                        </div>
                    @endcan
                </div>
                <br>
                <div class="block">
                    <div class="row">
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['full_name'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{{ $item->full_name }}</span>
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

                        @if(!empty($item['directions']))
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10 uppercase-medium">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ $trans_text['lecturer_directions'] }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                @foreach($item->directions as $direction)
                                                    <li>
                                                        <a href="{{ route('admin.direction.edit',[$direction->id]) }}"
                                                           target="_blank">
                                                            {{ $direction->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </td>
                                        </tr>
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

