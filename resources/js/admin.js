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
    'doctor-type-create-form': require('@/base/admin_pages/doctor_type/CreateForm').default,
    'activity-create-form': require('@/base/admin_pages/activity/CreateForm').default,
    'direction-create-form': require('@/base/admin_pages/direction/CreateForm').default,
    'lecturer-create-form': require('@/base/admin_pages/lecturer/CreateForm').default,
    'company-activity-create-form': require('@/base/admin_pages/company_activity/CreateForm').default,
    'company-create-form': require('@/base/admin_pages/company/CreateForm').default,
    'company-employee-create-form': require('@/base/admin_pages/company_employee/CreateForm').default,
    'citizenship-create-form': require('@/base/admin_pages/citizenship/CreateForm').default,
    'event-language-create-form': require('@/base/admin_pages/event_language/CreateForm').default,
    'event-create-form': require('@/base/admin_pages/event/CreateForm').default,
    'event-session-create-form': require('@/base/admin_pages/event_session/CreateForm').default,
    'event-session-add-attendees-form': require('@/base/admin_pages/event_session/AddAttendeesForm').default,
    'calendar-data': require('@/base/admin_pages/event/CalendarData').default,
    'event-status-update': require('@/base/admin_pages/event/StatusUpdateComponent').default,
    'event-session-status-update': require('@/base/admin_pages/event_session/StatusUpdateComponent').default,
    'session-request-create-form': require('@/base/admin_pages/session_request/CreateForm').default,
    'event-session-attempt-create-form': require('@/base/admin_pages/event_session_attempt/CreateForm').default,
    'session-request-status-update': require('@/base/admin_pages/session_request/StatusUpdateComponent').default,
    'blog-create-form': require('@/base/admin_pages/blog/CreateForm').default,
    'customer-edit-form': require('@/base/admin_pages/customer/CreateForm').default,
    'reviews-table': require('@/base/admin_pages/reviews/Index').default,
}

createApp({components: components})
    .use(ElementPlus, {locale: elementLocale})
    .use(CKEditor)
    .mount(el);
