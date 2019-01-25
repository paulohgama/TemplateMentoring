<?php

namespace App\Http\Controllers;

class CifragemController extends Controller
{
    public function Cifragem($mensagem) {
        $retorno = "";
        for($i = 0; $i < strlen($mensagem); $i++)
        {
            var_dump($mensagem[$i]);
            $retorno .= $this->Atbah($this->Albam($this->Atbash($this->CifraDeCesar(($mensagem[$i])))));
        }
        //$retorno = $this->TranspColunas($retorno);
        dd($retorno);
    }

    public function Decifragem($mensagem) {
        $retorno = "";
        for($i = 0; $i < strlen($mensagem); $i++)
        {
            var_dump($mensagem[$i]);
            $retorno .= $this->DecifraDeCesar($this->Atbash($this->Albam($this->Atbah(($mensagem[$i])))));
        }
        //$retorno = $this->TranspColunas($retorno);
        dd($retorno);
    }


    public function Atbah($letra) {
        $retorno = "";
        switch($letra)
            {
                case 'A': $retorno = 'I'; break;
                case "B": $retorno = 'H'; break;
                case "C": $retorno = 'G'; break;
                case "D": $retorno = 'F'; break;
                case "E": $retorno = 'N'; break;
                case "F": $retorno = 'D';break;
                case "G": $retorno = 'C';break;
                case "H": $retorno = 'B';break;
                case "I": $retorno = 'A';break;
                case "J": $retorno = 'R';break;
                case "K": $retorno = 'Q';break;
                case "L": $retorno = 'P';break;
                case "M": $retorno = 'O';break;
                case "N": $retorno = 'E';break;
                case "O": $retorno = 'M';break;
                case "P": $retorno = 'L';break;
                case "Q": $retorno = 'K';break;
                case "R": $retorno = 'J';break;
                case "S": $retorno = 'Z';break;
                case "T": $retorno = 'Y';break;
                case "U": $retorno = 'X';break;
                case "V": $retorno = 'W';break;
                case "W": $retorno = 'V';break;
                case "X": $retorno = 'U';break;
                case "Y": $retorno = 'T';break;
                case "Z": $retorno = 'S';break;
                case "a": $retorno = 'i';break;
                case "b": $retorno = 'h';break;
                case "c": $retorno = 'g';break;
                case "d": $retorno = 'f';break;
                case "e": $retorno = 'n';break;
                case "f": $retorno = 'd';break;
                case "g": $retorno = 'c';break;
                case "h": $retorno = 'b';break;
                case "i": $retorno = 'a';break;
                case "j": $retorno = 'r';break;
                case "k": $retorno = 'q';break;
                case "l": $retorno = 'p';break;
                case "m": $retorno = 'o';break;
                case "n": $retorno = 'e';break;
                case "o": $retorno = 'm';break;
                case "p": $retorno = 'l';break;
                case "q": $retorno = 'k';break;
                case "r": $retorno = 'j';break;
                case "s": $retorno = 'z';break;
                case "t": $retorno = 'y';break;
                case "u": $retorno = 'x';break;
                case "v": $retorno = 'w';break;
                case "w": $retorno = 'v';break;
                case "x": $retorno = 'u';break;
                case "y": $retorno = 't';break;
                case "z": $retorno = 's';break;
                default: $retorno = $letra;
            }
            return $retorno;
    }

