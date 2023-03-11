import {reactive} from "vue";

const toast = reactive({
    items: [],
    position: 'top-right',
    timer: 5000,
    canClose: false,
    show: function (message, type = 'default', autoHide = true) {
        this.items.unshift({
            key: Symbol(),
            message: message,
            duration: this.timer,
            canClose:  type !== 'default' && this.canClose,
            hasIcon: type !== 'default',
            autoHide,
            type
        });
    },
    success: function (message, autoHide = true) {
        this.show(message, 'success', autoHide)
    },
    warning: function (message, autoHide = true) {
        this.show(message, 'warning', autoHide)
    },
    info: function (message, autoHide = true) {
        this.show(message, 'info', autoHide)
    },
    error: function (message, autoHide = true) {
        this.show(message, 'danger', autoHide)
    },
    remove: function (item) {
        if (typeof item == "number") {
            this.items.splice(item, 1);
        } else if (typeof item == "object") {
            this.items.splice(this.items.indexOf(item), 1);
        }
    },
    /**
     * Set the Placement / Position for toasts
     *
     * @param [placement] can be any from [ top-right, bottom-right, top-left, bottom-left ] | Default: 'top-right'
     */
    placement: function (placement){
        this.position = placement;
        return this;
    },
    /**
     * Set the Placement / Position for toasts to `top-right`
     */
    topRight: function (){
        this.position = 'top-right';
        return this;
    },
    /**
     * Set the Placement / Position for toasts to `bottom-right`
     */
    bottomRight: function (){
        this.position = 'bottom-right';
        return this;
    },
    /**
     * Set the Placement / Position for toasts to `top-left`
     */
    topLeft: function (){
        this.position = 'top-left';
        return this;
    },
    /**
     * Set the Placement / Position for toasts to `bottom-left`
     */
    bottomLeft: function (){
        this.position = 'bottom-left';
        return this;
    },
    /**
     * Set the Placement / Position for toasts to `top-center`
     */
    topCenter: function (){
        this.position = 'top-center';
        return this;
    },
    /**
     * Set the Placement / Position for toasts to `bottom-center`
     */
    bottomCenter: function (){
        this.position = 'bottom-center';
        return this;
    },
    /**
     * Set the auto close delay for each toast item
     * It can be different for each toast
     *
     * @param [delay] in milliseconds | Default: 3000
     */
    delay: function (delay){
        this.timer = delay;
        return this;
    },
    closable: function () {
        this.canClose = true;
        return this;
    }
});

export default toast;
