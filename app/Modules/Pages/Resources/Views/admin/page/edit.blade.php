@extends('admin::layouts.admin')

@section('main')

    <!-- Page content -->
    <div id="page-content">

        <!-- Statistics Widgets Header -->
    @include('admin::includes.header-section', ['name'   => $data['trans_text']['edit'] ])
    <!-- END Statistics Widgets Header -->

        <!-- Responsive Full Block -->
        <div class="row">
            <div style="padding: 0 15px 0px 0px;">

                <div class="back-botton" style="text-align: right;margin-bottom: 15px;">
                </div>

                <page-meta-form
                    :editor_config="{{ json_encode($data['editor_config']) }}"
                    :type="'{{ $data['type'] }}'"
                    :get-save-data-route="'{{ $data['routes']['create_form_data'] }}'">
                </page-meta-form>

            </div>
        </div>
        <!-- END Responsive Full Block -->

    </div>
    <!-- END Page Content -->


@endsection