    public function Albam($letra) {
        $retorno = "";
        switch($letra)
            {
                case "A": $retorno = 'N';break;
                case "B": $retorno = 'O';break;
                case "C": $retorno = 'P';break;
                case "D": $retorno = 'Q';break;
                case "E": $retorno = 'R';break;
                case "F": $retorno = 'S';break;
                case "G": $retorno = 'T';break;
                case "H": $retorno = 'U';break;
                case "I": $retorno = 'V';break;
                case "J": $retorno = 'W';break;
                case "K": $retorno = 'X';break;
                case "L": $retorno = 'Y';break;
                case "M": $retorno = 'Z';break;
                case "N": $retorno = 'A';break;
                case "O": $retorno = 'B';break;
                case "P": $retorno = 'C';break;
                case "Q": $retorno = 'D';break;
                case "R": $retorno = 'E';break;
                case "S": $retorno = 'F';break;
                case "T": $retorno = 'G';break;
                case "U": $retorno = 'H';break;
                case "V": $retorno = 'I';break;
                case "W": $retorno = 'J';break;
                case "X": $retorno = 'K';break;
                case "Y": $retorno = 'L';break;
                case "Z": $retorno = 'M';break;
                case "a": $retorno = 'n';break;
                case "b": $retorno = 'o';break;
                case "c": $retorno = 'p';break;
                case "d": $retorno = 'q';break;
                case "e": $retorno = 'r';break;
                case "f": $retorno = 's';break;
                case "g": $retorno = 't';break;
                case "h": $retorno = 'u';break;
                case "i": $retorno = 'v';break;
                case "j": $retorno = 'w';break;
                case "k": $retorno = 'x';break;
                case "l": $retorno = 'y';break;
                case "m": $retorno = 'z';break;
                case "n": $retorno = 'a';break;
                case "o": $retorno = 'b';break;
                case "p": $retorno = 'c';break;
                case "q": $retorno = 'd';break;
                case "r": $retorno = 'e';break;
                case "s": $retorno = 'f';break;
                case "t": $retorno = 'g';break;
                case "u": $retorno = 'h';break;
                case "v": $retorno = 'i';break;
                case "w": $retorno = 'j';break;
                case "x": $retorno = 'k';break;
                case "y": $retorno = 'l';break;
                case "z": $retorno = 'm';break;
                default : $retorno = $letra;
            }
            return $retorno;

        }



    public function Atbash($letra){
        $retorno = "";
        switch($letra)
            {
                case "A": $retorno = 'Y';break;
                case "B": $retorno = 'Z';break;
                case "C": $retorno = 'X';break;
                case "D": $retorno = 'W';break;
                case "E": $retorno = 'V';break;
                case "F": $retorno = 'U';break;
                case "G": $retorno = 'T';break;
                case "H": $retorno = 'S';break;
                case "I": $retorno = 'R';break;
                case "J": $retorno = 'Q';break;
                case "K": $retorno = 'P';break;
                case "L": $retorno = 'O';break;
                case "M": $retorno = 'N';break;
                case "N": $retorno = 'M';break;
                case "O": $retorno = 'L';break;
                case "P": $retorno = 'K';break;
                case "Q": $retorno = 'J';break;
                case "R": $retorno = 'I';break;
                case "S": $retorno = 'H';break;
                case "T": $retorno = 'G';break;
                case "U": $retorno = 'F';break;
                case "V": $retorno = 'E';break;
                case "W": $retorno = 'D';break;
                case "X": $retorno = 'C';break;
                case "Y": $retorno = 'B';break;
                case "Z": $retorno = 'A';break;
                case "a": $retorno = 'z';break;
                case "b": $retorno = 'y';break;
                case "c": $retorno = 'x';break;
                case "d": $retorno = 'w';break;
                case "e": $retorno = 'v';break;
                case "f": $retorno = 'u';break;
                case "g": $retorno = 't';break;
                case "h": $retorno = 's';break;
                case "i": $retorno = 'r';break;
                case "j": $retorno = 'q';break;
                case "k": $retorno = 'p';break;
                case "l": $retorno = 'o';break;
                case "m": $retorno = 'n';break;
                case "n": $retorno = 'm';break;
                case "o": $retorno = 'l';break;
                case "p": $retorno = 'k';break;
                case "q": $retorno = 'j';break;
                case "r": $retorno = 'i';break;
                case "s": $retorno = 'h';break;
                case "t": $retorno = 'g';break;
                case "u": $retorno = 'f';break;
                case "v": $retorno = 'e';break;
                case "w": $retorno = 'd';break;
                case "x": $retorno = 'c';break;
                case "y": $retorno = 'b';break;
                case "z": $retorno = 'a';break;
                default : $retorno = $letra;
            }

            return $retorno;
    }

