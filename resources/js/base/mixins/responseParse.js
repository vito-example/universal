import { notifications } from './notifications';

export const responseParse = (response, showSuccessMessage = true) => {
    var type = 'success';
    var message = '';

    if (response.status == 200 && showSuccessMessage){
        type = 'success';
        message = response.data.message;
    } else if(response.code == 422 || response.code == 429) {
        var errorTexts = [];
        for (var element in response.data.errors) {
            errorTexts.push(response.data.errors[element][0]);
        }

        type = 'error';
        message = errorTexts.join(',');

    } else if (response.status == 403) {
        type = 'error';
        message = response.data.message;
    }
    else if(!showSuccessMessage && response.status != 200){
        type = 'error';
        message = response.message;
    } else if(response.status != 200){
        type = 'error';
        message = response.message;
    }

    if (message != '') {
        notifications({
            status: type,
            message: message
        });
    }



}
