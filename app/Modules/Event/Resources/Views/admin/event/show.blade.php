@extends('admin::layouts.admin')
@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $item['title'] ])
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
                        </div>
                    @endcan
                </div>
                <br>
                <div class="block">
                    <div class="row">
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['title'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{{ $item['title'] }}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['description'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{!! $item['description'] !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['syllabus'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{!! $item['syllabus'] !!}</span>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['profile_image'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <a href="{{ $item['profile_image_url'] }}" target="_blank">
                                    <img width="300" height="200" src="{{ $item['profile_image_url'] }}">
                                </a>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['event_url'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <a href="{{ $item['event_url'] }}" target="_blank"><span>{{ $item['event_url'] }}</span></a>
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['form'] }}</label>
                            @if($item['form'] === \App\Modules\Event\Http\Resources\Event\EventFormOptions::FORM_ONLINE)
                                <div class="col-md-10 uppercase-medium">
                                    {{$trans_text['form_online']}}
                                </div>
                            @else
                                <div class="col-md-10 uppercase-medium">
                                    {{$trans_text['form_offline']}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['duration'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                {{$item['duration']}}
                            </div>
                        </div>
                        <div class="form-group dashed col-md-12">
                            <label class="col-md-2 control-label">{{ $trans_text['price_options'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <span>{{ $item['price_option_label'] }}</span>
                            </div>
                        </div>
                        @if(!empty($item['price_for_all']))
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label">{{ $trans_text['price'] }}</label>
                                <div class="col-md-10 uppercase-medium">
                                    <span>{{ $item['price_for_all'] }}</span>
                                </div>
                            </div>
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label">{{ $trans_text['price_person_total'] }}</label>
                                <div class="col-md-10 uppercase-medium">
                                    <span>{{ $item['price_person_total'] }}</span>
                                </div>
                            </div>
                        @endif
                        @if($item['type'] === \App\Modules\Event\Http\Resources\Event\EventTypeOptions::TYPE_PLANNED)
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label">{{ $trans_text['type'] }}</label>
                                <div class="col-md-10 uppercase-medium">
                                    <span>{{ $trans_text['type_planed'] }}</span>
                                </div>
                            </div>
                        @else
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label">{{ $trans_text['type'] }}</label>
                                <div class="col-md-10 uppercase-medium">
                                    <span>{{ $trans_text['type_request'] }}</span>
                                </div>
                            </div>
                        @endif
                        @if(!empty($item['sessions']))
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10 uppercase-medium">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ $trans_text['training_sessions'] }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>
                                                {{$trans_text['start_date']}}
                                            </th>
                                            <th>
                                                {{$trans_text['end_date']}}
                                            </th>
                                            <th>
                                                {{$trans_text['timezone']}}
                                            </th>
                                        </tr>
                                        @foreach($item['sessions'] as $session)
                                            <tr>
                                                <td>
                                                    {{\Carbon\Carbon::parse($session->start_date)->toDateTimeString()}}
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($session->end_date)->toDateTimeString()}}
                                                </td>
                                                <td>
                                                    {{$session->timezone}}
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if(!empty($item['lecturers']))
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10 uppercase-medium">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ $trans_text['training_lecturers'] }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                @foreach($item['lecturers'] as $lecturer)
                                                    <li>
                                                        <a href="{{ route('admin.lecturer.edit',[$lecturer->id]) }}"
                                                           target="_blank">
                                                            {{ $lecturer->full_name }}
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

                        @if(!empty($item['directions']))
                            <div class="form-group dashed col-md-12">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10 uppercase-medium">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ $trans_text['training_directions'] }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                @foreach($item['directions'] as $direction)
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

