window.axios = require('axios');
window._ = require('lodash');


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import {createApp} from 'vue'

const app = createApp({});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default));

app.mount('#app');

$(document).on('click', '.delete-item', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    let deleteForm = $(this).data('form');
    let message = $(this).data('message');
    let title = $(this).data('title');
    let icon = $(this).data('icon');
    let confirm = $(this).data('confirm');
    Swal.fire({
        title: title ?? 'Are you sure?',
        text: message ?? "You won't be able to revert this!",
        icon: icon ?? 'warning',
        showCancelButton: true,
        confirmButtonColor: '#292a3d',
        cancelButtonColor: '#d33',
        confirmButtonText: confirm ?? 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            if (url == '#' || url == 'javascript:void(0)' || url == 'javascript') {
                $('#' + deleteForm).submit();
            } else {
                window.location.href = url;
            }
        }
    })

});

$(document).on('submit', '.delete-form', function (e) {
    e.preventDefault();
    let message = $(this).data('message');
    let title = $(this).data('title');
    let icon = $(this).data('icon');
    let confirm = $(this).data('confirm');
    Swal.fire({
        title: title ?? 'Are you sure?',
        text: message ?? "You won't be able to revert this!",
        icon: icon ?? 'warning',
        showCancelButton: true,
        confirmButtonColor: '#292a3d',
        cancelButtonColor: '#d33',
        confirmButtonText: confirm ?? 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit();
        }
    })

});

$(document).on('change', '.file-input', function () {
    readFile(this);
});

function readFile(input) {
    let imageMimes = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp', 'svg'];

    let ext = $('#' + input.getAttribute('id')).val().split('.').pop().toLowerCase();

    if (input.files.length === 1) {
        if (!arrayContains(ext, imageMimes)) {
            console.log($('#' + input.getAttribute('id')).val());
            // Not an image
            $('#' + input.getAttribute('id')).parent().find('.file-input-label').html(input.files[0].name.substring(0, 24) + '___.' + ext);
        } else {
            // Image
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#' + input.getAttribute('id')).closest('.custom-file-button')
                    .css('background-image', 'url("' + e.target.result + '")')
                    .find('.custom-file-content span')
                    .hide();
            };
            reader.readAsDataURL(input.files[0]);
        }
    } else if (input.files.length > 1) {
        $('#' + input.getAttribute('id')).closest('.custom-file-button')
            .css('background-image', 'none')
            .find('.custom-file-content span')
            .show();
        $('#' + input.getAttribute('id')).closest('.custom-file-button')
            .find('.file-input-label')
            .html(input.files.length + ' Files selected');
    }
}

function arrayContains(value, arr) {
    let result = false;

    for (let i = 0; i < arr.length; i++) {
        let name = arr[i];
        if (name === value) {
            result = true;
            break;
        }
    }

    return result;
}


function toggleSidebar(action) {
    if (action === 'minimize') {
        $('#sidebar').addClass('c-sidebar-minimized');
    } else {
        $('#sidebar').removeClass('c-sidebar-minimized');
    }
}

$(window).resize(function () {
    checkWindow();
});
checkWindow();

function checkWindow() {
    if (window.innerWidth < 1200) {
        toggleSidebar('minimize');
    } else {
        toggleSidebar('maximize');
    }
}


$(window).on('resize', function () {
    $('.select2').each(function () {
        $(this).select2();
    });
});
