@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $data['trans_text']['addAttends'] ])
        <div class="row">
            <div class="col-xs-12">
                <div class="back-botton" style="text-align: right;margin-bottom: 15px;">
                    <a href="{{ route($data['baseRouteName'] . 'index') }}" size="medium" class="el-button el-button--text">
                        <i class="el-icon-back" style="margin-right: 6px;"></i><span>back to list</span>
                    </a>
                </div>
                <event-session-add-attendees-form
                    :save-route="'{{ $data['routes']['add_attends'] }}'"
                    :search-route="'{{ $data['routes']['search_attends'] }}'"
                    :attendees="'{{ $data['attendees'] }}'"
                    :lang="'{{ json_encode($data['trans_text']) }}'"
                    :options-attendees="'{{ $data['options_attendees'] }}'">
                </event-session-add-attendees-form>
            </div>
        </div>
    </div>
@endsection

