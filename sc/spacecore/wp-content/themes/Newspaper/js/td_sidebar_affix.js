/**
 * Created by ra on 9/26/2014.
 * copyright tagDiv / Electronista SRL
 */


"use strict";

var td_sidebar_affix = {


    has_items: false, // this class will only work when this flag is true. If we don't have any items, all the calculations on scroll will be disabled by this flag

    items: [], //the array that has all the items

    // one item object (instantiable)
    item: function() {
        this.jquery_obj = ''; //find the item easily for animation ??
        this.bottom_top = 0;  //distance from the bottom of the dom element to top



    },

    init: function init() {

    }
};