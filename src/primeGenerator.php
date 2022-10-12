<?php

require_once __DIR__ . '/../vendor/autoload.php';
use parallel\Runtime;

$a = 1;
$b = 10;
$total = $b - $a;
$totalNotDivisible = $b;

$isPrime = true;
$runTimes = [];
$futures = [];

for($cont = 0; $cont < 4; $cont++) {
    ${"contadora" . $cont} = $cont;
    $runTimes[${"contadora" . $cont}] = new Runtime();
    $futures[] = $runTimes[${"contadora" . $cont}]->run(function ($cont2, $total2, $totalNotDivisible2, $b2) {

        $primes = [];
        for($i = (($cont2*(floor($total2/4)))+1); $i <= (($cont2 != 3) ? (($cont2+1)*(floor($total2/4))) : $b2); $i++) {
            if (($i == 1) || ($i == 0)) {
                continue;
            }

            $isPrime = true;

            for ($j = 2; $j <= ($i / 2); ++$j) {
                if (($i % $j) == 0) {
                    $isPrime = false;
                    break;
                }
            }

            if ($isPrime) {
                $primes[] = $i;
            }

        }
        return $primes;
    }, [${"contadora" . $cont}, $total, $totalNotDivisible, $b]);
}

foreach($futures as $key => $thread) {
    $futures[$key]->done();
}

foreach($futures as $key => $primesArray) {
    foreach($primesArray->value() as $prime) {
        echo $prime . PHP_EOL;
    }
}

/*foreach($futures as $primesArray) {
    foreach($primesArray as $prime) {
        echo $prime . PHP_EOL;
    }
}*/

//var_dump($futures);
