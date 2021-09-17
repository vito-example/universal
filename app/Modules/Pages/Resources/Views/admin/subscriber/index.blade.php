@extends('admin::layouts.admin')

@section('main')
    <!-- Page content -->
    <div id="page-content">
        <!-- Statistics Widgets Header -->
    @include('admin::includes.header-section', ['name'   => $trans_text['index'] ])
    <!-- END Statistics Widgets Header -->
        <br>
        <div class="block">

            <div class="table-options clearfix">
                <div class="btn-group btn-group-sm pull-left">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route($baseRouteName . 'export') }}" class="btn btn-primary"><i class="el-icon-document"></i> {{ $trans_text['export'] }}</a>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin::includes.success')

            <!-- Responsive Full Content -->
            @if(count($allData) == 0)
                <br><h3 class="text-center">@lang('admin.result_not_found')</h3><br>
            @else
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th> {{ $trans_text['email'] }}</th>
                            <th> {{ $trans_text['fist_name'] }}</th>
                            <th> {{ $trans_text['last_name'] }}</th>
                            <th> {{ $trans_text['is_subscribed'] }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allData as $item)
                            <tr>
                                <td>{!! $item->email !!}</td>
                                <td>{!! $item->name !!}</td>
                                <td>{!! $item->last_name !!}</td>
                                <td>{!! $item->is_subscribed == 1 ? 'Yes' : 'No' !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <per-page-component :url="'{{ request()->url() }}'" :active="{{ request()->get('limit') ?: $per_page }}"></per-page-component>
            @include('admin::includes.paginate', ['data' => $allData ])

            <br>
            <!-- END Responsive Full Content -->
        </div>
        <!-- END Responsive Full Block -->

    </div>
    <!-- END Page Content -->
@endsection
