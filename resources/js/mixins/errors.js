export default {
    methods: {
        getFromResponse(errors) {
            console.log(errors.response)
            return errors.response.data?.errors || {'server': [errors.response.data.message]};
        },
        openNotification(error) {
            window.$oruga.notification.open({
                duration: 15000,
                message: error,
                position: 'bottom-right',
                variant: 'danger',
                closable: true
            })
        },
        openResponseNotification(errors) {
            Object.values(this.getFromResponse(errors)).forEach((errorsArray) => {
                errorsArray.forEach((error) => {
                    this.openNotification(error);
                })
            })
        }
    }
}
