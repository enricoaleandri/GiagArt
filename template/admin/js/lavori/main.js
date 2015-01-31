/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#uploadimages').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: host+'/lavori/uploadimages/'
    });
    // Initialize the jQuery File Upload widget:
    $('#uploadcover').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: host+'/lavori/uploadcover/',
        uploadTemplateId : "template-upload-cover"
    });


    // Load existing files:
    $('#uploadimages').addClass('fileupload-processing');


    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#uploadimages').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#uploadimages')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, $.Event('done'), {result: result});
    });


    $('#uploadcover').addClass('fileupload-processing');

    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#uploadcover').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#uploadcover')[0]
    }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });

});
