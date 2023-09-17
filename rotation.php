<?php
require('fpdf/fpdf.php');

class PDF_Rotate extends FPDF
{
	var $angle=0;

	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}

	function _endpage()
	{
		if($this->angle!=0)
		{
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}

protected $T128;                                         // Tableau des codes 128
protected $ABCset = "";                                  // jeu des caractères éligibles au C128
protected $Aset = "";                                    // Set A du jeu des caractères éligibles
protected $Bset = "";                                    // Set B du jeu des caractères éligibles
protected $Cset = "";                                    // Set C du jeu des caractères éligibles
protected $SetFrom;                                      // Convertisseur source des jeux vers le tableau
protected $SetTo;                                        // Convertisseur destination des jeux vers le tableau
protected $JStart = array("A"=>103, "B"=>104, "C"=>105); // Caractères de sélection de jeu au début du C128
protected $JSwap = array("A"=>101, "B"=>100, "C"=>99);   // Caractères de changement de jeu

//____________________________ Extension du constructeur _______________________
function __construct($orientation='P', $unit='mm', $format='A4') {

	parent::__construct($orientation,$unit,$format);

	$this->T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]               // composition des caractères
	$this->T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
	$this->T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
	$this->T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
	$this->T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
	$this->T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
	$this->T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
	$this->T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
	$this->T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
	$this->T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
	$this->T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
	$this->T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
	$this->T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
	$this->T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
	$this->T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
	$this->T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
	$this->T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
	$this->T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
	$this->T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
	$this->T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
	$this->T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
	$this->T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
	$this->T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
	$this->T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
	$this->T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
	$this->T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
	$this->T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
	$this->T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
	$this->T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
	$this->T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
	$this->T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
	$this->T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
	$this->T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
	$this->T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
	$this->T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
	$this->T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
	$this->T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
	$this->T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
	$this->T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
	$this->T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
	$this->T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
	$this->T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
	$this->T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
	$this->T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
	$this->T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
	$this->T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
	$this->T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
	$this->T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
	$this->T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
	$this->T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
	$this->T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
	$this->T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
	$this->T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
	$this->T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
	$this->T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
	$this->T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
	$this->T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
	$this->T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
	$this->T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
	$this->T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
	$this->T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
	$this->T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
	$this->T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
	$this->T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
	$this->T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
	$this->T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
	$this->T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
	$this->T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
	$this->T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
	$this->T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
	$this->T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
	$this->T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
	$this->T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
	$this->T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
	$this->T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
	$this->T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
	$this->T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
	$this->T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
	$this->T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
	$this->T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
	$this->T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
	$this->T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
	$this->T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
	$this->T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
	$this->T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
	$this->T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
	$this->T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
	$this->T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
	$this->T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
	$this->T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
	$this->T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
	$this->T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
	$this->T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
	$this->T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
	$this->T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
	$this->T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
	$this->T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
	$this->T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
	$this->T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
	$this->T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
	$this->T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]                
	$this->T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
	$this->T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
	$this->T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
	$this->T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
	$this->T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
	$this->T128[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
	$this->T128[] = array(2, 1);                       //107 : [END BAR]

	for ($i = 32; $i <= 95; $i++) {                                            // jeux de caractères
		$this->ABCset .= chr($i);
	}
	$this->Aset = $this->ABCset;
	$this->Bset = $this->ABCset;
	
	for ($i = 0; $i <= 31; $i++) {
		$this->ABCset .= chr($i);
		$this->Aset .= chr($i);
	}
	for ($i = 96; $i <= 127; $i++) {
		$this->ABCset .= chr($i);
		$this->Bset .= chr($i);
	}
	for ($i = 200; $i <= 210; $i++) {                                           // controle 128
		$this->ABCset .= chr($i);
		$this->Aset .= chr($i);
		$this->Bset .= chr($i);
	}
	$this->Cset="0123456789".chr(206);

	for ($i=0; $i<96; $i++) {                                                   // convertisseurs des jeux A & B
		@$this->SetFrom["A"] .= chr($i);
		@$this->SetFrom["B"] .= chr($i + 32);
		@$this->SetTo["A"] .= chr(($i < 32) ? $i+64 : $i-32);
		@$this->SetTo["B"] .= chr($i);
	}
	for ($i=96; $i<107; $i++) {                                                 // contrôle des jeux A & B
		@$this->SetFrom["A"] .= chr($i + 104);
		@$this->SetFrom["B"] .= chr($i + 104);
		@$this->SetTo["A"] .= chr($i);
		@$this->SetTo["B"] .= chr($i);
	}
}

