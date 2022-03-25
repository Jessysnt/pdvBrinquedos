<?php 

	session_start();
	
?>

 <h4>Lançamento</h4>
 <h4><strong><div id="numComanda"></div></strong></h4>
 <table class="table table-bordered table-hover table-condensed" style="text-align: center;">
 	<caption>
 		<span class="btn btn-success" onclick="addComandaNum()"> Criar Comanda
 			<span class="glyphicon glyphicon-usd"></span>
 		</span>
 	</caption>
 	<tr>
 		<td>Nome</td>
 		<td>Descrição</td>
 		<td>Preço</td>
 		<td>Quantidade</td>
 		<td>Remover</td>
 	</tr>
 	<?php 
 	$total=0;//total da venda em dinheiro
 	$numComanda = "";
 		if(isset($_SESSION['tabComprasNumTemp'])):
 			$i=0;
 			foreach (@$_SESSION['tabComprasNumTemp'] as $key) {

 				$d=explode("||", @$key);
 	 ?>

 	<tr>
 		<td><?php echo $d[1]; ?></td>
 		<td><?php echo $d[2]; ?></td>
 		<td><?php echo "R$ ".$d[3]; ?></td>
 		<td><?php echo $d[6]; ?></td>
 		<td>
 			<span class="btn btn-danger btn-xs" onclick="fecharP('<?php echo $i; ?>'), editarP('<?php echo $d[0]; ?>, <?php echo $d[5]; ?>') ">
 				<span class="glyphicon glyphicon-remove"></span>
 			</span>
 		</td>
 	</tr>

 <?php 
 		$calc = $d[3] * $d[6];
 		$total=$total + $calc;
 		$i++;
 		$numComanda=$d[4];
 	}
 	endif; 
 ?>

 	<tr>
 		<td>Total da venda: <?php echo "R$ ".$total; ?></td>
 	</tr>

 </table>

<script type="text/javascript">
    $(document).ready(function(){
        numComanda="<?php echo @$numComanda ?>";
        $('#numComanda').text("Comanda: " + numComanda);
    });
 </script>


