<?php 


function validate_fields(string $page_name, array $data) : array {
    global $page_regexes;
    $errors = [];

    // Verifica se la pagina esiste nelle regole
    if (!isset($page_regexes[$page_name])) {
        $errors[] = "Page '$page_name' is not defined.";
        return $errors;
    }

    // Ottieni le regole per la pagina specifica
    $rules = $page_regexes[$page_name];

    foreach ($rules as $field => $regex) {
        // Verifica se il campo esiste nei dati
        if (!isset($data[$field])) {
            $errors[] = "Field '$field' is missing.";
            continue;
        }

        // Verifica se il valore del campo corrisponde all'espressione regolare
        if (!preg_match("$regex", $data[$field])) {
            $errors[] = "Field '$field' is invalid.";
        }
    }

    return $errors;
}