    public function CifraDeCesar($letra){
        //desloca em 3 letras no sentido crescente
        switch($letra)
            {
                case "A": $retorno = 'D';break;
                case "B": $retorno = 'E';break;
                case "C": $retorno = 'F';break;
                case "D": $retorno = 'G';break;
                case "E": $retorno = 'H';break;
                case "F": $retorno = 'I';break;
                case "G": $retorno = 'J';break;
                case "H": $retorno = 'K';break;
                case "I": $retorno = 'L';break;
                case "J": $retorno = 'M';break;
                case "K": $retorno = 'N';break;
                case "L": $retorno = 'O';break;
                case "M": $retorno = 'P';break;
                case "N": $retorno = 'Q';break;
                case "O": $retorno = 'R';break;
                case "P": $retorno = 'S';break;
                case "Q": $retorno = 'T';break;
                case "R": $retorno = 'U';break;
                case "S": $retorno = 'V';break;
                case "T": $retorno = 'W';break;
                case "U": $retorno = 'X';break;
                case "V": $retorno = 'Y';break;
                case "W": $retorno = 'Z';break;
                case "X": $retorno = 'A';break;
                case "Y": $retorno = 'B';break;
                case "Z": $retorno = 'C';break;
                case "a": $retorno = 'd';break;
                case "b": $retorno = 'e';break;
                case "c": $retorno = 'f';break;
                case "d": $retorno = 'g';break;
                case "e": $retorno = 'h';break;
                case "f": $retorno = 'i';break;
                case "g": $retorno = 'j';break;
                case "h": $retorno = 'k';break;
                case "i": $retorno = 'l';break;
                case "j": $retorno = 'm';break;
                case "k": $retorno = 'n';break;
                case "l": $retorno = 'o';break;
                case "m": $retorno = 'p';break;
                case "n": $retorno = 'q';break;
                case "o": $retorno = 'r';break;
                case "p": $retorno = 's';break;
                case "q": $retorno = 't';break;
                case "r": $retorno = 'u';break;
                case "s": $retorno = 'v';break;
                case "t": $retorno = 'w';break;
                case "u": $retorno = 'x';break;
                case "v": $retorno = 'y';break;
                case "w": $retorno = 'z';break;
                case "x": $retorno = 'a';break;
                case "y": $retorno = 'b';break;
                case "z": $retorno = 'c';break;
                default : $retorno = $letra;
            }
            $cifra = $retorno;

            //desloca em 2 letras no sentido decrescente
            switch($cifra)
            {
                case "A": $cifra =  'Y';break;
                case "B": $cifra =  'Z';break;
                case "C": $cifra =  'A';break;
                case "D": $cifra =  'B';break;
                case "E": $cifra =  'C';break;
                case "F": $cifra =  'D';break;
                case "G": $cifra =  'E';break;
                case "H": $cifra =  'F';break;
                case "I": $cifra =  'G';break;
                case "J": $cifra =  'H';break;
                case "K": $cifra =  'I';break;
                case "L": $cifra =  'J';break;
                case "M": $cifra =  'K';break;
                case "N": $cifra =  'L';break;
                case "O": $cifra =  'M';break;
                case "P": $cifra =  'N';break;
                case "Q": $cifra =  'O';break;
                case "R": $cifra =  'P';break;
                case "S": $cifra =  'Q';break;
                case "T": $cifra =  'R';break;
                case "U": $cifra =  'S';break;
                case "V": $cifra =  'T';break;
                case "W": $cifra =  'U';break;
                case "X": $cifra =  'V';break;
                case "Y": $cifra =  'W';break;
                case "Z": $cifra =  'X';break;
                case "a": $cifra =  'y';break;
                case "b": $cifra =  'z';break;
                case "c": $cifra =  'a';break;
                case "d": $cifra =  'b';break;
                case "e": $cifra =  'c';break;
                case "f": $cifra =  'd';break;
                case "g": $cifra =  'e';break;
                case "h": $cifra =  'f';break;
                case "i": $cifra =  'g';break;
                case "j": $cifra =  'h';break;
                case "k": $cifra =  'i';break;
                case "l": $cifra =  'j';break;
                case "m": $cifra =  'k';break;
                case "n": $cifra =  'l';break;
                case "o": $cifra =  'm';break;
                case "p": $cifra =  'n';break;
                case "q": $cifra =  'o';break;
                case "r": $cifra =  'p';break;
                case "s": $cifra =  'q';break;
                case "t": $cifra =  'r';break;
                case "u": $cifra =  's';break;
                case "v": $cifra =  't';break;
                case "w": $cifra =  'u';break;
                case "x": $cifra = 'v';break;
                case "y": $cifra =  'w';break;
                case "z": $cifra =  'x';break;
                default : $cifra = $letra;
            }

        return $cifra;
    }

