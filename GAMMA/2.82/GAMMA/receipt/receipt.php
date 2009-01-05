<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
echo( "
<form action=\"receipt_insert.php\" method=\"post\">
  <h1><img src=\"../images/receipt.jpg\" border=\"0\"> <img src=\"../images/entry.jpg\" border=\"0\"></h1>
  <table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
  <tr><td>First Name: </td><td> <input class=\"blue\" type=\"text\" name=\"First\"></td></tr>
  <tr><td>Last Name: </td><td> <input class=\"blue\" type=\"text\" name=\"Last\"></td></tr>
  <tr><td>Amount: $ </td><td> <input class=\"blue\" name=\"Amount\" type=\"text\" size=\"10\" maxlength=\"8\"> Example: 82.50</td></tr>
  <tr><td>Reason: </td><td>  
  <select name=\"Reason\">
      <option value=\"Payment on Policy\" selected>Payment on Policy</option>
      <option value=\"New Business Downpayment\">New Business Downpayment</option>
      <option value=\"New Business Pay In Full\">New Business Pay In Full</option>
      <option value=\"Replace Bad Check\">Replace Bad Check</option>
    </select></td></tr>
    <tr><td>Policy Number: </td><td> <input class=\"blue\" type=\"text\" name=\"PolNum\"></td></tr>
  <tr><td>Payment Method: </td><td>
    <select name=\"Method\">
      <option value=\"Cash\" selected>Cash</option>
      <option value=\"EFT\">EFT</option>
      <option value=\"Check (Deposited)\">Check (Deposited)</option>
      <option value=\"Check (Mailed)\">Check (Mailed)</option>
      <option value=\"Check (Online)\">Check (Online)</option>
      <option value=\"Money Order\">Money Order</option>
      <option value=\"Credit Card (Office)\">Credit Card (Office)</option>
      <option value=\"Credit Card (Online)\">Credit Card (Online)</option>
    </select>
  </td></tr>
  <tr><td>Check Number: </td><td><input class=\"blue\" type=\"text\" name=\"CheckNumber\" value=\"N/A\"> (if applicable)</td></tr>
  <tr><td colspan=\"2\"><center><b>Split Payment</b></center></td></tr>
  <tr><td>Amount: $ </td><td> <input class=\"blue\" name=\"Amount2\" type=\"text\" size=\"10\" maxlength=\"8\"> Example: 82.50</td></tr>
  <tr><td>Payment Method: </td><td>
    <select name=\"Method2\">
      <option value=\"Cash\" selected>Cash</option>
      <option value=\"EFT\">EFT</option>
      <option value=\"Check (Deposited)\">Check (Deposited)</option>
      <option value=\"Check (Mailed)\">Check (Mailed)</option>
      <option value=\"Check (Online)\">Check (Online)</option>
      <option value=\"Money Order\">Money Order</option>
      <option value=\"Credit Card (Office)\">Credit Card (Office)</option>
      <option value=\"Credit Card (Online)\">Credit Card (Online)</option>
    </select>
  </td></tr>
  <tr><td>Check Number: </td><td><input class=\"blue\" type=\"text\" name=\"CheckNumber2\" value=\"N/A\"> (if applicable)</td></tr>
  
  
  <tr><td>By: </td><td>


".$_SESSION["username"]."

  </td></tr>
  <tr><td>To: </td><td><input class=\"blue\" type=\"text\" name=\"To\"></td></tr>
  <tr><td>Email Address: </td><td><input class=\"blue\" type=\"text\" name=\"email\"></td></tr>
  <tr><td>Bridge to Logbook? </td><td>
  <select name=\"bridge\">
  <option value=\"yes\">Yes</option>
  <option value=\"no\" selected>No</option>
  </select>
  </td></tr>
  </table>
  <input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> 
  
  </form>
  ");
?>
