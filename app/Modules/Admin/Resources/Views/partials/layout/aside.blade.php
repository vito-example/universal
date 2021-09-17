<ul class="sidebar-nav">

    <li class="sidebar-header">
        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title=""
                                                         data-original-title="Filter"></a></span>
        <span class="sidebar-header-title">Training</span>
    </li>
    @can (getPermissionKey('customer', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.customer.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.customer.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.customer.menu')</span></a>
        </li>
    @endif
    @can (getPermissionKey('lecturer', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.lecturer.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.lecturer.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.lecturer.menu')</span></a>
        </li>
    @endif
    @can (getPermissionKey('event', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.event.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.event.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.training.menu')</span></a>
        </li>
    @endif
    @can (getPermissionKey('event_session', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.event_session.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.event_session.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.training_session.menu')</span></a>
        </li>
    @endif
    @can (getPermissionKey('session_request', 'index', true))
        <li
                {!! strpos(request()->route()->getName(), 'admin.session_request.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.session_request.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.session_request.menu')</span></a>
        </li>
    @endif
    @can (getPermissionKey('event_session_attempt', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.event_session_attempt.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.event_session_attempt.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.event_session_attempt.menu')</span></a>
        </li>
    @endif
    @can (getPermissionKey('reviews', 'index', true))
        <li
                {!! strpos(request()->route()->getName(), 'admin.review.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.review.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.review.menu')</span></a>
        </li>
    @endif
    <li class="sidebar-header">
        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title=""
                                                         data-original-title="Filter"></a></span>
        <span class="sidebar-header-title">Company</span>
    </li>
    @can (getPermissionKey('company', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.company.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.company.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.company.menu')</span></a>
        </li>
    @endif
    @can (getPermissionKey('company_employee', 'index', true))
        <li
                {!! strpos(request()->route()->getName(), 'admin.company_employee.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.company_employee.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.company_employee.menu')</span></a>
        </li>
    @endif
    <li class="sidebar-header">
        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title=""
                                                         data-original-title="Filter"></a></span>
        <span class="sidebar-header-title">Pages</span>
    </li>
    @foreach(App\Modules\Pages\Models\Page::getPages() as $pageName)
        <li {!! strpos(request()->route()->getName(), 'admin.page.') !== false && (!empty(request()->route()->parameters()['type']) && request()->route()->parameters()['type'] == $pageName ) ? ' class="active"' : '' !!}>
            <a href="{{route('admin.page.edit', [$pageName])}}"><i
                    class="el-icon-folder-opened sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.'.$pageName.'.menu')</span></a>
        </li>
    @endforeach
    @can (getPermissionKey('blog', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.blog.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.blog.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.blog.menu')</span></a>
        </li>
    @endif

    <li class="sidebar-header">
        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title=""
                                                         data-original-title="Filter"></a></span>
        <span class="sidebar-header-title">Fields</span>
    </li>
    @can (getPermissionKey('direction', 'index', true))
        <li
                {!! strpos(request()->route()->getName(), 'admin.direction.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.direction.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.direction.menu')</span></a>
        </li>
    @endif
{{--    @can (getPermissionKey('doctor_type', 'index', true))--}}
{{--        <li--}}
{{--            {!! strpos(request()->route()->getName(), 'admin.doctor_type.') !== false ? ' class="active"' : '' !!}>--}}
{{--            <a href="{{route('admin.doctor_type.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>--}}
{{--                <span class="sidebar-nav-mini-hide">@lang('admin.doctor_type.menu')</span></a>--}}
{{--        </li>--}}
{{--    @endif--}}
{{--    @can (getPermissionKey('company_activity', 'index', true))--}}
{{--        <li--}}
{{--            {!! strpos(request()->route()->getName(), 'admin.company_activity.') !== false ? ' class="active"' : '' !!}>--}}
{{--            <a href="{{route('admin.company_activity.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>--}}
{{--                <span class="sidebar-nav-mini-hide">@lang('admin.company_activity.menu')</span></a>--}}
{{--        </li>--}}
{{--    @endif--}}
{{--    @can (getPermissionKey('citizenship', 'index', true))--}}
{{--        <li--}}
{{--            {!! strpos(request()->route()->getName(), 'admin.citizenship.') !== false ? ' class="active"' : '' !!}>--}}
{{--            <a href="{{route('admin.citizenship.index')}}"><i class="el-icon-link sidebar-nav-icon"></i>--}}
{{--                <span class="sidebar-nav-mini-hide">@lang('admin.citizenship.menu')</span></a>--}}
{{--        </li>--}}
{{--    @endif--}}

    <li class="sidebar-header">
        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title=""
                                                         data-original-title="Filter"></a></span>
        <span class="sidebar-header-title">Texts</span>
    </li>
    @can ( getPermissionKey('text', 'create', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.text.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.text.index')}}"><i class="el-icon-scissors sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.text.menu')</span></a>
        </li>
    @endif
    <li class="sidebar-header">
        <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title=""
                                                         data-original-title="Filter"></a></span>
        <span class="sidebar-header-title">Settings</span>
    </li>

    @can ( getPermissionKey('user', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.user.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.user.index')}}"><i class="el-icon-user sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.user.menu')</span></a>
        </li>

    @endif

    @can ( getPermissionKey('role', 'index', true))
        <li
            {!! strpos(request()->route()->getName(), 'admin.role.') !== false ? ' class="active"' : '' !!}>
            <a href="{{route('admin.role.index')}}"><i class="el-icon-thumb sidebar-nav-icon"></i>
                <span class="sidebar-nav-mini-hide">@lang('admin.role.menu')</span></a>
        </li>

    @endif


</ul>
