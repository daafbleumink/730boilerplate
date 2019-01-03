<?php 
/*
========
CSV Page
========
*/

function vasteplant_add_csv_page(){

    //Maakt CSV Upload admin pagina aan
    add_menu_page('CSV Upload', 'Upload CSV', 'manage_options', 'vastepland-csv-upload', 'vasteplant_csv_create_page', 'dashicons-palmtree', 110);

    //Maakt CSV Upload admin sub pagina's aan (optioneel)
    add_submenu_page('vastepland-csv-upload', 'CSV Upload Settings', 'General', 'manage_options', 'vasteplant-csv-upload-settings', 'vasteplant_csv_settings_page');
}

add_action('admin_menu', 'vasteplant_add_csv_page');

//Maakt Vasteplant CSV Upload pagina aan
function vasteplant_csv_create_page() {
    require_once( get_template_directory() . '/template_parts/upload-csv.php');
}

//Maakt Vasteplant CSV Upload Settings pagina aan
function vasteplant_csv_settings_page() {
    echo'<h1>Vasteplant CSV Settings</h1>';
}
