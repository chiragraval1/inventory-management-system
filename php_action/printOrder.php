<?php    

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_place,gstn FROM orders WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[1];
$clientContact = $orderData[2]; 
$subTotal = $orderData[3];
$vat = $orderData[4];
$totalAmount = $orderData[5]; 
$discount = $orderData[6];
$grandTotal = $orderData[7];
$paid = $orderData[8];
$due = $orderData[9];
$payment_place = $orderData[10];
$gstn = $orderData[11];

$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
   INNER JOIN product ON order_item.product_id = product.product_id 
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

 $table = '<style>
.star img {
    visibility: visible;
}
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
     border:1px solid black;
  }
  
  .invoice {
      max-width: 800px;
      margin: 0 auto;
      padding: 13px;
      border: 1px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
      background-color: #fff;
  }
  
  header {
      text-align: center;
      margin-bottom: 20px;
  }
  header h3{
      line-height: 10px;
  }
  .shop{
      display: flex;
      border: 1px solid #000;
  }
  .clogo{
      width: 30%;
      height: auto;
      padding: 5px;
   }
  .clogo img{
      width: 100%;
      padding: 5px;
      border: none;
  }
  .ourshop{
      width: 80%;
      text-align: right;
      padding-right: 40px;    
  }
  .ourshop p{
      font-size: 16px;
      line-height: 10px;
  }
  .s_name{
      padding-top: 20px;
      /* color: green; */
      font-weight: bolder;
  }
  
  .s_name_n{
      font-weight: 600;
      /* color: green; */
  }
  
  .customer_details{
      border: 1px solid #000;
  }
  .customer_details td{
      border: none;
  }
  
table {
   width: 100%;
   /* border: 1px solid #000; */
   border-collapse: collapse;
}

th, td {
   padding: 3px;
   border: 1px solid #000;
   text-align: left;
   padding-left: 40px;
}

thead th {
   background-color: #f2f2f2;
}

tfoot td {
   border-top: 1px solid #ddd;
}

tfoot td[colspan] {
   text-align: right;
}

footer {

   text-align: center;
   margin-top: 20px;
   font-style: italic;
   background-color: #f2f2f2;

}
.line{
   border-bottom: 2px solid black;
}
</style>
<table align="center" cellpadding="0" cellspacing="0" style="width: 100%;border:1px solid black;margin-bottom: 10px;">
               <tbody>
                  <h3 style="color: red; text-align:center;">Invoice</h3>
            <div class="shop">
                <div class="clogo"><img src="./logo1.jpeg" alt=""></div>
                <div class="ourshop">
                    <p class="s_name">RAGHAV GENERAL STORE</p>
                    <P>Mota Chiloda Gandhinagar, GUJARAT,</P>
                    <P>gandhinagar,382355</P>
                    <P>Contact Number: 8758410228</P>
                    <p>GSTIN: 24 AK MPR 1868 D 1 ZZ</p>
                    <P>Email: <a href="">chiragraval9599@gmail.com</a> </P>
                </div>
            </div>
                  <div class="customer_details">
                  <table>
                      <tr>
                          <td>customer Name</td>
                          <td><b>&nbsp;'.$clientName.'</b></td>
                          <td>Invoice No:</td>
                          <td><b>'.$orderId.'</b></td>
                      </tr>           
                      <tr>
                          <td>Mobile No:</td>
                          <td>'.$clientContact.'</td>
                          <td>Date:</td>
                          <td>'.$orderDate.'</td>
                      </tr>    
                  </table>
              </div>
                         <table align="left" cellspacing="0" style="width: 100%; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-width: thin; border-bottom-width: thin; border-left-width: thin; border-right-color: black; border-bottom-color: black; border-left-color: black;
                         margin-top:10px">
                            <tbody>
                            <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th colspan="3">Item</th>
                                <th>HSN/SAC</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>

                  </tr>';
                  $x = 1;
                  $cgst = 0;
                  $igst = 0;
                  if($payment_place == 2)
                  {
                     $igst = $subTotal*18/100;
                  }
                  else
                  {
                     $cgst = $subTotal*18/100;
                  }
                  $total = $subTotal+$cgst+$igst;
            while($row = $orderItemResult->fetch_array()) {       
                        
               $table .= '
              
                  <tr>
                  <td>'.$x.'</td>
                  <td colspan="3">'.$row[4].'</td>
                  <td></td>
                  <td>'.$row[2].'</td>
                  <td>'.$row[1].'</td>
                  <td>'.$row[3].'</td>
              </tr>
        
               ';
            $x++;
            } // /while
                $table.= '
                  <main>
                  <table >
                 
                      <table>
                      <tr>
                            <td style="border:none; text-align:right" width="76%">Subtotal</td>
                          <td widht="24%"><b>'.$subTotal.'</b></td>
                      </tr>
                      <tr>
                            <td style="border:none;text-align:right"width="76%" >Tax (18%)</td>
                          <td widht="24%">'.$subTotal*0.18.'</td>
                      </tr>
                      <tr>
                          <td style="border:none; text-align:right" width="76%">Total</td>
                          <td widht="24%"><b>'.$total.'</b></td>
                      </tr>
                      <tr>
                      <td style="border:none; text-align:right" width="76%">Discount</td>
                      <td widht="24%"><b>'.$orderData[6].'</b></td>
                        </tr>
                        <tr>
                        <td style="border:none; text-align:right" width="76%">Grand Total</td>
                        <td widht="24%"><b>'.$total-$orderData[6].'</b></td>
                          </tr>
                        </table>
                  
                      </tbody>
                   
                  </table>
              </main>
             
               </tbody>
            </table>';
$connect->close();

echo $table;