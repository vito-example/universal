@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $trans_text['calendar'] ])
        <div class="row">
            <div class="col-xs-12">
                <div class="back-botton" style="text-align: right;margin-bottom: 15px;">
                    <a href="{{ route($baseRouteName . 'index') }}" size="medium" class="el-button el-button--text">
                        <i class="el-icon-back" style="margin-right: 6px;"></i><span>back to list</span>
                    </a>
                </div>
                <calendar-data
                    :show-route="'{{ $routes['show'] }}'"
                    :get-data-route="'{{ $routes['calendar'] }}'">
                </calendar-data>
            </div>
        </div>
    </div>
@endsection