    public function DecifraDeCesar($letra){

        //desloca em 2 letras no sentido crescente
        switch($letra)
            {
                case "A": $retorno = 'C';break;
                case "B": $retorno = 'D';break;
                case "C": $retorno = 'E';break;
                case "D": $retorno = 'F';break;
                case "E": $retorno = 'G';break;
                case "F": $retorno = 'H';break;
                case "G": $retorno = 'I';break;
                case "H": $retorno = 'J';break;
                case "I": $retorno = 'K';break;
                case "J": $retorno = 'L';break;
                case "K": $retorno = 'M';break;
                case "L": $retorno = 'N';break;
                case "M": $retorno = 'O';break;
                case "N": $retorno = 'P';break;
                case "O": $retorno = 'Q';break;
                case "P": $retorno = 'R';break;
                case "Q": $retorno = 'S';break;
                case "R": $retorno = 'T';break;
                case "S": $retorno = 'U';break;
                case "T": $retorno = 'V';break;
                case "U": $retorno = 'W';break;
                case "V": $retorno = 'X';break;
                case "W": $retorno = 'Y';break;
                case "X": $retorno = 'X';break;
                case "Y": $retorno = 'A';break;
                case "Z": $retorno = 'B';break;
                case "a": $retorno = 'c';break;
                case "b": $retorno = 'd';break;
                case "c": $retorno = 'e';break;
                case "d": $retorno = 'f';break;
                case "e": $retorno = 'g';break;
                case "f": $retorno = 'h';break;
                case "g": $retorno = 'i';break;
                case "h": $retorno = 'j';break;
                case "i": $retorno = 'k';break;
                case "j": $retorno = 'l';break;
                case "k": $retorno = 'm';break;
                case "l": $retorno = 'n';break;
                case "m": $retorno = 'o';break;
                case "n": $retorno = 'p';break;
                case "o": $retorno = 'q';break;
                case "p": $retorno = 'r';break;
                case "q": $retorno = 's';break;
                case "r": $retorno = 't';break;
                case "s": $retorno = 'u';break;
                case "t": $retorno = 'v';break;
                case "u": $retorno = 'w';break;
                case "v": $retorno = 'x';break;
                case "w": $retorno = 'y';break;
                case "x": $retorno = 'z';break;
                case "y": $retorno = 'a';break;
                case "z": $retorno = 'b';break;
                default : $retorno = $letra;
            }
            $decifra = $retorno;

            //desloca em 3 letras no sentido decrescente
            switch($decifra)
            {
                case "A": $decifra = 'X';break;
                case "B": $decifra = 'Y';break;
                case "C": $decifra = 'Z';break;
                case "D": $decifra = 'A';break;
                case "E": $decifra = 'B';break;
                case "F": $decifra = 'C';break;
                case "G": $decifra = 'D';break;
                case "H": $decifra = 'E';break;
                case "I": $decifra = 'F';break;
                case "J": $decifra = 'G';break;
                case "K": $decifra = 'H';break;
                case "L": $decifra = 'I';break;
                case "M": $decifra = 'J';break;
                case "N": $decifra = 'K';break;
                case "O": $decifra = 'L';break;
                case "P": $decifra = 'M';break;
                case "Q": $decifra = 'N';break;
                case "R": $decifra = 'O';break;
                case "S": $decifra = 'P';break;
                case "T": $decifra = 'Q';break;
                case "U": $decifra = 'R';break;
                case "V": $decifra = 'S';break;
                case "W": $decifra = 'T';break;
                case "X": $decifra = 'U';break;
                case "Y": $decifra = 'V';break;
                case "Z": $decifra = 'W';break;
                case "a": $decifra = 'x';break;
                case "b": $decifra = 'y';break;
                case "c": $decifra = 'z';break;
                case "d": $decifra = 'a';break;
                case "e": $decifra = 'b';break;
                case "f": $decifra = 'c';break;
                case "g": $decifra = 'd';break;
                case "h": $decifra = 'e';break;
                case "i": $decifra = 'f';break;
                case "j": $decifra = 'g';break;
                case "k": $decifra = 'h';break;
                case "l": $decifra = 'i';break;
                case "m": $decifra = 'j';break;
                case "n": $decifra = 'k';break;
                case "o": $decifra = 'l';break;
                case "p": $decifra = 'm';break;
                case "q": $decifra = 'n';break;
                case "r": $decifra = 'o';break;
                case "s": $decifra = 'p';break;
                case "t": $decifra = 'q';break;
                case "u": $decifra = 'r';break;
                case "v": $decifra = 's';break;
                case "w": $decifra = 't';break;
                case "x": $decifra = 'u';break;
                case "y": $decifra = 'v';break;
                case "z": $decifra = 'w';break;
                default : $decifra = $letra;
            }
        return $decifra;
    }
    public function TranspColunas($mensagem = "PauloHenrique")
    {
        $matriz = array();
        $k = 0;
        $tamanho = strlen($mensagem);
        $qntLinhas = strlen($mensagem) % 6;
        $qntLinhas = ((strlen($mensagem)-$qntLinhas) / 6)+1;
        for($i = 0; $i < $qntLinhas; $i++)
        {
            $linha = array();
            for($j = 0; $j < 6; $j++)  {
                $linha[] = ($tamanho > 0) ? substr($mensagem, $k, 1) : null; $tamanho--; $k++;
            }
            $matriz[] = $linha;
        }
        $matrizFinal = array();
        for($i = 0; $i < 6; $i++)
        {
            $linhaNova = array();
            for($j = 0; $j < $qntLinhas; $j++)  {
                $linhaNova[] = $matriz[$j][$i];
            }
            $matrizFinal[] = $linhaNova;
        }
        $retorno = null;
        for($i = 0; $i < 6; $i++)
        {
            for($j = 0; $j < $qntLinhas; $j++)  {
                $retorno .= ($matrizFinal[$i][$j] != null) ? $matrizFinal[$i][$j] : " ";
            }
        }
        // var_dump($retorno); die;
        // dd($matriz, $matrizFinal, $mensagem, $retorno);
        return "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>".
        "</head><body>".$retorno."</body></html>";
    }

