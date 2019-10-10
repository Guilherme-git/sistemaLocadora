<?php
	//GERAR PDF DE DESCRIÇÂO DE UMA SERIE
	include 'conexao.php';
	include 'relatorio/vendor/autoload.php';

	use Dompdf\Dompdf;

	$id_serie = $_GET['id_serie'];


	$selecionar_series = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE id_serie=?
	 AND `serie`.`categoria_id` = `categoria`.`id_categoria`"); 
	$selecionar_series->execute(array($id_serie));
	$res = $selecionar_series->fetchAll();

	
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
	$nome_serie = $value['nome_serie'];
	$html.='<tbody>';
	$html.='<tr>';
	$html.= '<td align = center>'.$value['nome_serie'].'</td>';
	$html.= '<td align = center>'.$value['classificacao_serie'].'</td>';
	$html.= '<td align = center>'.$value['nome_categoria'].'</td>';
	$html.= '<td align = center>'.$value['descricao_serie'].'</td>';
	$html.='</tr>';
	$html.='</tbody>';
	}
	$html.='</table>';

	$dompdf = new Dompdf();

	$dompdf->loadHtml("<h1 style= text-align:center>Informações da série $nome_serie</h1>" .$html);

	$dompdf->setPaper('A4', 'portrait');

	$dompdf->render();

	$dompdf->stream('Relatio.pdf', array('Attachment' => false ));

?>