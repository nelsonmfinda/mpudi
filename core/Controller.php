<?php
	
	/**
	 * @author Lukau Garcia <lukau.dev@gmail.com>
	 */
	
	namespace Core;

	abstract class Controller
	{
		protected $view;
		protected $erros;
		protected $inputs;
		protected $sucesso;
		private $caminhoVisao;
		private $caminhoLayout;
		private $tituloPagina;

		public function __construct(){
			$this->view = new \stdClass;
			if(Sessao::pegaSessao('erros')){
				$this->erros = Sessao::pegaSessao('erros');
				Sessao::destruirSessao('erros');
			}
			if(Sessao::pegaSessao('imputs')){
				$this->imputs = Sessao::pegaSessao('imputs');
				Sessao::destruirSessao('imputs');
			}
			if(Sessao::pegaSessao('sucesso')){
				$this->sucesso = Sessao::pegaSessao('sucesso');
				Sessao::destruirSessao('sucesso');
			}
		}

		/**
		 * Metódo que renderiza a visão para o utilizador
		 * @param  string $caminhoVisao
		 * @param  string $caminhoLayout
		 * @return string
		 */
		protected function rederizarVisao($caminhoVisao, $caminhoLayout = null)
		{
			$this->caminhoVisao = $caminhoVisao;
			$this->caminhoLayout = $caminhoLayout;
			if($caminhoLayout){
				return $this->layout();
			}else{
				return $this->content();
			}
		}

		/**
		 * Metódo que adiciona o conteudo ao layout principal
		 * @return
		 */
		protected function content()
		{
			if(file_exists(__DIR__ . "/../app/Views/{$this->caminhoVisao}.phtml")){
				return require_once __DIR__ . "/../app/Views/{$this->caminhoVisao}.phtml";
			}else{
				echo "Error: Visão não encontrada";
			}
		}

		/**
		 * Metódo que adiciona o layout principal a tela do utilizador
		 * @return
		 */
		protected function layout()
		{
			if(file_exists(__DIR__ . "/../app/Views/{$this->caminhoLayout}.phtml")){
				return require_once __DIR__ . "/../app/Views/{$this->caminhoLayout}.phtml";
			}else{
				echo "Error: Layout não encontrada";
			}
		}

		/**
		 * Metódo que rederiza o utilizador para uma página quando acessa uma URl não permitida
		 * @return URl
		 */
		protected function proibido(){
			return Redirect::rota('/proibido');
		}

		/**
		 * Metódo para alterar o titulo do projecto
		 * @param  string $tituloPagina
		 * @return
		 */
		protected function alteraTituloPagina($tituloPagina){
			$this->tituloPagina = $tituloPagina;
		}

		protected function pegaTituloPagina($separador = null){
			if($separador){
				return $this->tituloPagina . " ". $separador . " ";
			}else{
				return $this->tituloPagina;
			}
		}
	}