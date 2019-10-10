<?php
	//GERAR PDF DE SERIES
	include 'conexao.php';
	include 'relatorio/vendor/autoload.php';

	use Dompdf\Dompdf;


	$selecionar_series = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria
	 ON `serie`.`categoria_id` = `categoria`.`id_categoria`"); 
	$selecionar_series->execute();
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

	$dompdf->loadHtml("<h1 style= text-align:center>Relatório de Séries</h1>" .$html);

	$dompdf->setPaper('A4', 'portrait');

	$dompdf->render();

	$dompdf->stream('Relatio.pdf', array('Attachment' => false ));




?>