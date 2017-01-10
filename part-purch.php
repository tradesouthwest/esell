<?php
if( isset( $_POST['made_purchase'] ))
{

include 'inc/controls.php';

/**
 * Process how many items and billing info
 * Fields process from purchasing.pg
 *
 */
    $prodcode = ''; $proddate = ''; $paidon = ''; $deliver = ''; $keepsid = ''; $memid = '';
    $sale_id = ''; $mem_id = ''; $persdata = ''; $stats = ''; $esellopt = ''; $purchtotal = '';

    // Only post checkbox values that are set.
    //$prodecode = isset( $_POST['prodcode'] ) ? $_POST['prodcode'] : null;
    $keeps = 0;

    /**
     * @col `keeps`, @val 0= purchased. Default= 1.
     * Loop thru all items by basket id and set val= 0.
     */
    $size = count($_POST['keepsid']);
    $i = 0;
    while ($i < $size)
    {
        // define each variable
        $keepsid= $_POST['keepsid'][$i];

        $sql = ("UPDATE esell_basket
                SET `keeps` = :keeps WHERE `id` = :id");
        $stmt = $pdo->prepare($sql);

        $stmt->execute(array("keeps" => $keeps, "id" => $keepsid));
    ++$i;
    }

//next step is to add purchase to esell_sold table
if(isset( $_POST['country']))      $country = $_POST['country'];
if(isset( $_POST['first_name'])) $first_name = $_POST['first_name'];
if(isset( $_POST['last_name']))    $last_name = $_POST['last_name'];
if(isset( $_POST['address']))         $address = $_POST['address'];
if(isset( $_POST['city']))                $city = $_POST['city'];
if(isset( $_POST['state']))               $state = $_POST['state'];
if(isset( $_POST['zip_code']))          $zip_code = $_POST['zip_code'];
if(isset( $_POST['phone_number']))   $phone_number = $_POST['phone_number'];
if(isset( $_POST['email_address']))  $email_address = $_POST['email_address'];

if(isset( $_POST['countryb']))      $countryb = $_POST['countryb'];
if(isset( $_POST['first_nameb'])) $first_nameb = $_POST['first_nameb'];
if(isset( $_POST['last_nameb']))    $last_nameb = $_POST['last_nameb'];
if(isset( $_POST['addressb']))         $addressb = $_POST['addressb'];
if(isset( $_POST['cityb']))                $cityb = $_POST['cityb'];
if(isset( $_POST['stateb']))               $stateb = $_POST['stateb'];
if(isset( $_POST['zip_codeb']))          $zip_codeb = $_POST['zip_codeb'];
if(isset( $_POST['phone_numberb']))   $phone_numberb = $_POST['phone_numberb'];
if(isset( $_POST['email_addressb']))  $email_addressb = $_POST['email_addressb'];

//if(isset( $_POST['prodcode']))   $prodids = $_POST['prodcode'];   //prod id
if(isset( $_POST['proddate']))   $proddate = $_POST['proddate'];   //hold etc.
if(isset( $_POST['deliver']))    $deliver  = $_POST['deliver'];    //delivery number or date
if(isset( $_POST['sale_id']))    $sale_id  = $_POST['sale_id'];    //cookie id(non-member)
if(isset( $_POST['mem_id']))     $mem_id   = $_POST['mem_id'];     //member id
if(isset( $_POST['purchtotal'])) $persdata = $_POST['purchtotal']; //ccdata
if(isset( $_POST['stats']))      $stats    = $_POST['stats'];      //1=hold, 2=delivered/picked up
if(isset( $_POST['esellopt']))   $esellopt = $_POST['esellopt'];   //basket id
                                 $paidon   = $date_entered;        //now

// prodcode col is all basket ids of sale
$prodids = array();
$size = count($_POST['prodcode']);
    $i = 0;
    while ($i < $size)
    {
        // define each variable
        $prodids = implode(' ', $_POST['prodcode']);
    ++$i;

     }




     $sql = "INSERT INTO esell_sold
    ( country, first_name, last_name, address, city, state, zip_code, phone_number, email_address,
 countryb, first_nameb, last_nameb, addressb, cityb, stateb, zip_codeb, phone_numberb, email_addressb,
prodcode, proddate, paidon, deliver, sale_id, mem_id, persdata, stats, esellopt )
    VALUES
( :country, :first_name, :last_name, :address, :city, :state, :zip_code, :phone_number, :email_address,
 :countryb, :first_nameb, :last_nameb, :addressb, :cityb, :stateb, :zip_codeb, :phone_numberb, :email_addressb,
:prodcode, :proddate, :paidon, :deliver, :sale_id, :mem_id, :persdata, :stats, :esellopt )";


    //Prepare our statement.
    $stmt = $pdo->prepare($sql);

    //Bind the values to the parameters
    $stmt->bindValue(':country',     $country);
    $stmt->bindValue(':first_name',  $first_name);
    $stmt->bindValue(':last_name',   $last_name);
    $stmt->bindValue(':address',     $address);
    $stmt->bindValue(':city',        $city);
    $stmt->bindValue(':state',       $state);
    $stmt->bindValue(':zip_code',    $zip_code);
    $stmt->bindValue(':phone_number',  $phone_number);
    $stmt->bindValue(':email_address', $email_address);

    $stmt->bindValue(':countryb',    $countryb);
    $stmt->bindValue(':first_nameb', $first_nameb);
    $stmt->bindValue(':last_nameb',  $last_nameb);
    $stmt->bindValue(':addressb',    $addressb);
    $stmt->bindValue(':cityb',       $cityb);
    $stmt->bindValue(':stateb',      $stateb);
    $stmt->bindValue(':zip_codeb',      $zip_codeb);
    $stmt->bindValue(':phone_numberb',  $phone_numberb);
    $stmt->bindValue(':email_addressb', $email_addressb);

    $stmt->bindValue(':prodcode',    $prodids);
    $stmt->bindValue(':proddate',    $proddate);
    $stmt->bindValue(':paidon',      $paidon);
    $stmt->bindValue(':deliver',     $deliver);
    $stmt->bindValue(':sale_id',     $sale_id);
    $stmt->bindValue(':mem_id',      $mem_id);
    $stmt->bindValue(':persdata',    $persdata);
    $stmt->bindValue(':stats',       $stats);
    $stmt->bindValue(':esellopt',    $esellopt);

    //Execute the statement and insert our values.
    $q = $stmt->execute();
        if( $q )
        { $msgb = "Purchase proccessed - thanks for being a great customer"; }
        else { $msgb = "Please try again, there was trouble entering billing info into database."; }
    redirect("myaccount.php?id={$esellopt}&msgb={$msgb}");
}   //ends purchase made
?>
