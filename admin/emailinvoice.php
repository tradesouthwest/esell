<?php
if( isset( $_POST['submit_tomail'] ))
{
include '../inc/controls.php';

$procid = $_POST['procid'];
$subject = $site_title;

$to = $_POST['email_address'];


    $dateis = date('m-d-Y');
    $prdsprice = $_POST['prdsprice'];
    $prodsfeature = $_POST['prdsfeature'];
    $prod     = $_POST['prod'];
    $prod_ref = $_POST['prod_ref'];
    $bskprice = $_POST['bskprice'];
    $bskqnty  = $_POST['bskqnty'];

    $country        = $_POST['country'];
    $first_name     = $_POST['first_name'];
    $last_name      = $_POST['last_name'];
    $address        = $_POST['address'];
    $city           = $_POST['city'];
    $state          = $_POST['state'];
    $zip_code       = $_POST['zip_code'];
    $phone_number   = $_POST['phone_number'];
    $email_address  = $_POST['email_address'];

    $countryb       = $_POST['countryb'];
    $first_nameb    = $_POST['first_nameb'];
    $last_nameb     = $_POST['last_nameb'];
    $addressb       = $_POST['addressb'];
    $cityb          = $_POST['cityb'];
    $stateb         = $_POST['stateb'];
    $zip_codeb      = $_POST['zip_codeb'];
    $phone_numberb  = $_POST['phone_numberb'];
    $email_addressb = $_POST['email_addressb'];

    $prodcode      = $_POST['prodcode'];
    $proddate     = $_POST['proddate'];
    $paidon      = $_POST['paidon'];
    $deliver    = $_POST['deliver'];
    $sale_id   = $_POST['sale_id'];
    $mem_id   = $_POST['mem_id'];
    $persdata = $_POST['persdata'];
    $stats    = $_POST['stats'];
    $esellopt = $_POST['esellopt'];    //basket id
    $stknumb  = $_POST['stknumb'];
    $feature  = $_POST['feature'];
    $purchtotal  = $_POST['purchtotal'];

$message = '<table border=1 cellpadding=5 cellspacing=0><thead><tr><th colspan=3>
Invoice No.: ' . $esellopt . '' . $prodcode . '</th>';
$message .= '<th colspan=3>Invoice Date: ' . $dateis . '</th></tr></thead>';
$message .= '<tbody><tr><td colspan=3>';
$message .= '<p>' .$site_title .'</p><p>' .$warehouse. '</p></td>';
$message .= '<td colspan=3>';
$message .= '<p>' .$country .'</p><p>' .$first_name. '&nbsp;' .$last_name. '</p>';
$message .= '<p>' .$address . '</p><p>' .$city .'&#44; &nbsp;' . $state . '&nbsp;' . $zip_code . '</p>';
$message .= '<p>' .$phone_number . '</p></td></tr>';
$message .= '<tr><td colspan=6><ul>';
$message .= '<li><h4>' . $prod . '</h4></li><li><span>$</span>' .$prdsprice. ' ' .$prod_ref. '</li>';
$message .= '<li><span>Feature </span>' .$feature. '</li>';
$message .= '<li><span>Quantity </span>' .$bskqnty. '</li>';
$message .= '<li><span>Prod Option </span>' .$feature. '</li>';
$message .= '<li><span>Total Sale: $</span>' .$purchtotal. '</li>';
$message .= '<li><span>Customer eMail: </span>' . $email_address. '</li>';
$message .= '<li><span>Date Requesting: </span>' .$proddate. '</li>';
$message .= '<li><span>Account Number </span>' .$sale_id. '</li>';
$message .= '<li><span>Invoiced Merchandise: </span>' .$array. '</li>';
$message .= '</ul><h4>Itemized Order<h4>';

    $sql = $pdo->query("
        SELECT prod, price FROM esell_basket
        WHERE sale_id = '" . $sale_id . "'
        AND keeps = 0 ");
        if( $sql->rowCount() > 0)
        {
            while($data = $sql->fetch(PDO::FETCH_ASSOC))
            {
$message .= '<p>' . $data['prod'] . ' $' . $data['price'] . '</p>';
            }
        }

$message .= '</td></tr></tbody><tfoot><tr><td colspan=6>' .$site_title .'</td></tr></tfoot>
</table>';

$headers = array(
                "From: tradesouthwest@outlook.com",
                "Reply-To: tradesouthwest@outlook.com",
                "Content-Type: text/html; charset=iso-8859-1",
                "X-Mailer: PHP/" . PHP_VERSION
            );
$headers = implode("\r\n", $headers);

$sendit = mail($to, $subject, $message, $headers);
    if($sendit == true ) {     $msge = "Email has been sent"; }
        else { $msge = "Failed"; }
        redirect("procprods.php?procid={$procid}&msge={$msge}");
}
?>