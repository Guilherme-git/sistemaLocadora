<?php
	//GERAR PDF DE CLIENTES
	include 'conexao.php';
	include 'relatorio/vendor/autoload.php';

	use Dompdf\Dompdf;


	$selecior_clientes = $pdo->prepare("SELECT * FROM cliente INNER JOIN plano ON `cliente`.`plano_id` = `plano`.`id_plano`"); 
	$selecior_clientes->execute();
	$res = $selecior_clientes->fetchAll();


	$html= '<table border=1 width=100% cellspacing=0 cellpadding=0>';
	$html.= '<thead>';
	$html.= '<tr>';
	$html.= '<th align = center>Nome</th>';
	$html.= '<th align = center>endereço</th>';
	$html.= '<th align = center>Email</th>';
	$html.= '<th align = center>cidade</th>';
	$html.= '<th align = center>Nacimento</th>';
	$html.= '<th align = center>Telefone</th>';
	$html.= '<th align = center>Plano</th>';
	$html.= '</tr>';
	$html.= '</thead>';

	
	foreach ($res as $key => $value) {
	$data_formatada = date("d/m/Y",strtotime($value['nacimento_cliente']));

	$html.='<tbody>';
	$html.='<tr>';
	$html.= '<td align = center>'.$value['nome_cliente'].'</td>';
	$html.= '<td align = center>'.$value['endereco_cliente'].'</td>';
	$html.= '<td align = center>'.$value['email_cliente'].'</td>';
	$html.= '<td align = center>'.$value['cidade_cliente'].'</td>';
	$html.= '<td align = center>'.$data_formatada.'</td>';
	$html.= '<td align = center>'.$value['telefone_cliente'].'</td>';
	$html.= '<td align = center>'.$value['nome_plano'].'</td>';
	$html.='</tr>';
	$html.='</tbody>';
	}
	$html.='</table>';

	$dompdf = new Dompdf();

	$dompdf->loadHtml("<h1 style= text-align:center>Relatório de Clientes</h1>" .$html);

	$dompdf->setPaper('A4', 'portrait');

	$dompdf->render();

	$dompdf->stream('Relatio.pdf', array('Attachment' => false ));




?>