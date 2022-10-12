<?php

require_once __DIR__ . '/../vendor/autoload.php';
use parallel\Runtime;

$start_time = microtime(true);

$a = 1;
$b = 10000;
$total = $b - $a;
$totalNotDivisible = $b;

$isPrime = true;
$runTimes = [];
$futures = [];

for($cont = 0; $cont < 4; $cont++) {
    $runTimes[$cont] = new Runtime();
    $futures[] = $runTimes[$cont]->run(function ($cont, $total, $totalNotDivisible, $b) {

        $primes = [];
        for($i = (($cont*(floor($total/4)))+1); $i <= (($cont != 3) ? (($cont+1)*(floor($total/4))) : $b); $i++) {
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
    }, [$cont, $total, $totalNotDivisible, $b]);
}

foreach($futures as $key => $thread) {
    $futures[$key]->done();
}

$file = fopen('src/resultadoAssincrono.txt', 'a');
foreach($futures as $key => $primesArray) {
    foreach($primesArray->value() as $prime) {
        fwrite($file, $prime . PHP_EOL);
    }
}

$end_time = microtime(true);

echo 'Tempo de execução: ' . $execution_time = ($end_time - $start_time);
