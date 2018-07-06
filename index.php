<?php
    require_once "@classe-paginas.php";
    $cls_paginas->set_titulo('Página Inicial');
    $cls_paginas->set_descricao('Descrição exemplar!');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $cls_paginas->titulo; ?></title>
        <meta name="description" content="<?php echo $cls_paginas->descricao; ?>">
        <?php require_once "@link-standard-styles.php"; ?>
        <?php require_once "@link-important-functions.php"; ?>
	</head>
	<body>
		<?php
			require_once "includes/header.php";
			require_once "includes/banner-principal.php";
			require_once "includes/box-servicos.php";
			require_once "includes/box-sobre.php";
			require_once "includes/box-formulario.php";
			require_once "includes/footer.php";
		?>
	</body>
	<?php require_once "@link-standard-js.php"; ?>
</html>