//________________ Fonction encodage et dessin du code 128 _____________________
function Code128($x, $y, $code, $w, $h) {
	$Aguid = "";                                                                      // Création des guides de choix ABC
	$Bguid = "";
	$Cguid = "";
	for ($i=0; $i < strlen($code); $i++) {
		$needle = substr($code,$i,1);
		$Aguid .= ((strpos($this->Aset,$needle)===false) ? "N" : "O"); 
		$Bguid .= ((strpos($this->Bset,$needle)===false) ? "N" : "O"); 
		$Cguid .= ((strpos($this->Cset,$needle)===false) ? "N" : "O");
	}

	$SminiC = "OOOO";
	$IminiC = 4;

	$crypt = "";
	while ($code > "") {
                                                                                    // BOUCLE PRINCIPALE DE CODAGE
		$i = strpos($Cguid,$SminiC);                                                // forçage du jeu C, si possible
		if ($i!==false) {
			$Aguid [$i] = "N";
			$Bguid [$i] = "N";
		}

		if (substr($Cguid,0,$IminiC) == $SminiC) {                                  // jeu C
			$crypt .= chr(($crypt > "") ? $this->JSwap["C"] : $this->JStart["C"]);  // début Cstart, sinon Cswap
			$made = strpos($Cguid,"N");                                             // étendu du set C
			if ($made === false) {
				$made = strlen($Cguid);
			}
			if (fmod($made,2)==1) {
				$made--;                                                            // seulement un nombre pair
			}
			for ($i=0; $i < $made; $i += 2) {
				$crypt .= chr(strval(substr($code,$i,2)));                          // conversion 2 par 2
			}
			$jeu = "C";
		} else {
			$madeA = strpos($Aguid,"N");                                            // étendu du set A
			if ($madeA === false) {
				$madeA = strlen($Aguid);
			}
			$madeB = strpos($Bguid,"N");                                            // étendu du set B
			if ($madeB === false) {
				$madeB = strlen($Bguid);
			}
			$made = (($madeA < $madeB) ? $madeB : $madeA );                         // étendu traitée
			$jeu = (($madeA < $madeB) ? "B" : "A" );                                // Jeu en cours

			$crypt .= chr(($crypt > "") ? $this->JSwap[$jeu] : $this->JStart[$jeu]); // début start, sinon swap

			$crypt .= strtr(substr($code, 0,$made), $this->SetFrom[$jeu], $this->SetTo[$jeu]); // conversion selon jeu

		}
		$code = substr($code,$made);                                           // raccourcir légende et guides de la zone traitée
		$Aguid = substr($Aguid,$made);
		$Bguid = substr($Bguid,$made);
		$Cguid = substr($Cguid,$made);
	}                                                                          // FIN BOUCLE PRINCIPALE

	$check = ord($crypt[0]);                                                   // calcul de la somme de contrôle
	for ($i=0; $i<strlen($crypt); $i++) {
		$check += (ord($crypt[$i]) * $i);
	}
	$check %= 103;

	$crypt .= chr($check) . chr(106) . chr(107);                               // Chaine cryptée complète

	$i = (strlen($crypt) * 11) - 8;                                            // calcul de la largeur du module
	$modul = $w/$i;

	for ($i=0; $i<strlen($crypt); $i++) {                                      // BOUCLE D'IMPRESSION
		$c = $this->T128[ord($crypt[$i])];
		for ($j=0; $j<count($c); $j++) {
			$this->Rect($x,$y,$c[$j]*$modul,$h,"F");
			$x += ($c[$j++]+$c[$j])*$modul;
		}
	}
}




	
}

class PDF_WriteTag extends FPDF
{
	protected $wLine; // Maximum width of the line
	protected $hLine; // Height of the line
	protected $Text; // Text to display
	protected $border;
	protected $align; // Justification of the text
	protected $fill;
	protected $Padding;
	protected $lPadding;
	protected $tPadding;
	protected $bPadding;
	protected $rPadding;
	protected $TagStyle; // Style for each tag
	protected $Indent;
	protected $Space; // Minimum space between words
	protected $PileStyle; 
	protected $Line2Print; // Line to display
	protected $NextLineBegin; // Buffer between lines 
	protected $TagName;
	protected $Delta; // Maximum width minus width
	protected $StringLength; 
	protected $LineLength;
	protected $wTextLine; // Width minus paddings
	protected $nbSpace; // Number of spaces in the line
	protected $Xini; // Initial position
	protected $href; // Current URL
	protected $TagHref; // URL for a cell

