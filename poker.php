<?php
function repartirCartas(){
    $mazo =[
        '♥'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        '♦'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        '♣'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        '♠'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
    ];
    $cartas =[] ;
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


    function esEscaleraReal($cartas){
    $valores = ['As', 'K', 'Q', 'J', 'Diez'];
    // verifica que los valores de las cartas sean los correctos
    $palo = $cartas[0]['palo'];
    foreach ($cartas as $carta) {
        if ($carta['palo'] !== $palo) {
            return false;
        }
    }
    $indice = 0;
    foreach ($cartas as $carta) {
        if ($carta['valor'] !== $valores[$indice]) {
            return false;
        }
        $indice++;
    }
    return true;  
}
function esPoker($cartas){
    $valores = array_count_values(array_column($cartas, 'valor'));
    foreach ($valores as $valor => $cantidad) {
        if ($cantidad === 4) {
            return true;
        }
    }
    return false;
}
function esFullHouse($cartas){
    $valores = array_count_values(array_column($cartas, 'valor'));
    $tres = false;
    $dos = false;
    foreach ($valores as $valor => $cantidad) {
        if ($cantidad === 3) {
            $tres = true;
        }
        if ($cantidad === 2) {
            $dos = true;
        }
    }
    return $tres && $dos;
}
function esColor($cartas) {
    $palo = $cartas[0]['palo'];
    foreach ($cartas as $carta) {
        if ($carta['palo'] !== $palo) {
            return false;
        }
    }
    return true;
}
function esEscalera($cartas) {
    $valores = ['As', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez', 'J', 'Q', 'K'];
    $indices = array();
    foreach ($cartas as $carta) {
        $indice = array_search($carta['valor'], $valores);
        $indices[] = $indice;
    }
    sort($indices);
    for ($i = 0; $i < 4; $i++) {
        if ($indices[$i + 1] !== $indices[$i] + 1) {
            return false;
        }
    }
    return true;
}
function esDosPares($cartas) {
    $valores = array_count_values(array_column($cartas, 'valor'));
    $pares = 0;
    foreach ($valores as $valor => $cantidad) {
        if ($cantidad === 2) {
            $pares++;
        }
    }
    return $pares === 2;
}
function esCartaAlta($cartas) {
    return !(
        esEscaleraReal($cartas) ||
        esPoker($cartas) ||
        esFullHouse($cartas) ||
        esColor($cartas) ||
        esEscalera($cartas) ||
        esDosPares($cartas)
    );
}
function evaluarMano($cartas){    

if (esEscaleraReal($cartas)) {
    echo "¡Felicidades! Tienes una escalera real.\n";
} elseif (esPoker($cartas)){
    echo "¡Felicitaciones! Tines un poker.\n";
}elseif(esFullHouse($cartas)){
    echo "¡Felicitaciones! Tienes un full house.\n";
}elseif(esColor($cartas)){
    echo "¡Felicitaciones! Tienes un color o full.\n";
}elseif (esEscalera($cartas)){
    echo " ¡Felicitaciones! Tienes una escalera.\n";
}elseif (esDosPares($cartas)){
    echo " ¡Felicitaciones! Tienes Dos pares.\n";
}elseif (esCartaAlta($cartas)){
    echo " ¡Felicitaciones! Tienes carta alta.\n";
}else{  
    echo"No tienes una buena mano";
}
}
$cartas = repartirCartas();
mostrarCartas($cartas);
evaluarMano($cartas);

?>
