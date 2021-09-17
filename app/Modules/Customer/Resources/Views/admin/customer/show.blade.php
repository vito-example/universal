@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $item['id'] ])
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
                            <label class="col-md-3 control-label">{{ $trans_text['name'] }}</label>
                            <div class="col-md-9 uppercase-medium">
                                <span>{{ $item['name'] }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['surname'] }}</label>
                            <div class="col-md-9 uppercase-medium">
                                <span>{!! $item['surname'] !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['phone_number'] }}</label>
                            <div class="col-md-9 uppercase-medium">
                                <span>{{ $item['phone_number'] }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['email'] }}</label>
                            <div class="col-md-9 uppercase-medium">
                                <span>{!! $item['email'] !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-3 control-label">{{ $trans_text['profile_photo_path'] }}</label>
                            <div class="col-md-9 uppercase-medium">
                                @if(!empty($item['profile_photo_url']))
                                    <a href="{{ $item['profile_photo_url'] }}" target="_blank">
                                        <img width="300" height="200" src="{{ $item['profile_photo_url'] }}">
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if(!empty($item['companies']) && count($item['companies']))
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label">{{ $trans_text['companies'] }}</label>
                                <div class="col-md-10 uppercase-medium">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ $trans_text['company_title'] }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($item['companies'] as $companyMember)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.company.show',[$companyMember->company_id]) }}" target="_blank">
                                                        {{ $companyMember->company->title }}
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

