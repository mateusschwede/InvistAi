<?php


$ontem=date("Ymd",strtotime("yesterday"));

$url = "https://api-cotacao-b3.labdo.it/api/cotacao/dt/20210205/02";
$acao = json_decode(file_get_contents($url));
echo '<table><tbody><tr><th>Ação</th><th>Empresa</th><th>Cotação</th></tr>';
$acao1=array('cod'=>'','ac'=>'','val'=>0);
$m[]="";
$x=0;
foreach ($acao as $a):
//$m=($a->cd_acao, $a->nm_empresa_rdz, $a->vl_mlh_oft_venda);
    
    echo '<tr>

    <td>'. $a->cd_acao.' </td>
    <td>'. $a->nm_empresa_rdz.' </td>
    <td>'. $a->vl_mlh_oft_venda.' </td>
    </tr>
    <tr>
    <tr>


    ';
 array_push($acao1, $a->cd_acao,$a->nm_empresa_rdz,$a->vl_mlh_oft_venda);
array_push($m, $a->cd_acao,$a->nm_empresa_rdz,$a->vl_mlh_oft_venda);

endforeach;
$ff=count($acao1);
echo '<br><br><h1>Total de elementos no array acao1:'.$ff.'</h1>';
echo '<br><br><h1>Total de elementos no array array M:'.count($m).'</h1>';

echo "Dados do array M <br>";
echo '<table><tbody><tr><th>Código</th><th>Ação</th><th>Cotação R$</th></tr>';
$x=1;
while ($x < count($m)) {
   
  echo ' <tr>
  <td>'.$m[$x].'</td>
  <td>'.$m[$x+1].'</td>
  <td>'.$m[$x+2].'</td>';
  $x=$x+3;
}
//if(in_array('PETROBRAS',$acao1)){
   // echo "Achei!!!";
   // echo current($acao1).'<br>';




?>
