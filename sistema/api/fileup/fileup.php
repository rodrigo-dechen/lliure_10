<?php/**** API Fileup - Plugin CMS** @Vers�o 5.0* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**//*	no formulario use assim:	$file = new fileup; 					//inicia a classe	$file->titulo = 'Imagem'; 				//titulo da Label	$file->rotulo = 'Selecionar imagem'; 	// texto do bot�o	$file->registro = $dados['imagem'];	$file->campo = 'imagem'; 				//campo do banco de dados (no retorno no formulario ele ir� retornar um $_POST com essa chave, no caso do exemplo $_POST['imagem'])	$file->extencao = 'png jpg'; 			//exten��es permitidas para o upload, se deixar em branco ser� aceita todas	$file->form(); 				 			// executa a classe	No retorno no formulario use assim:	 	$file = new fileup; 											// incia a classe	$file->diretorio = '../../../uploads/porta_niquel/ofertas/';	// pasta para o upload (lembre-se que o caminho � apartir do arquivo onde estiver sedo execultado)	$file->up(); // executa a classe*//*class fileup{	var $campo;	var $titulo = null;	var $registro;	var $extencao = null;	var $diretorio;	var $rotulo = 'Selecionar arquivo';		function form(){		if(!is_array($this->campo)){			$this->titulo = array($this->titulo);			$this->registro = array($this->registro);			$this->campo = array($this->campo);		}				$total_campos = count($this->campo);				if(!is_array($this->rotulo)){			$rotulo = $this->rotulo;			$this->rotulo = array();			for($i = 0; $i < $total_campos; $i++)				$this->rotulo[] = $rotulo;		}				if(!empty($this->extencao)){						if(!is_array($this->extencao)){				$extencao = $this->extencao;				$this->extencao = array();				for($i = 0; $i < $total_campos; $i++){					$this->extencao[] = $extencao;				}			}			$FileUpExt = null;			foreach($this->extencao as $chave => $valor)				$FileUpExt .= (!empty($FileUpExt) ? ',' : '' ).'"'.strtolower($valor).'"' ;		}						echo '<div class="fileUpBloco">';			foreach($this->campo as $chave => $campo){				echo '<div class="fileUpItem">'						.(!empty($this->titulo[$chave])? '<label>'.$this->titulo[$chave].'</label>' : '')						.'<a href="javascript: void(0);" class="fileup_botao">'.$this->rotulo[$chave].'</a>'						.'<input class="fileup_nome" value="'.$this->registro[$chave].'" readonly />'						.'<input type="file" class="fileup_file" rel="'.$chave.'" name="fileup_file['.$chave.']"  />'						.'<input type="hidden" name="fileup_campo['.$chave.']" value="'.$this->campo[$chave].'" />'						.(isset($this->registro[$chave]) ? '<input type="hidden" name="fileup_regant['.$chave.']" value="'.$this->registro[$chave].'" />' : '')							.'</div>';			}				echo '<input type="hidden" name="fileup_total" value="'.$total_campos.'" />'			.'</div>';		?>		<script type="text/javascript">					var FileUpExt = new Array(<?php echo $FileUpExt; ?>);						$('.fileup_botao').click(function(){				$(this).closest('div').find('.fileup_file').click();				});						$('.fileup_file').change(function(){				var base = $(this).closest('div');				var extencao = $(this).val().split('.').pop();				var extencoes = FileUpExt[$(this).attr('rel')];				if(extencoes == '' || fileup_exten(extencao.toLowerCase(), extencoes.split(' '))){					$(base).find('.fileup_nome').val($(this).val());				} else {					jfAlert('Tipo de arquivo n�o permitido');					$(base).find('.fileup_nome').val();				}			});						function fileup_exten(needle, haystack) {				for (var chave in haystack)   					if (haystack[chave] == needle)					return chave;									return false;									}					</script>		<?php	}		function up(){		if(!isset($_FILES['fileup_file']['name'])){			echo 'Arquivo n�o enviado. verifique se o formulario de origem est� setado como <strong>enctype="multipart/form-data"</strong> <br/>';			unset($_POST['fileup_campo'], $_POST['fileup_regant'], $_POST['fileup_file'], $_POST['fileup_total']);						return false;		}				for($chave = 0; $chave < $_POST['fileup_total']; $chave++){								if(!empty($_FILES['fileup_file']['name'][$chave])){										$imagemNome = explode('.', $_FILES['fileup_file']['name'][$chave]);				$extenc = array_pop($imagemNome);				$imagemNome = join(".", $imagemNome);				$imagemNome = jf_urlformat($imagemNome);				$imagemNome = $imagemNome.'_'.substr(md5(time()), rand(0, 20), 8).'.'.$extenc;													if(isset($_POST['fileup_regant'][$chave]))					@unlink($this->diretorio.$_POST['fileup_regant'][$chave]);				move_uploaded_file($_FILES['fileup_file']['tmp_name'][$chave],  $this->diretorio.$imagemNome);				$_POST[$_POST['fileup_campo'][$chave]] = $imagemNome;			}		}		unset($_POST['fileup_campo'], $_POST['fileup_regant'], $_POST['fileup_file'], $_POST['fileup_total']);	}}*/class fileup{        const    BUTTON_INSIDE_LEFT = 0,    BUTTON_INSIDE_RIGHT = 1,    BUTTON_OUTSIDE_LEFT = 2,    BUTTON_OUTSIDE_RIGHT = 3;    private     $id,	$campo = null,                      //obrigatorio	$titulo = null,	$registro = null,	$extencao = null,	$diretorio = null,                  //obrigatorio	$rotulo = 'Selecionar arquivo',    $tema = 0,    $arraytema = array(        'INSIDE_LEFT',        'INSIDE_RIGHT',        'OUTSIDE_LEFT',        'OUTSIDE_RIGHT'    );            private static    $index = 0;        public function __construct() {        $this->id = self::$index++;        lliure::addDocHead('api/fileup/estilo.css');        lliure::addDocFooter('api/fileup/fileup.js');    }        public function setCampo($campo) {        $this->campo = $campo;        return $this;    }    public function setTitulo($titulo) {        $this->titulo = $titulo;        return $this;    }    public function setRegistro($registro) {        $this->registro = $registro;        return $this;    }    public function setExtencao(array $extencao) {        $this->extencao = implode(' ', $extencao);        return $this;    }    public function setDiretorio($diretorio) {        $this->diretorio = $diretorio;        return $this;    }    public function setRotulo($rotulo) {        $this->rotulo = $rotulo;        return $this;    }        public function setTema($tema){        $this->tema = ((is_numeric($tema) && key_exists($tema, $this->arraytema))? $tema: 0);        return $this;    }        public function getCampo() {        return $this->campo;    }    public function getRegistro() {        return $this->registro;    }    public function __toString() {        if (!empty($this->campo) && !empty($this->diretorio))            return             '<div class="fileUpBloco">'.                (!empty($this->titulo)? '<label>'.$this->titulo.'</label>' : '').                '<div class="fileUpItem '.$this->arraytema[$this->tema].'">'.                    '<input class="fileup_file" name="fileup_file_'.$this->id.'" type="file"/>'.                    '<span class="fileup_nome">' . $this->registro . '</span>'.                    '<a href="javascript: void(0);" class="fileup_botao">'.$this->rotulo.'</a>'.                    '<input class="fileup_campo"        name="fileup_campo_'.$this->id.'"      value="'.$this->campo.'"         type="hidden"   />'.                    '<input class="fileup_registro"     name="fileup_registro_'.$this->id.'"   value="'.$this->registro.'"      type="hidden"   />'.                    '<input class="fileup_extencao"     name="fileup_extencao_'.$this->id.'"   value="'.$this->extencao.'"      type="hidden"   />'.                    '<input class="fileup_diretorio"    name="fileup_diretorio_'.$this->id.'"  value="'.$this->diretorio.'"     type="hidden"   />'.                '</div>'.            '</div>';        else            return '<span class="fileup_erro">Falha na configura��o.</span>';    }}?>