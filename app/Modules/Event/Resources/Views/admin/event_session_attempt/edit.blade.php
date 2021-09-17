@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $data['trans_text']['create_session'] ])
        <div class="row">
            <div class="col-xs-12">
                <div class="back-botton" style="text-align: right;margin-bottom: 15px;">
                    <a href="{{ route($data['baseRouteName'] . 'index') }}" size="medium" class="el-button el-button--text">
                        <i class="el-icon-back" style="margin-right: 6px;"></i><span>back to list</span>
                    </a>
                </div>
                <event-session-attempt-create-form
                    :event-session-attempt="{{ json_encode($data['event_session_attempt']) }}"
                    :save-route="'{{ $data['routes']['store'] }}'"
                    :lang="'{{ json_encode($data['trans_text']) }}'"
                    :options="'{{ json_encode($data['options']) }}'"
                >
                </event-session-attempt-create-form>
            </div>
        </div>
    </div>
@endsection