    public function TranspColunasDec($mensagem = "Peean ur li oq Hu")
    {
        $matriz = array();
        $tamanho = strlen($mensagem);
        $k = 0;
        $qntLinhas = strlen($mensagem) % 6;
        $qntLinhas = ((strlen($mensagem)-$qntLinhas) / 6)+1;
        for($i = 0; $i < 6; $i++)
        {
            $linha = array();
            for($j = 0; $j < $qntLinhas; $j++)
            {
                $linha[] = ($tamanho > 0) ? substr($mensagem, $k, 1) : null; $k++; $tamanho--;
            }
            $matriz[] = $linha;

        }
        $matrizFinal = array();
        for($i = 0; $i < $qntLinhas; $i++)
        {
            $linhaNova = array();
            for($j = 0; $j < 6; $j++)  {
                $linhaNova[] = $matriz[$j][$i];
            }
            $matrizFinal[] = $linhaNova;
        }
        $retorno = "";

        for($i = 0; $i < count($matrizFinal); $i++)
        {
            for($j = 0; $j < count($matrizFinal[$i]); $j++)  {
                $retorno .= ($matrizFinal[$i][$j] != null) ? $matrizFinal[$i][$j] : null;
            }
        }
        return "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>".
          "</head><body>".$retorno."</body></html>";
        //return $retorno;
    }
}