	// Public Functions
	var $angle=0;

	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}

	function _endpage()
	{
		if($this->angle!=0)
		{
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}


	function WriteTag($w, $h, $txt, $border=0, $align="J", $fill=false, $padding=0)
	{
		$this->wLine=$w;
		$this->hLine=$h;
		$this->Text=trim($txt);
		$this->Text=preg_replace("/\n|\r|\t/","",$this->Text);
		$this->border=$border;
		$this->align=$align;
		$this->fill=$fill;
		$this->Padding=$padding;

		$this->Xini=$this->GetX();
		$this->href="";
		$this->PileStyle=array();		
		$this->TagHref=array();
		$this->LastLine=false;
		$this->NextLineBegin=array();

		$this->SetSpace();
		$this->Padding();
		$this->LineLength();
		$this->BorderTop();

		while($this->Text!="")
		{
			$this->MakeLine();
			$this->PrintLine();
		}

		$this->BorderBottom();
	}


	function SetStyle($tag, $family, $style, $size, $color, $indent=-1)
	{
		 $tag=trim($tag);
		 $this->TagStyle[$tag]['family']=trim($family);
		 $this->TagStyle[$tag]['style']=trim($style);
		 $this->TagStyle[$tag]['size']=trim($size);
		 $this->TagStyle[$tag]['color']=trim($color);
		 $this->TagStyle[$tag]['indent']=$indent;
	}


	// Private Functions

	function SetSpace() // Minimal space between words
	{
		$tag=$this->Parser($this->Text);
		$this->FindStyle($tag[2],0);
		$this->DoStyle(0);
		$this->Space=$this->GetStringWidth(" ");
	}


	function Padding()
	{
		if(preg_match("/^.+,/",$this->Padding)) {
			$tab=explode(",",$this->Padding);
			$this->lPadding=$tab[0];
			$this->tPadding=$tab[1];
			if(isset($tab[2]))
				$this->bPadding=$tab[2];
			else
				$this->bPadding=$this->tPadding;
			if(isset($tab[3]))
				$this->rPadding=$tab[3];
			else
				$this->rPadding=$this->lPadding;
		}
		else
		{
			$this->lPadding=$this->Padding;
			$this->tPadding=$this->Padding;
			$this->bPadding=$this->Padding;
			$this->rPadding=$this->Padding;
		}
		if($this->tPadding<$this->LineWidth)
			$this->tPadding=$this->LineWidth;
	}


	function LineLength()
	{
		if($this->wLine==0)
			$this->wLine=$this->w - $this->Xini - $this->rMargin;

		$this->wTextLine = $this->wLine - $this->lPadding - $this->rPadding;
	}


	function BorderTop()
	{
		$border=0;
		if($this->border==1)
			$border="TLR";
		$this->Cell($this->wLine,$this->tPadding,"",$border,0,'C',$this->fill);
		$y=$this->GetY()+$this->tPadding;
		$this->SetXY($this->Xini,$y);
	}


	function BorderBottom()
	{
		$border=0;
		if($this->border==1)
			$border="BLR";
		$this->Cell($this->wLine,$this->bPadding,"",$border,0,'C',$this->fill);
	}


	function DoStyle($tag) // Applies a style
	{
		$tag=trim($tag);
		$this->SetFont($this->TagStyle[$tag]['family'],
			$this->TagStyle[$tag]['style'],
			$this->TagStyle[$tag]['size']);

		$tab=explode(",",$this->TagStyle[$tag]['color']);
		if(count($tab)==1)
			$this->SetTextColor($tab[0]);
		else
			$this->SetTextColor($tab[0],$tab[1],$tab[2]);
	}


	function FindStyle($tag, $ind) // Inheritance from parent elements
	{
		$tag=trim($tag);

		// Family
		if($this->TagStyle[$tag]['family']!="")
			$family=$this->TagStyle[$tag]['family'];
		else
		{
			foreach($this->PileStyle as $val)
			{
				$val=trim($val);
				if($this->TagStyle[$val]['family']!="") {
					$family=$this->TagStyle[$val]['family'];
					break;
				}
			}
		}

		// Style
		$style="";
		$style1=strtoupper($this->TagStyle[$tag]['style']);
		if($style1!="N")
		{
			$bold=false;
			$italic=false;
			$underline=false;
			foreach($this->PileStyle as $val)
			{
				$val=trim($val);
				$style1=strtoupper($this->TagStyle[$val]['style']);
				if($style1=="N")
					break;
				else
				{
					if(strpos($style1,"B")!==false)
						$bold=true;
					if(strpos($style1,"I")!==false)
						$italic=true;
					if(strpos($style1,"U")!==false)
						$underline=true;
				} 
			}
			if($bold)
				$style.="B";
			if($italic)
				$style.="I";
			if($underline)
				$style.="U";
		}

		// Size
		if($this->TagStyle[$tag]['size']!=0)
			$size=$this->TagStyle[$tag]['size'];
		else
		{
			foreach($this->PileStyle as $val)
			{
				$val=trim($val);
				if($this->TagStyle[$val]['size']!=0) {
					$size=$this->TagStyle[$val]['size'];
					break;
				}
			}
		}

		// Color
		if($this->TagStyle[$tag]['color']!="")
			$color=$this->TagStyle[$tag]['color'];
		else
		{
			foreach($this->PileStyle as $val)
			{
				$val=trim($val);
				if($this->TagStyle[$val]['color']!="") {
					$color=$this->TagStyle[$val]['color'];
					break;
				}
			}
		}
		 
		// Result
		$this->TagStyle[$ind]['family']=$family;
		$this->TagStyle[$ind]['style']=$style;
		$this->TagStyle[$ind]['size']=$size;
		$this->TagStyle[$ind]['color']=$color;
		$this->TagStyle[$ind]['indent']=$this->TagStyle[$tag]['indent'];
	}


	function Parser($text)
	{
		$tab=array();
		// Closing tag
		if(preg_match("|^(</([^>]+)>)|",$text,$regs)) {
			$tab[1]="c";
			$tab[2]=trim($regs[2]);
		}
		// Opening tag
		else if(preg_match("|^(<([^>]+)>)|",$text,$regs)) {
			$regs[2]=preg_replace("/^a/","a ",$regs[2]);
			$tab[1]="o";
			$tab[2]=trim($regs[2]);

			// Presence of attributes
			if(preg_match("/(.+) (.+)='(.+)'/",$regs[2])) {
				$tab1=preg_split("/ +/",$regs[2]);
				$tab[2]=trim($tab1[0]);
				foreach($tab1 as $i=>$couple)
				{
					if($i>0) {
						$tab2=explode("=",$couple);
						$tab2[0]=trim($tab2[0]);
						$tab2[1]=trim($tab2[1]);
						$end=strlen($tab2[1])-2;
						$tab[$tab2[0]]=substr($tab2[1],1,$end);
					}
				}
			}
		}
	 	// Space
	 	else if(preg_match("/^( )/",$text,$regs)) {
			$tab[1]="s";
			$tab[2]=' ';
		}
		// Text
		else if(preg_match("/^([^< ]+)/",$text,$regs)) {
			$tab[1]="t";
			$tab[2]=trim($regs[1]);
		}

		$begin=strlen($regs[1]);
 		$end=strlen($text);
 		$text=substr($text, $begin, $end);
		$tab[0]=$text;

		return $tab;
	}


	function MakeLine()
	{
		$this->Text.=" ";
		$this->LineLength=array();
		$this->TagHref=array();
		$Length=0;
		$this->nbSpace=0;

		$i=$this->BeginLine();
		$this->TagName=array();

		if($i==0) {
			$Length=$this->StringLength[0];
			$this->TagName[0]=1;
			$this->TagHref[0]=$this->href;
		}

		while($Length<$this->wTextLine)
		{
			$tab=$this->Parser($this->Text);
			$this->Text=$tab[0];
			if($this->Text=="") {
				$this->LastLine=true;
				break;
			}

			if($tab[1]=="o") {
				array_unshift($this->PileStyle,$tab[2]);
				$this->FindStyle($this->PileStyle[0],$i+1);

				$this->DoStyle($i+1);
				$this->TagName[$i+1]=1;
				if($this->TagStyle[$tab[2]]['indent']!=-1) {
					$Length+=$this->TagStyle[$tab[2]]['indent'];
					$this->Indent=$this->TagStyle[$tab[2]]['indent'];
				}
				if($tab[2]=="a")
					$this->href=$tab['href'];
			}

			if($tab[1]=="c") {
				array_shift($this->PileStyle);
				if(isset($this->PileStyle[0]))
				{
					$this->FindStyle($this->PileStyle[0],$i+1);
					$this->DoStyle($i+1);
				}
				$this->TagName[$i+1]=1;
				if($this->TagStyle[$tab[2]]['indent']!=-1) {
					$this->LastLine=true;
					$this->Text=trim($this->Text);
					break;
				}
				if($tab[2]=="a")
					$this->href="";
			}

			if($tab[1]=="s") {
				$i++;
				$Length+=$this->Space;
				$this->Line2Print[$i]="";
				if($this->href!="")
					$this->TagHref[$i]=$this->href;
			}

			if($tab[1]=="t") {
				$i++;
				$this->StringLength[$i]=$this->GetStringWidth($tab[2]);
				$Length+=$this->StringLength[$i];
				$this->LineLength[$i]=$Length;
				$this->Line2Print[$i]=$tab[2];
				if($this->href!="")
					$this->TagHref[$i]=$this->href;
			 }

		}

		trim($this->Text);
		if($Length>$this->wTextLine || $this->LastLine==true)
			$this->EndLine();
	}


	function BeginLine()
	{
		$this->Line2Print=array();
		$this->StringLength=array();

		if(isset($this->PileStyle[0]))
		{
			$this->FindStyle($this->PileStyle[0],0);
			$this->DoStyle(0);
		}

		if(count($this->NextLineBegin)>0) {
			$this->Line2Print[0]=$this->NextLineBegin['text'];
			$this->StringLength[0]=$this->NextLineBegin['length'];
			$this->NextLineBegin=array();
			$i=0;
		}
		else {
			preg_match("/^(( *(<([^>]+)>)* *)*)(.*)/",$this->Text,$regs);
			$regs[1]=str_replace(" ", "", $regs[1]);
			$this->Text=$regs[1].$regs[5];
			$i=-1;
		}

		return $i;
	}


	function EndLine()
	{
		if(end($this->Line2Print)!="" && $this->LastLine==false) {
			$this->NextLineBegin['text']=array_pop($this->Line2Print);
			$this->NextLineBegin['length']=end($this->StringLength);
			array_pop($this->LineLength);
		}

		while(end($this->Line2Print)==="")
			array_pop($this->Line2Print);

		$this->Delta=$this->wTextLine-end($this->LineLength);

		$this->nbSpace=0;
		for($i=0; $i<count($this->Line2Print); $i++) {
			if($this->Line2Print[$i]=="")
				$this->nbSpace++;
		}
	}


	function PrintLine()
	{
		$border=0;
		if($this->border==1)
			$border="LR";
		$this->Cell($this->wLine,$this->hLine,"",$border,0,'C',$this->fill);
		$y=$this->GetY();
		$this->SetXY($this->Xini+$this->lPadding,$y);

		if($this->Indent!=-1) {
			if($this->Indent!=0)
				$this->Cell($this->Indent,$this->hLine);
			$this->Indent=-1;
		}

		$space=$this->LineAlign();
		$this->DoStyle(0);
		for($i=0; $i<count($this->Line2Print); $i++)
		{
			if(isset($this->TagName[$i]))
				$this->DoStyle($i);
			if(isset($this->TagHref[$i]))
				$href=$this->TagHref[$i];
			else
				$href='';
			if($this->Line2Print[$i]=="")
				$this->Cell($space,$this->hLine,"         ",0,0,'C',false,$href);
			else
				$this->Cell($this->StringLength[$i],$this->hLine,$this->Line2Print[$i],0,0,'C',false,$href);
		}

		$this->LineBreak();
		if($this->LastLine && $this->Text!="")
			$this->EndParagraph();
		$this->LastLine=false;
	}


	function LineAlign()
	{
		$space=$this->Space;
		if($this->align=="J") {
			if($this->nbSpace!=0)
				$space=$this->Space + ($this->Delta/$this->nbSpace);
			if($this->LastLine)
				$space=$this->Space;
		}

		if($this->align=="R")
			$this->Cell($this->Delta,$this->hLine);

		if($this->align=="C")
			$this->Cell($this->Delta/2,$this->hLine);

		return $space;
	}


	function LineBreak()
	{
		$x=$this->Xini;
		$y=$this->GetY()+$this->hLine;
		$this->SetXY($x,$y);
	}


	function EndParagraph()
	{
		$border=0;
		if($this->border==1)
			$border="LR";
		$this->Cell($this->wLine,$this->hLine/2,"",$border,0,'C',$this->fill);
		$x=$this->Xini;
		$y=$this->GetY()+$this->hLine/2;
		$this->SetXY($x,$y);
	}
	function Header()
	{
		//Put the watermark
		$this->SetFont('times','B',100);
		$this->SetTextColor(255,192,203);
		$this->RotatedText(60,95,'RECU',20);
	}

	function RotatedText($x, $y, $txt, $angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}


	function Footer(){
		
		$this->SetFont('Arial','B','8');
		$this->setY(-13);
		
		// $this->SetFont('Arial','','8');
		// $this->cell(0,3,'Date: '.date('d/m/Y'),0,0,'R');
		// $this->cell(0,10,'Page '.$this->PageNo().' / {nb}       ',0,0,'R');
		
	
	}
}


?>
