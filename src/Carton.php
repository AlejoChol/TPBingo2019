<?php
namespace Bingo;
class Carton implements CartonInterface {
  protected $numeros_carton = [];
  /**
   * {@inheritdoc}
   */
  public function __construct(array $cartonAleatorio) {
    $this->numeros_carton=$cartonAleatorio;
  }
  /**
   * {@inheritdoc}
   */
  public function columnas() {
    return $this->numeros_carton ;
  }
  /**
   * {@inheritdoc}
   */
  public function filas() {
    $fila = [];
    $fila[] = [];

    for($i=0;$i<3;$i++)
    {
        foreach ($this->columnas() as $columna)
        {
          $fila[$i][]=$columna[$i];
        }
    }
  
     return $fila;
  
  }
  /**
   * {@inheritdoc}
   */
  public function numerosDelCarton() {
    $numeros = [];
    foreach ($this->filas() as $fila) {
      foreach ($fila as $celda) {
        if ($celda != 0) {
          $numeros[] = $celda;
        }
      }
    }
    return $numeros;
  }
  /**
   * {@inheritdoc}
   */
  public function tieneNumero(int $numero) {
    return in_array($numero, $this->numerosDelCarton());
  }
}
