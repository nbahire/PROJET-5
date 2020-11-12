/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $, { data } from 'jquery';
import 'bootstrap';
import 'popper.js';
import './js/Comment.jsx'

$('.custom-file-input').on('change', function (e) {
    let inputFile = e.currentTarget;
    $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
})

// Reply box popup JS
$(".reply-popup").on('click', function () {
    $(".reply-box").toggle();
    $(".add-com").toggle();

});


