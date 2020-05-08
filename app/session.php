<?php
session_start();

$_SESSION['type'] = 'master';
$_SESSION["user_name"]="VISHAL";
$_SESSION["user_id"]="1";
$_SESSION["state"]="gujarat";

$type =$_SESSION['type'];
$user_name=$_SESSION["user_name"];
$user_id=$_SESSION["user_id"];
$state = $_SESSION["state"];


$company_logo = "unvlogojpg.jpg";
$company_name = "U & V Trading";
$company_address = "2667,sahyog soceity ,G.H,B,sachin,surat 394230";
$company_gst_no="24ACPFS4058K1ZM";
$company_state="Gujarat";

$company_bank_name = "INDIAN BANK";
$company_bank_account_number = "1234567789077";
$company_bank_branch = "udhna";
$company_bank_ifsc = "IDN7854";




?>