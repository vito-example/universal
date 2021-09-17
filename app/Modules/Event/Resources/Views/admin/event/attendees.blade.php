@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
        @include('admin::includes.header-section', ['name'   => $event->title ])
        <div class="row">
            <div class="col-xs-12">
                <div class="back-botton" style="text-align: right;margin-bottom: 15px;">
                    <a href="{{ route($baseRouteName . 'index') }}" size="medium" class="el-button el-button--text">
                        <i class="el-icon-back" style="margin-right: 6px;"></i><span>back to list</span>
                    </a>
                </div>
            </div>
        </div>
        <br>
        <div class="block">
            @include('admin::includes.success')
            @if(count($allData) == 0)
                <br><h3 class="text-center">@lang('admin.result_not_found')</h3><br>
            @else
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th> {{ $trans_text['attendee_user'] }}</th>
                            <th> {{ $trans_text['attendee_register_date'] }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.customer.show_profile',[$item->user_id]) }}" target="_blank">
                                        {!! $item->user ? $item->user->full_name : '' !!}
                                    </a>
                                </td>
                                <td>
                                    {{ $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @include('admin::includes.paginate', ['data' => $allData ])
            <br>
        </div>
    </div>
@endsection
