<?php

	require_once("config/globals.php");
	require_once("dao/CategoryDAO.php");
	require_once("dao/ProductDAO.php");
	require_once("classes/Sanitize.php");


	if(!isset($_SESSION)){
		session_start();
	}


	$newCategory = new Category();
	$categoryDAO = new CategoryDAO($pdo);

	$listCategories = $categoryDAO->returnAll();

	if(!isset($_COOKIE['category'])){
		$newCategory->setInCookie('Todos', "$BASE_URL");
	}

	if(isset($_POST['category'])){
		
		$category = $newCategory->sanitize($_POST['category']);

		if($category != $_COOKIE['category']){
			$newCategory->setInCookie($category, "$BASE_URL");
		}	
	}




?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Controle de Estoque</title>
	<link rel="stylesheet" href="<?=$BASE_URL?>css/style.css">
</head>

	<header>
		<div class="container-header">
			
			<nav>
				<ul>
					<li><a href="<?=$BASE_URL?>index.php">Home</a></li>
					<?php if(isset($_SESSION['logged'])):?>
						<li><a href="<?=$BASE_URL?>manager.php"><?=$_SESSION['name']?></a></li>
						
					<?php else:?>	
						<li><a href="<?=$BASE_URL?>login.php">Login</a></li>
					<?php endif?>
				</ul>

				<form action="<?=$BASE_URL?>index.php" method="POST">
					<span>Selecionar Categoria</span>
					<div>
							
						<select name="category" >
							<option value="Todos">Todos</option>
							<?php foreach ($listCategories  as $category): ?>
								
								<?php if($category->getCategory() == $_COOKIE['category']):?>
									<option selected value="<?=$category->getCategory()?>"><?=$category->getCategory()?></option>
								<?php else:?>
									<option value="<?=$category->getCategory()?>"><?=$category->getCategory()?></option>

								<?php endif?>

							<?php endforeach ?>
						</select>

						<input type="submit" value="Selecionar">
					</div>

				</form>

			</nav>
			

		</div>
	</header>