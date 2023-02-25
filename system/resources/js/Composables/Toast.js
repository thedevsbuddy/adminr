import {reactive} from "vue";

const toast = reactive({
    items: [],
    add: function (message, type = 'info', autoHide = true) {
        this.items.unshift({
            key: Symbol(),
            message: message,
            autoHide,
            type
        });
    },
    success: function (message, autoHide = true) {
        this.add(message, 'success', autoHide)
    },
    warning: function (message, autoHide = true) {
        this.add(message, 'warning', autoHide)
    },
    info: function (message, autoHide = true) {
        this.add(message, 'info', autoHide)
    },
    danger: function (message, autoHide = true) {
        this.add(message, 'danger', autoHide)
    },
    remove: function (item) {
        if (typeof item == "number") {
            this.items.splice(item, 1);
        } else if (typeof item == "object") {
            this.items.splice(this.items.indexOf(item), 1);
        }
    },
});


export default toast;
