<ul class="sidebar-nav">
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
