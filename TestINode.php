<?php
require_once("ITree.php");

$testnode=new INode(); // create a new node(tree)
$testsheet=new ISheet(); // create a new sheet

$testsheet->Add("x","y"); // add x element to the sheet
$testsheet->Add("a","b"); // add a element to the sheet

$testnode->Add($testsheet); // add sheet to the node

$eltX=$testnode->Get($testsheet)->Get("x"); // get x element from the node
echo $eltX.PHP_EOL;

$eltX=$testnode->GetIndex(0)->Get("x"); // (blind) get x element from the node
echo $eltX.PHP_EOL;


?>