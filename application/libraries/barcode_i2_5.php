<?
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
# @title
#   Barcode
#
# @description
#   Barcode generation classes 
#
# @topics   contributions
#
# @created
#   2001/08/15
#
# @organisation
#   UNILASALLE
#
# @legal
#   UNILASALLE
#   CopyLeft (L) 2001-2002 UNILASALLE, Canoas/RS - Brasil
#   Licensed under GPL (see COPYING.TXT or FSF at www.fsf.org for
#   further details)
#
# @author
#   Rudinei Pereira Dias     [author] [rudinei@lasalle.tche.br]
# 
# @history
#   $Log: barcode.class,v 1.0
#			Modificado dia 28/04/2005 - Rafael Riedel
#			Implementado op��o para gerar como imagem ao inv�s de HTML
#
# @id $Id: barcode.class,v 1.1 2002/10/03 19:14:05 vgartner Exp $
#---------------------------------------------------------------------

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
# Rotina para a gera��o de C�digo de Barra
# no padr�o Interleved 2 of 5 (Intercalado 2 de 5)
# utilizado para os documentos banc�rios conforme
# padr�o FEBRABAN.
#---------------------------------------------------------------------




class BarcodeI25
{    
    //Public properties
    var $codigo;       //SET: Code to transform in barcode / C�digo a converter em c�digo de barras
    var $ebf;          //SET: Width of slim bar / Espessura da barra fina: usar 1 at� 2.
    var $ebg;          //SET: Width of fat bar / Espessura da barra grossa: usar 2x a 3x da esp_barra_fn.
    var $altb;         //SET: Barcode heigth / altura do c�digo de barras
    var $ipp;          //SET: Black point url reference / Endere�o completo da imagem do ponto PRETO p/compor o c�digo de barras
    var $ipb;          //SET: White point url reference / Endere�o completo da imagem do ponto BRANCO p/compor o c�digo de barras
    var $tamanhoTotal; //RETURN: Field to return HTML image barcode total size / Propriedade de RETORNO do tamanho total da imagem do c�digo de barras
	var $ignoreTable;  //SET: if set to true, ignore table construction around barcode
	var $tipoRetorno;  //SET: if set to 0 (or ignored) this code will produce an HTML code, if set to 1, will return an PNG Image 
					   // Se for setado pra 0 (ou ignorado) este codigo ir� produzir um codigo HTML, se tiver setado pra 1, ir� retornar uma imagem PNG 
	
    //Private properties
    var $mixed_code;
    var $bc = array();
    var $bc_string;
	var $errors;
    
    function BarcodeI25($code='')
    {
        //Construtor da classe
	$this->ignoreTable = false;
	$this->errors       = 0;
        $this->ebf          = 1;
        $this->ebg          = 3;
        $this->altb         = 50;
        $this->ipp          = "/home/ubuntu/projetos/administrativo/img/boleto/ponto_preto.gif";
        $this->ipb          = "/home/ubuntu/projetos/administrativo/img/boleto/ponto_branco.gif";
        $this->mixed_code   = "";
        $this->bc_string    = "";
        $this->tamanhoTotal = 0;
	$this->tipoRetorno  = 0; // -> Adicionando esta linha para considerar como padrao HTML
        
        if ( $code !== '' )
        {
            $this->SetCode($code);
        }
    }
    
    function SetCode($code)
    {   global $MIOLO;
	
		$code = trim($code);
        
        if (strlen($code)==0) { 
			echo "C�digo de Barras n�o informado. (Barcode Undefined)";
			$this->errors = $this->errors + 1;
		}
        if ((strlen($code) % 2)!=0) { 
			echo "Tamanho inv�lido de c�digo. Deve ser m�ltiplo de 2. (Invalid barcode lenght)";
			$this->errors = $this->errors + 1;
		}

        if ($this->errors == 0) {
        	$this->codigo = $code;
        }
    }
    
    function GetCode()
    {
        return $this->codigo;
    }
    
