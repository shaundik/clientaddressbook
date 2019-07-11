<?php

//FUNCTIONS.PHP

//clean the form data to prevent injections

/*Built In functions used
    trim();
    stripslashes();
    htmlspecialchars();
    strip_tags();
    str_replace();
*/
function validateFormData($formData)
{
    $formData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array( '(' , ')' ), '', $formData ) ),ENT_QUOTES ) ) );
    return $formData;
}



?>