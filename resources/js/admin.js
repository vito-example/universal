import {createApp, h} from "vue";

require('./bootstrap');

import ElementPlus from 'element-plus';
import 'element-plus/lib/theme-chalk/index.css';
import CKEditor from '@ckeditor/ckeditor5-vue';
import elementLocale from 'element-plus/lib/locale/lang/en';

const el = document.getElementById('admin');

var components = {
    //Base Components
    'admin-text-list-save': require('./base/admin/text/page/TextListSave').default,
    'delete-component': require('./base/components/admin/Delete').default,
    'status-component': require('./base/components/admin/Status').default,
    'admin-user-save-component': require('./base/admin/user/page/SaveComponent').default,
    'admin-profile-save-component': require('./base/admin/user/page/ProfileSaveComponent').default,
    'admin-role-save-component': require('./base/admin/role/page/SaveComponent').default,
    'checkbox-list-component': require('./base/components/admin/checkboxList').default,
    'checked-all-component': require('./base/components/admin/checkedAll').default,
    'per-page-component': require('./base/components/admin/perPage').default,
    'save-config': require('./base/components/admin/SaveConfig').default,
    'admin-select-component': require('./base/components/admin/SelectComponent').default,
    'admin-date-component': require('./base/components/admin/DateComponent').default,
    'page-meta-form': require('./base/admin_pages/page_meta/CreateFormPage').default,
    // Page Modules
    'blog-create-form': require('@/base/admin_pages/blog/CreateForm').default,
    'project-create-form': require('@/base/admin_pages/project/CreateForm').default,
    'service-create-form': require('@/base/admin_pages/service/CreateForm').default,
    'team-create-form': require('@/base/admin_pages/team/CreateForm').default,
}

createApp({components: components})
    .use(ElementPlus, {locale: elementLocale})
    .use(CKEditor)
    .mount(el);
