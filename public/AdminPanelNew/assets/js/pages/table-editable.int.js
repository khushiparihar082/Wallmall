/*
Template Name: Qovex - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Table editable Init Js File
*/

// table edits table

$(function () {
    var pickers = {};
    $('.table-edits tr').editable({
        dropdowns: {
            gender: ['Male', 'Female']
          },
        edit: function (values) {
            $(".edit i", this)
                .removeClass('bx-edit-alt')
                .addClass('bx-save')
                .attr('title', 'Save');
        },
        save: function (values) {
            $(".edit i", this)
                .removeClass('bx-save')
                .addClass('bx-edit-alt')
                .attr('title', 'Edit');

            if (this in pickers) {
                pickers[this].destroy();
                delete pickers[this];
            }
        },
        cancel: function (values) {
            $(".edit i", this)
                .removeClass('fa-save')
                .addClass('fa-pencil-alt')
                .attr('title', 'Edit');

            if (this in pickers) {
                pickers[this].destroy();
                delete pickers[this];
            }
        }
    });
});