<?php 
	include_once 'includes/config.php';
	$pages = 'dashboard';
?>
		<section class="content_left">
			<!-- Chama o menu da página-->
			<?php require 'includes/left.php';?>
		</section>
		
		<section class="content_right">
			<!-- Chama o cabeçalho da página-->
			<?php require 'includes/header.php';?>
	
			<article class="bgcolor-white">
				<img src="<?= $configBase ?><?= $themePathSite ?>/images/loogo.png" alt="Logo da Empresa" title="Logo da Empresa">
				
				<?php
					$Read = $pdo->prepare(query:"SELECT cliente_id, cliente_status FROM si_clientes WHERE cliente_status = :cliente_status");
					
					$Read -> bindValue(param:'cliente_status', value:1);
					$Read -> execute();
					
					$Lines = $Read-> rowCount();

					if($Lines < 10){
						$Count = '000'.$Lines;
					}elseif($Lines >= 10 && $Lines < 100){
						$Count = '00'.$Lines;
					}elseif($Lines >= 100 && $Lines < 1000){
						$Count = '0'.$Lines;
					}else{
						$Count = $Lines;
					}

				?>

				<div class="divisor3 cards bgcolor-blue-dark">
					<p class="color-white font-text-min text-center">Clientes</p>
					<p class="color-white text-center font-weight-max title"> <?= $Count ?></p>
				</div>
				
				<?php
					$Read = $pdo->prepare(query:"SELECT fornecedor_id, fornecedor_status FROM si_fornecedores WHERE fornecedor_status = :fornecedor_status");
					
					$Read -> bindValue(param:'fornecedor_status', value:1);
					$Read -> execute();
					
					$Lines = $Read-> rowCount();

					if($Lines < 10){
						$Count = '000'.$Lines;
					}elseif($Lines >= 10 && $Lines < 100){
						$Count = '00'.$Lines;
					}elseif($Lines >= 100 && $Lines < 1000){
						$Count = '0'.$Lines;
					}else{
						$Count = $Lines;
					}

				?>
				
				<div class="divisor3 cards bgcolor-blue-dark">
					<p class="color-white font-text-min text-center">Fornecedores</p>
					<p class="color-white text-center font-weight-max title"><?= $Count ?></p>
				</div>

				<?php
					$Read = $pdo->prepare(query:"SELECT usuarios_id, usuarios_status FROM si_usuarios WHERE usuarios_status = :usuarios_status");
					
					$Read -> bindValue(param:'usuarios_status', value:1);
					$Read -> execute();
					
					$Lines = $Read-> rowCount();

					if($Lines < 10){
						$Count = '000'.$Lines;
					}elseif($Lines >= 10 && $Lines < 100){
						$Count = '00'.$Lines;
					}elseif($Lines >= 100 && $Lines < 1000){
						$Count = '0'.$Lines;
					}else{
						$Count = $Lines;
					}

				?>
				
				<div class="divisor3 cards bgcolor-blue-dark">
					<p class="color-white font-text-min text-center">Usuários</p>
					<p class="color-white text-center font-weight-max title"><?= $Count ?></p>
				</div>

				<?php
					$Read = $pdo->prepare(query:"SELECT produto_id, produto_status FROM si_produtos WHERE produto_status = :produto_status");
					
					$Read -> bindValue(param:'produto_status', value:1);
					$Read -> execute();
					
					$Lines = $Read-> rowCount();

					if($Lines < 10){
						$Count = '000'.$Lines;
					}elseif($Lines >= 10 && $Lines < 100){
						$Count = '00'.$Lines;
					}elseif($Lines >= 100 && $Lines < 1000){
						$Count = '0'.$Lines;
					}else{
						$Count = $Lines;
					}

				?>
				
				<div class="divisor3 cards bgcolor-blue-dark">
					<p class="color-white font-text-min text-center">Produtos</p>
					<p class="color-white text-center font-weight-max title"><?= $Count ?></p>
				</div>
				
				<?php
					$Read = $pdo->prepare(query:"SELECT pedido_id, pedido_status FROM si_pedidos WHERE pedido_status = :pedido_status");
					
					$Read -> bindValue(param:'pedido_status', value:1); 
					$Read -> execute();
					
					$Lines = $Read-> rowCount();

					if($Lines < 10){
						$Count = '000'.$Lines;
					}elseif($Lines >= 10 && $Lines < 100){
						$Count = '00'.$Lines;
					}elseif($Lines >= 100 && $Lines < 1000){
						$Count = '0'.$Lines;
					}else{
						$Count = $Lines;
					}

				?>

				<div class="divisor3 cards bgcolor-blue-dark">
					<p class="color-white font-text-min text-center">Pedidos</p>
					<p class="color-white text-center font-weight-max title"><?= $Count ?></p>
				</div>
				
				<?php
					$Read = $pdo->prepare(query:"SELECT pedido_id, pedido_despachado, pedido_status FROM si_pedidos WHERE pedido_status = :pedido_status AND pedido_despachado = :pedido_despachado");
					
					$Read -> bindValue(param:'pedido_status', value:1); 
					$Read -> bindValue(param:'pedido_despachado', value: 1); //1 = despachado; 0 = não despachado
					$Read -> execute();
					
					$Lines = $Read-> rowCount();

					if($Lines < 10){
						$Count = '000'.$Lines;
					}elseif($Lines >= 10 && $Lines < 100){
						$Count = '00'.$Lines;
					}elseif($Lines >= 100 && $Lines < 1000){
						$Count = '0'.$Lines;
					}else{
						$Count = $Lines;
					}

				?>

				<div class="divisor3 cards bgcolor-blue-dark">
					<p class="color-white font-text-min text-center">Despachados</p>
					<p class="color-white text-center font-weight-max title"><?= $Count ?></p>
				</div>
				
				<div class="clear"></div>
			</article>
			
			<div class="clear"></div>
			<div class="espaco-min"></div>
		</section>
	<div class="clear"></div>