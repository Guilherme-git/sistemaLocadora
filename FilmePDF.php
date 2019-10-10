<?php
	//GERAR PDF DE UM FILME
	include 'conexao.php';
	include 'relatorio/vendor/autoload.php';

	use Dompdf\Dompdf;

	$id_filme = $_GET['id_filme'];

	$selecionar_filmes = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE id_filme=?
	 AND `filme`.`categoria_id` = `categoria`.`id_categoria`"); 
	$selecionar_filmes->execute(array($id_filme));;
	$res = $selecionar_filmes->fetchAll();

	
	$html= '<table border=1 width=100% cellspacing=0 cellpadding=0>';
	$html.= '<thead>';
	$html.= '<tr>';
	$html.= '<th align = center>Nome</th>';
	$html.= '<th align = center>Classificação</th>';
	$html.= '<th align = center>Categoria</th>';
	$html.= '<th align = center>Descrição</th>';
	$html.= '</tr>';
	$html.= '</thead>';

	
	foreach ($res as $key => $value) {
	$nome_filme = $value['nome_filme'];
	$html.='<tbody>';
	$html.='<tr>';
	$html.= '<td align = center>'.$value['nome_filme'].'</td>';
	$html.= '<td align = center>'.$value['classificacao_filme'].'</td>';
	$html.= '<td align = center>'.$value['nome_categoria'].'</td>';
	$html.= '<td align = center>'.$value['descricao_filme'].'</td>';
	$html.='</tr>';
	$html.='</tbody>';
	}
	$html.='</table>';

	$dompdf = new Dompdf();

	$dompdf->loadHtml("<h1 style= text-align:center>Descrição completa do filme $nome_filme</h1>" .$html);

	$dompdf->setPaper('A4', 'portrait');

	$dompdf->render();

	$dompdf->stream('Relatio.pdf', array('Attachment' => false ));
?>