"use strict";

// for show password
let createpassword = (type, ele) => {
    var ele = $(ele);
    var input = ele.closest("div").find(`#${type}`);
    if (input.attr("type") == "password") {
        input.attr("type", "text");
        ele.find("i").removeClass().addClass("ri-eye-off-line align-middle");
    } else {
        input.attr("type", "password");
        ele.find("i").removeClass().addClass("ri-eye-line align-middle");
    }
};
