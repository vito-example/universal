import { ElNotification } from 'element-plus';

export const notifications = (request) => {

    if (request.status == 'success') {
        ElNotification.success({
            title: '',
            message: request.message,
            offset: 100,
        });
    } else if(request.status == 'error') {
        ElNotification.error({
            title: '',
            message: request.message,
            offset: 100,
        });
    }

}
