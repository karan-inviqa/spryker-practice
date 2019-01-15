/**
 * Copyright (c) 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

'use strict';

require('ZedGui');


/**
 * get generated address form
 * @type {Mixed|jQuery|jQuery|HTMLElement}
 */
var addressForm = $('#addresses_addresses');
var formHtml = addressForm.data('prototype');
var removeButton = '<input type="button" id="remove-address-__name__" class="btn hide btn-primary btn-remove" value="Remove address" />';

/**
 * Add new address fieldset
 *
 * @param count
 * @param addressForm
 * @param formHtml
 * @param removeButtonHtml
 */
var addNewAddress = function (count, addressForm, formHtml, removeButton) {
    var addAddressHtml = $.parseHTML(formHtml.replace(/__name__/g, count));
    addressForm.append(addAddressHtml);
};

/**
 * Remove selected address fieldset
 *
 * @param addressId
 */
var removeAddress = function (addressId) {
    console.log(addressId);
};

/**
 * process while document is ready
 */
$(document).ready(function () {
    /**
     * add new address form with count 1
     * @type {number}
     */
    var count = 1;
    $('#add-address').click(function () {
        addNewAddress(count, addressForm, formHtml, removeButton);
        count++;
    });
    $('#remove-address').click(function () {
        var addressId = $(this).attr('id');
        removeAddress(addressId);
    });
});