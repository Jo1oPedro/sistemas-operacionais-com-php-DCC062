<?php

$start_time = microtime(true);

$a = 1;
$b = 10000;
$total = $b - $a;
$totalNotDivisible = $b;

$isPrime = true;

$primes = [];
for ($i = 0; $i < 10000; $i++) {
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

$file = fopen('resultadoSincrono.txt', 'a');
foreach($primes as $prime) {
    fwrite($file, $prime . PHP_EOL);
}

$end_time = microtime(true);

echo 'Tempo de execução: ' . $execution_time = ($end_time - $start_time);

