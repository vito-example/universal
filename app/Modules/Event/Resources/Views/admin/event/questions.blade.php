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
                            <a href="{{ route($baseRouteName . 'edit', $item['id']) }}" class="btn btn-primary"><i class="el-icon-edit"></i> {{ $trans_text['edit'] }}</a>
                        </div>
                    @endcan
                </div>
                <br>
                <div class="block">
                    <div class="row">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ $trans_text['question_user'] }}</th>
                                <th>{{ $trans_text['question_content'] }}</th>
                                <th>{{ $trans_text['question_created_at'] }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{!! $question['customer']['name'] !!} {!! $question['customer']['surname'] !!}</td>
                                    <td>{!! $question['content'] !!}</td>
                                    <td>{!! $question['created_at'] !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

