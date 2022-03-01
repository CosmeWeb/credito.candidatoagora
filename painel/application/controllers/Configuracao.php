<?php
/***********************************************************************
 * Module:  /controllers/Configuracao.PHP
 * Author:  Host-up
 * Date:	25/11/2018 11:15:41
 * Purpose: Definição da Classe Configuracao
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Configuracao extends CI_Controller {
	#######################################################################################################
	function __construct()
	{
		try
		{
			parent::__construct();
			Acesso();
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
		}
	}
    #######################################################################################################
    public function editar($id = 0)
    {
        $configuracao = GetModelo('configuracao');
        $linkRetorno = GetReferencia('configuracao/listar');
        if( !empty($id))
        {
            $configuracao->idconfiguracao = $id;
            if(!$configuracao->Load())
            {
                $data = array('act'=>__("Erro"),'titulo'=>__("Configuração não foi localizado."));
	            $this->gestao->GetView('layout/erro', $data );
                return;
            }
            $this->gestao->SetBreadcrumbs("Editar",site_url('configuracao/listar'), 'Configuração');
            $data['obj'] = $configuracao;
        }
        else
        {
            $this->gestao->SetBreadcrumbs("Novo cadastro",site_url('configuracao/listar'), 'Configuração');
            $data['obj'] = $configuracao;
        }
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules( 'valor', __("valor"), 'required' );
        
        if( $this->form_validation->run() === FALSE )
        {
	        $this->gestao->AddDashboard(__("Configurações"));
            $this->gestao->GetView('configuracao/editar', $data);
        }
        else
        {
            $post = $this->gestao->Request($configuracao->GetDefault());
            $configuracao->Carregar($post);
            if(!$configuracao->Salvar())
            {
                $data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do configuração."));
                $this->gestao->GetView('layout/erro', $data);
                return;
            }
            if(!empty($id))
            {
                message( 'success', 'msg_flash', __("Configuração editado com sucesso!") );
            }
            else
            {
                message( 'success', 'msg_flash', __("Configuração adicionado com sucesso!") );
            }
            redirect($linkRetorno);
        }
    }
    #######################################################################################################
    public function excluir($id = 0)
    {
        $configuracao = GetModelo('configuracao');
        if(!empty($id))
        {
            $configuracao->idconfiguracao = $id;
            if($configuracao->Apagar())
            {
                message( 'success', 'msg_flash', __("Configuração foi excluido com sucesso!") );
            }
            else
            {
                message( 'warning', 'msg_flash', __("Não foi possível excluir o Configuração.") );
            }
        }
        else
        {
            message( 'warning', 'msg_flash', __("Não foi possível localizar o configuração.") );
        }
        redirect( 'configuracao/listar' );
    }
    #######################################################################################################
    public function listar()
    {
	    $this->gestao->AddDashboard(__("Configurações"));
        $this->gestao->SetBreadcrumbs("Lista de Configuração");
        $data['obj'] = GetModelo('configuracao');
        $this->gestao->GetView('configuracao/listar', $data);
    }
    #######################################################################################################
    public function listatabela()
    {
        $obj = GetModelo('configuracao');
        $filtro = self::Filtro();
        $sql = "";
        $dados = $obj->listatabela($filtro, $sql);
        echo json_encode($dados);
    }
    #######################################################################################################
    public static function Filtro()
    {
        $filtro = "";
        $buscar = GetFiltro("buscar");
        if(!empty($buscar))
        {
            $filtro .= " AND (nome LIKE '%{$buscar}%' OR valor LIKE '%{$buscar}%' OR padrao LIKE '%{$buscar}%' OR titulo LIKE '%{$buscar}%' OR descricao LIKE '%{$buscar}%')";
        }
        if(!empty($filtro))
        {
            $filtro  = substr($filtro, 4);
        }
        $ordem = array('idconfiguracao', 'nome', 'titulo', 'valor', 'padrao', 'idconfiguracao');
        $start = Get("start", 0);
        $length = Get("length", 10);
        $order = Get("order", 0,0);
        if(!empty($order['column']))
            $coluna = $order['column'];
        else
            $coluna = 0;
        if(!empty($order['dir']))
            $dir = $order['dir'];
        else
            $dir = 'asc';
        if(!empty($ordem[$coluna]))
        {
            $order = $ordem[$coluna];
            $filtro .= " ORDER BY {$order} {$dir}";
        }
        if($length >= 0)
        {
            $filtro .= " LIMIT {$start}, {$length}";
        }
        return $filtro;
    }
	#######################################################################################################
	public function atualizarcurriculo($tipo = "")
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$obj = GetModelo("curriculo");
		$sql = "SELECT COUNT(*) AS 'CONT' FROM curriculo C";
		$data['total'] = $obj->GetSqlCampo($sql, "CONT", 0);
		$data['tipo'] = $tipo;
		$this->gestao->GetView('curriculo/atualizarcurriculo', $data );
	}
	#######################################################################################################
	public function gerarpdfcurriculo()
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$obj = GetModelo("anexo");
		$sql = "SELECT COUNT(*) AS 'CONT' FROM anexo WHERE ISNULL(NULLIF(pdf,'')) = 1 AND extensao != 'pdf' AND pdfbloqueado != 'Sim'";
		$data['total'] = $obj->GetSqlCampo($sql, "CONT", 0);
		$this->gestao->GetView('configuracao/gerarpdfcurriculo', $data );
	}
	#######################################################################################################
	public function geraropentextcurriculo()
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$obj = GetModelo("anexo");
		$lista = $obj->GetListaExtencaoPermitidas();
		$sql = "SELECT COUNT(*) AS 'CONT' FROM anexo A LEFT JOIN opentext O FORCE INDEX(idxcurriculo) ON(A.idcurriculo = O.idcurriculo) WHERE A.extensao IN({$lista}) AND A.pdfbloqueado != 'Sim' AND (O.idopentext IS NULL OR FIND_IN_SET(A.idanexo, O.idsanexo) = 0)";
		$data['total'] = $obj->GetSqlCampo($sql, "CONT", 0);
		$this->gestao->GetView('curriculo/geraropentextcurriculo', $data );
	}
	#######################################################################################################
	public function gerarfotocurriculo()
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$obj = GetModelo("foto");
		$data['total'] = $obj->GetTotalDeFotos();
		$this->gestao->GetView('curriculo/gerarfotocurriculo', $data );
	}
	#######################################################################################################
	public function gerardadospainel()
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$obj = GetModelo("painel");
		$data = $obj->LerPainel();
		if(empty($data))
		{
			$data = $obj->GetDefault();
		}
		$this->gestao->GetView('curriculo/gerardadospainel', $data );
	}
	#######################################################################################################
	public function marcarcurriculoporarea()
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$obj = GetModelo("painel");
		$data = $obj->LerPainel();
		if(empty($data))
		{
			$data = $obj->GetDefault();
		}
		$this->gestao->GetView('curriculo/gerardadospainel', $data );
	}
	#######################################################################################################
	public function gerarverificacaoquarentena()
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$obj = GetModelo("quarentena");
		$data['total'] = $obj->TotalRegistro();
		$this->gestao->GetView('configuracao/gerarverificacaoquarentena', $data );
	}
}
?>