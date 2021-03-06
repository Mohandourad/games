<?php

$catTable = App::getInstance()->getTable('Category');

if (isset($_POST['action'])) {
	if(!empty($_POST['nom']) && !empty($_FILES['img']['name']) && !empty($_FILES['img']['tmp_name'])) {

		$name = $_FILES['img']['name'];
		$tmpName = $_FILES['img']['tmp_name'];
		$ext = strrchr($name, ".");
		$errors = $_FILES['img']['error'];
		$dest = './img/cat/' . $name;
		$goodExt = array('.jpg', '.png');
		
		if(in_array($ext, $goodExt)) {
			if ($errors == 0) {
				if (move_uploaded_file($tmpName, $dest)) {
					$result = $catTable->create([
						'nom' => $_POST['nom'],
						'img' => $dest				
						]);
					if($result) {
						header('Location: admin.php?p=categories.index');
					} else {
						?>
						<div class="card-panel red lighten-2">
							Erreur : la catégorie n'a pas été ajoutée.
						</div>
						<?php
					}
				} else {
					?>
					<div class="card-panel red lighten-2">
						Erreur : non uploader.
					</div>
					<?php
				}
			} else {
				?>
				<div class="card-panel red lighten-2">
					Erreur : veuillez reuploader l'image.
				</div>
				<?php
			}
		} else {
		?>
		<div class="card-panel red lighten-2">
			Erreur : format d'image incorrect.
		</div>
		<?php
		}
	} else {
		?>
		<div class="card-panel red lighten-2">
			Erreur : Tout les champs sont obligatoires.
		</div>
		<?php
	}
}

$form = new \Core\HTML\MaterialiseForm($_POST);

?>

<form method="post" class="col s12" enctype="multipart/form-data">
		<?= $form->input('nom', 'Titre'); ?>
		<?= $form->input('img', 'Image', ['type' => 'file']); ?>
	<div class="row">
		<button class="btn waves-effect waves-light" type="submit" name="action">Sauvegarder</button>
	</div>
</form>