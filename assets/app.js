/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


// any CSS you import will output into a single css file (app.css in this case)

import './styles/app.css';
import './styles/main.css';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
//jquery
import 'jquery';
const $ = require('jquery');
global.$ = global.jQuery = $ ;
// datatable

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-bs5';
$(document).ready(function() {
    $('#table-admin').DataTable(
        {
            "info": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        }
    );
} );

// filterizer
import Filterizr from "filterizr";
const option = {/* check next step available option*/};
const filterizr = new Filterizr('.filter-container', option);






// start the Stimulus application
import './bootstrap';


