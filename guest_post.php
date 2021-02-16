<?php

include("config.php");
include("functions.php");

if(isset($_GET['accept_quote'], $_GET['url_key'])){

    $quote_id = intval($_GET['accept_quote']);
    $url_key = mysqli_real_escape_string($mysqli,$_GET['url_key']);

    $sql = mysqli_query($mysqli,"SELECT * FROM quotes
    WHERE quotes.quote_id = $quote_id
    AND quotes.quote_url_key = '$url_key'"
    );

    if(mysqli_num_rows($sql) == 1){
    
        mysqli_query($mysqli,"UPDATE quotes SET quote_status = 'Accepted' WHERE quote_id = $quote_id");

        mysqli_query($mysqli,"INSERT INTO history SET history_date = CURDATE(), history_status = 'Accepted', history_description = 'Client accepted Quote!', history_created_at = NOW(), quote_id = $quote_id, company_id = $company_id");

        $_SESSION['alert_message'] = "Quote Accepted";
        
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }else{
        echo "GTFO!!";
    }

}

if(isset($_GET['decline_quote'], $_GET['url_key'])){

    $quote_id = intval($_GET['decline_quote']);
    $url_key = mysqli_real_escape_string($mysqli,$_GET['url_key']);

    $sql = mysqli_query($mysqli,"SELECT * FROM quotes
    WHERE quotes.quote_id = $quote_id
    AND quotes.quote_url_key = '$url_key'"
    );

    if(mysqli_num_rows($sql) == 1){

        mysqli_query($mysqli,"UPDATE quotes SET quote_status = 'Declined' WHERE quote_id = $quote_id");

        mysqli_query($mysqli,"INSERT INTO history SET history_date = CURDATE(), history_status = 'Declined', history_description = 'Client declined Quote!', history_created_at = NOW(), quote_id = $quote_id, company_id = $company_id");

        $_SESSION['alert_message'] = "Quote Declined";
        
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }else{
        echo "GTFO!!";
    }
    
}

?>  