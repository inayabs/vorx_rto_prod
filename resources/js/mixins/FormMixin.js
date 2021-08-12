// app colors
const app_color = window.app_color;
const app_addOn = window.add_on;

const Toast = swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
});
import moment from 'moment';
export default {
    data() {
        return {
            fields: {}, errors: {}, loaded: true, action: '', method: '', isModal: '', isValid: false, success: false,
        }
    },
    methods: {
        // Create Method
        create() {
            swal.fire({
                title: 'Please wait...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                   swal.showLoading()
                },
              });
            if (this.loaded) {
                this.loaded = false;
                this.errors = {};
                let datas = ''
                datas = this.fields;
                if (datas.hasOwnProperty('date_created')) {
                    datas.date_created = moment(datas.date_created).format('YYYY-MM-DD');
                }
                axios({
                    method: this.method, url: this.action, data: datas,
                }).then(response => {
                    this.fields = {};
                    this.loaded = true;
                    this.success = true;

                    if (datas.hasOwnProperty('date_created')) {
                        datas.date_created = moment(datas.date_created)._d;
                    }
                    if (this.isModal === "true") {
                        this.$parent.$modal.hide('size-modal');
                    }

                    Toast.fire({
                        // position: 'top-end',
                        type: 'success', title: 'Data is saved successfully', background: '#DCEDC8',
                    });
                }).catch(error => {
                    this.loaded = true;
                    this.success = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: 'Opss.. data was not saved', background: '#ffcdd2',
                        });
                    }
                });

            }
        },
        // Update Method
        update() {
            swal.fire({
                title: 'Please wait...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                   swal.showLoading()
                },
              });
            if (this.loaded) {
                this.loaded = false;
                this.errors = {};
                let datas = ''
                datas = this.fields;
                if (datas.hasOwnProperty('date_created')) {
                    datas.date_created = moment(datas.date_created).format('YYYY-MM-DD');
                }
                // console.log(datas)
                axios({
                    method: this.method, url: this.action, data: datas,
                }).then(response => {
                    this.loaded = true;
                    if (datas.hasOwnProperty('date_created')) {
                        datas.date_created = moment(datas.date_created)._d;
                    }
                    Toast.fire({
                        // position: 'top-end',
                        type: 'success', title: 'Data is updated successfully', background: '#DCEDC8',
                    });
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: 'Opss.. data was not updated', background: '#ffcdd2',
                        });

                    }
                });
            }
        }
    }
}