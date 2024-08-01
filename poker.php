<?php
function repartirCartas(){
    $mazo =[
        'Corazones' => ["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        'Picas' => ["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        'Treboles' => ["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        'Diamantes' => ["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
    ];
    $cartas =[];
    for ( $i = 0; $i < 5; $i++){
        $palo = array_rand($mazo);
        $valor =array_rand($mazo[$palo]);
        $cartas[]=['palo' => $palo, 'valor' => $mazo[$palo][$valor]];
    }
    return $cartas; 
}

function mostrarCartas($cartas){
    echo "Tus cartas son: \n";
    foreach($cartas as $carta){
        echo "{$carta ['valor']} de {$carta['palo']} \n";
    } 
}

$cartas = repartirCartas();
mostrarCartas($cartas);

?>