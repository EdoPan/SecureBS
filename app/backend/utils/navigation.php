<?php



function redirect_to_page(string $page_name, string $query = NULL) : void {
    // Costruisci l'URL per la directory della pagina
    $url = "/app/frontend/" . $page_name . '.php';

    if($page_name === "index"){
        $url = "/app/index.php";
    }
    
    // Se è stata fornita una query, aggiungila all'URL
    if (!is_null($query)) {
        $url .= '?' . $query;
    }
    
    // Ottieni il nome del server e la porta
    $server_name = $_SERVER["SERVER_NAME"];
    $server_port = $_SERVER["SERVER_PORT"];
    
    // Costruisci l'URL completo, inclusa la porta se non è quella predefinita
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $port = ($protocol === 'http' && $server_port != 80) || ($protocol === 'https' && $server_port != 443) ? ":$server_port" : '';
    
    $full_url = "$protocol://$server_name$port$url";
    
    // Effettua il redirect all'URL calcolato
    header("Location: $full_url");
    
    die();
}



//Used as a wrapper to redirect_to_page whenever an error
//query is needed
function redirect_with_message(string $page_name, string $error_message) : void{
    //Urlencode the error message, and call the redirect function
    redirect_to_page($page_name, "msg=".urlencode($error_message));
}