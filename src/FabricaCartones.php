<?php
namespace Bingo;
class FabricaCartones {
  public function generarCarton() {
    // Algo de pseudo-código para ayudar con la evaluacion.
    $carton = new Carton($this->intentoCarton());
    while( ($this->cartonEsValido($carton)) == FALSE) {
    	$carton = new Carton($this->intentoCarton());
    }
  return $carton->columnas();
  }

  protected function cartonEsValido($carton) {
    if ($this->validarUnoANoventa($carton)&&
      $this->validarCincoNumerosPorFila($carton) &&
      $this->validarColumnaNoVacia($carton) &&
      $this->validarColumnaCompleta($carton) &&
      $this->validarTresCeldasIndividuales($carton) &&
      $this->validarNumerosIncrementales($carton) &&
      $this->validarFilasConVaciosUniformes($carton)
    ) {
      return TRUE;
    }
    return FALSE;
  }
  protected function validarUnoANoventa($carton) {
	 foreach($carton->numerosDelCarton() as $numero){
	if($numero < 1 || $numero >90) {return FALSE;}
	}
	return TRUE;
  }
  protected function validarCincoNumerosPorFila($carton) {
	 foreach($carton->filas() as $fila)
	 {	 $c = 0;
	 	foreach($fila as $numero)
		{	if($numero != 0){ $c++; }		
		}
	  if($c != 5){return FALSE;}
	 }
	return TRUE;
  }
  protected function validarColumnaNoVacia($carton) {
	  foreach($carton->columnas() as $columna)
	  {	$c = 0;
	   	foreach($columna as $numero)
		{	if($numero != 0){ $c++; }
		}
	  }
	  if($c < 1){return FALSE;}
	return TRUE;
  }
  protected function validarColumnaCompleta($carton) {
	  foreach($carton->columnas() as $columna)
	  {	$c = 0;
	   	foreach($columna as $numero)
		{	if($numero != 0){ $c++; }
		}
	  }
	  if($c >= 3){return FALSE;}
	return TRUE;
  }
  protected function validarTresCeldasIndividuales($carton) {
   	$c2 = 0;
	  foreach($carton->columnas() as $columna)
	  {	$c = 0;
	   	foreach($columna as $numero)
		{	if($numero != 0){ $c++; }
		}
	   	 if ($c == 1) { $c2++;}
	  }	
	if($c2 != 3){return FALSE;}
	return TRUE;
  }
  protected function validarNumerosIncrementales($carton) {
	 $lastMax = 0;
	 foreach($carton->columnas() as $columna)
	 {	
		$presentMin= min(array_filter($columna));
		if($presentMin < $lastMax){return FALSE;}
		$lastMax = max($columna);
	 }
	return TRUE;
  }
  protected function validarFilasConVaciosUniformes($carton) {
	 foreach($carton->filas() as $fila)
	 {	 $c = 0;
	 	foreach($fila as $numero)
		{	if($numero == 0){ $c++; }
		 	else {
				$cmax=$c;
				$c = 0;
			}
		}
	 if($cmax > 3){return FALSE;}
	 }
	 return TRUE;
  }

  public function intentoCarton() {
    $contador = 0;
    $carton = [
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0]
    ];
    $numerosCarton = 0;
    while ($numerosCarton < 15) {
      $contador++;
      if ($contador == 50) {
        return $this->intentoCarton();
      }
      $numero = rand (1, 90);
      $columna = floor ($numero / 10);
      if ($columna == 9) { $columna = 8;}
      $huecos = 0;
      for ($i = 0; $i<3; $i++) {
        if ($carton[$columna][$i] == 0) {
          $huecos++;
        }
        if ($carton[$columna][$i] == $numero) {
          $huecos = 0;
          break;
        }
      }
      if ($huecos < 2) {
        continue;
      }
      $fila = 0;
      for ($j=0; $j<3; $j++) {
        $huecos = 0;
        for ($i = 0; $i<9; $i++) {
          if ($carton[$i][$fila] == 0) { $huecos++; }
        }
        if ($huecos < 5 || $carton[$columna][$fila] != 0) {
          $fila++;
        } else{
          break;
        }
      }
      if ($fila == 3) {
        continue;
      }
      $carton[$columna][$fila] = $numero;
      $numerosCarton++;
      $contador = 0;
    }
    for ( $x = 0; $x < 9; $x++) {
      $huecos = 0;
      for ($y =0; $y < 3; $y ++) {
        if ($carton[$x][$y] == 0) { $huecos++;}
      }
      if ($huecos == 3) {
        return $this->intentoCarton();
      }
    }
    return $carton;
  }
}
