/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
//require('../css/app.css');
import '../css/app.css';
import '../css/global.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

// loads the jquery package from cnode_modules
//var $ = require('jquery');
import $ from 'jquery';

import 'bootstrap';
import 'select2';
import 'chosen-js';


// import the function from style.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
//var style = require('./style');
import styles from './styles';

$(document).ready(function() {
    $('.multiselect').select2();
    $('.chzn').chosen();
})

$(function() {
    $('.multiselect').select2();
    $(".chzn").chosen();
});