    function Generate()
    {   
		if ($this->errors > 0) {
			echo "N�o posso criar o C�digo de Barras: H� erros! (Can't create barcode. There are errors!)";
		}else{
			
			
			
			$this->codigo = trim($this->codigo);
	        
	        $th = "";
	        $new_string = "";
	        $lbc = 0; $xi = 0; $k = 0;
	        $this->bc_string = $this->codigo;
	        
	        //define barcode patterns
	        //0 - Estreita    1 - Larga
	        //Dim bc(60) As String   Obj.DrawWidth = 1
	        
	        $this->bc[0]  = "00110";         //0 digit
	        $this->bc[1]  = "10001";         //1 digit
	        $this->bc[2]  = "01001";         //2 digit
	        $this->bc[3]  = "11000";         //3 digit
	        $this->bc[4]  = "00101";         //4 digit
	        $this->bc[5]  = "10100";         //5 digit
	        $this->bc[6]  = "01100";         //6 digit
	        $this->bc[7]  = "00011";         //7 digit
	        $this->bc[8]  = "10010";         //8 digit
	        $this->bc[9]  = "01010";         //9 digit
	        $this->bc[10] = "0000";          //pre-amble
	        $this->bc[11] = "100";           //post-amble
	        
	        $this->bc_string = strtoupper($this->bc_string);
	        
	        $lbc = strlen($this->bc_string) - 1;
	        
	        //Gera o c�digo com os patterns
	        for( $xi=0; $xi<= $lbc; $xi++ )
	        {
	            $k = (int) substr($this->bc_string,$xi,1);
	            $new_string = $new_string . $this->bc[$k];
	        }
	        
	        $this->bc_string = $new_string;
	        
	        //Faz a mixagem do C�digo
	        $this->MixCode();
	        
	        $this->bc_string = $this->bc[10] . $this->bc_string .$this->bc[11];  //Adding Start and Stop Pattern
	        
	        $lbc = strlen($this->bc_string) - 1;
	        
	        $barra_html="";
	        
			// -> Verificando se � para gerar codigo de barras
			if($this->tipoRetorno == 1) {
				// -> fazendo esse loop para determinar qual ser� o tamanho da imagem
				for( $xi=0; $xi<= $lbc; $xi++ )  {
					$imgWid = ( $this->bc_string[$xi]=="0" ) ? $this->ebf : $this->ebg;
					$this->tamanhoTotal = $this->tamanhoTotal + $imgWid;
				}
				$this->tamanhoTotal = (int) ($this->tamanhoTotal * 1.1);
//                                                                die('morreu');

				// -> Alterando o tipo do conteudo do script para imagem PNG
//				header("Content-type: image/png");
				
				// -> Criando a imagem com o tamanho X e Y
				$barra_imagem = imagecreate($this->tamanhoTotal,$this->altb);
				
				// -> Criando as defini��es de cores. A primeira ja define automaticamente o BG como branco
				$branco = imagecolorallocate($barra_imagem,255,255,255);
				$preto	= imagecolorallocate($barra_imagem,0,0,0);
			}
			
			
			// -> zerando essa variavel, pois ela sera util novamente
			$this->tamanhoTotal = 0;
	        for( $xi=0; $xi<= $lbc; $xi++ )
	        {
	            $imgBar = "";
	            $imgWid = 0;
	            
	            $imgWid = ( $this->bc_string[$xi]=="0" ) ? $this->ebf : $this->ebg;
	            
				// -> verificando se � HTML ou imagem
				if($this->tipoRetorno == 0)	{
					//barra preta, barra branca
					// -> este codigo � somente util quando � HTML
					$imgBar = ( $xi % 2 == 0 ) ? $this->ipp : $this->ipb;
					//criando as barras
					$barra_html = $barra_html .
								  "<img src=\"". $imgBar .
								  "\" width=\"". $imgWid .
								  "\" height=\"". $this->altb .
								  "\" border=\"0\">";
				} else if($this->tipoRetorno == 1) {
					// -> j� este quando � imagem
					$corBarra = ( $xi % 2 == 0 ) ? $preto : $branco;
					
					// -> desenhando as barras					
					for($linx = 1; $linx <= $imgWid; $linx++) 
						// -> como a linha tem 1px, em casos de barras com mais de 1px de largura, desenhando varias linhas uma ao lado da outra para
						// -> formar uma barra mais larga. OBS: barras brancas tamb�m sao desenhadas.
						imageline($barra_imagem, $this->tamanhoTotal+$linx, 0, $this->tamanhoTotal+$linx, $this->altb , $corBarra);	
				
				}
	
	            $this->tamanhoTotal = $this->tamanhoTotal + $imgWid;
	        }
	        
	        $this->tamanhoTotal = (int) ($this->tamanhoTotal * 1.1);
			
			// -> mais uma vez, verificando se � HTML ou imagem
			if($this->tipoRetorno == 0) {
				// -> caso seja HTML, ser� feito o output normal do codigo HTML				
				if (!$this->ignoreTable) {
					$barra_html = "<TABLE BORDER=0 CELLPADDING=0 align='left' CELLSPACING=0 WIDTH=".$this->tamanhoTotal."><TR><TD WIDTH=100%>" .
								   $barra_html . "</TD></TR></TABLE>";
				}
				
				echo "<div align=\"center\">$barra_html</div>\n";
			} else if($this->tipoRetorno == 1) {
				// -> caso seja imagem, gerando o PNG da imagem fazendo o output dela com o imagepng e a destruindo em seguida (afinal, a imagem j� foi gerada)
				// -> dica, para definir outros tipos de imagens, como jpg, gif, etc... basta mudar o imagepng para o image relativo ao tipo. 
				// -> mas sinceramente � besteira colocar outros tipos. png j� da e sobra! 
				
                                imagepng($barra_imagem, "/home/ubuntu/projetos/administrativo/upload/codigoboleto/$this->codigo");
				imagedestroy($barra_imagem);
			}
		}
        
    }//End of drawBrar
    
    function MixCode()
    {
        //Faz a mixagem do valor a ser codificado pelo C�digo de Barras I25
        //Declara��o de Variaveis
        $i = 0; $l = 0; $k = 0;  //inteiro, inteiro, longo
        $s = "";                 //String
        
        $l = strlen( $this->bc_string );
        
        if ( ( $l % 5 ) != 0 || ( $l % 2 ) != 0 )
        {
            $this->barra_html = "<b> C�digo n�o pode ser intercalado: Comprimento inv�lido (mix).</b>";
        }
        else
        {
            $s = "";
            for ( $i = 0; $i< $l; $i += 10 )
            {
                $s = $s . $this->bc_string[$i]   .  $this->bc_string[$i+5];
                $s = $s . $this->bc_string[$i+1] .  $this->bc_string[$i+6];
                $s = $s . $this->bc_string[$i+2] .  $this->bc_string[$i+7];
                $s = $s . $this->bc_string[$i+3] .  $this->bc_string[$i+8];
                $s = $s . $this->bc_string[$i+4] .  $this->bc_string[$i+9];
            }
            $this->bc_string = $s;
        }
    }//End of mixCode
    
}//End of Class

?>
