<?php
function repartirCartas(){
    $mazo = [
        '♥'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        '♦'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        '♣'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
        '♠'=>["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Ocho","Nueve","Diez","J","Q","K"],
    ];
    $cartas = [];
    $mazoCompleto = [];
    foreach ($mazo as $palo => $valores) {
        foreach ($valores as $valor) {
            $mazoCompleto[] = ['palo' => $palo, 'valor' => $valor];
        }
    }
    shuffle($mazoCompleto);
    return array_splice($mazoCompleto, 0, 5);
}

function mostrarCartas($cartas){
    foreach($cartas as $carta){
        echo "{$carta['valor']} de {$carta['palo']}\n";
    } 
}

function evaluarMano($cartas) {
    if (esEscaleraReal($cartas)) return "Escalera Real";
    if (esPoker($cartas)) return "Poker";
    if (esFullHouse($cartas)) return "Full House";
    if (esColor($cartas)) return "Color";
    if (esEscalera($cartas)) return "Escalera";
    if (esDosPares($cartas)) return "Dos Pares";
    return "Carta Alta";
}

function esEscaleraReal($cartas){
    $valores = ['As', 'K', 'Q', 'J', 'Diez'];
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
    $indices = [];
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

$saldo = 10000;

function jugarContraLaCasa() {
    global $saldo;
    $apuesta = readline("Ingrese la apuesta (mínimo 1000): ");
    if ($apuesta < 1000) {
        echo "Apuesta mínima es 10\n";
        return;
    }
    if ($apuesta > $saldo) {
        echo "Saldo insuficiente\n";
        return;
    }
    
    $cartasJugador = repartirCartas();
    echo "Tus cartas son:\n";
    mostrarCartas($cartasJugador);
    $mensajeJugador = evaluarMano($cartasJugador);
    echo "Tu mano es: $mensajeJugador\n";
    
    $opcion = readline("¿Desea subir la apuesta? (1) Sí, (2) No: ");
    if ($opcion == 1) {
        $cartasCasa = repartirCartas();
        echo "Las cartas de la casa son:\n";
        mostrarCartas($cartasCasa);
        $mensajeCasa = evaluarMano($cartasCasa);
        echo "La mano de la casa es: $mensajeCasa\n";
        
        // Determinar quién gana
        $resultado = compararManos($mensajeJugador, $mensajeCasa);
        if ($resultado == 1) {
            echo "¡Ganaste! Tu apuesta es de $apuesta. Motivo: $mensajeJugador\n";
            $saldo += $apuesta;
        } elseif ($resultado == -1) {
            echo "¡Perdiste! Tu apuesta es de $apuesta. Motivo: $mensajeCasa\n";
            $saldo -= $apuesta;
        } else {
            echo "Empate. La apuesta se devuelve.\n";
        }
    }
    
    $opcion = readline("¿Desea volver a apostar? (1) Sí, (2) No, (3) Salir: ");
    if ($opcion == 1) {
        if ($saldo >= 10) {
            jugarContraLaCasa();
        } else {
            echo "Saldo insuficiente\n";
        }
    } elseif ($opcion == 2) {
        echo "Hasta luego!\n";
    } elseif ($opcion == 3) {
        exit;
    }
}

function compararManos($manoJugador, $manoCasa) {
    $jerarquia = [
        "Escalera Real" => 9,
        "Poker" => 8,
        "Full House" => 7,
        "Color" => 6,
        "Escalera" => 5,
        "Dos Pares" => 4,
        "Carta Alta" => 1
    ];
    
    return $jerarquia[$manoJugador] <=> $jerarquia[$manoCasa];
}

jugarContraLaCasa();
?>