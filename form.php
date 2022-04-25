<?php


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $uniqId = uniqid('');
    $uploadDir = __DIR__ . '/uploads/';
    $uploadFile =  $uploadDir . basename($_FILES['avatar']['name']);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $maxFileSize = 1000000;

    $errors = [];
    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png ou webp!';
    }

    if (
        file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize
    ) {
        $errors[] = "Votre fichier doit faire moins de 1Mo !";
    } else {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }

    $file = basename($_FILES['avatar']['name']);
    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $birthday = $_POST['date'];
}

if (isset($_GET['delete'])) {
    unlink($uploadFile);
    header('location: /form.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Permis Homer</title>
</head>

<body>
    <form class="page" action="" method="post" enctype="multipart/form-data" autocomplete="off">
        <label class="field field_v1">
            <input class="field__input" type="text" name="firstname" placeholder="e.g. Homer">
            <span class="field__label-wrap">
                <span class="field__label">First name</span>
            </span>

        </label>
        <label class="field field_v1">
            <input class="field__input" type="text" name='lastname' placeholder="e.g. Simpson">
            <span class="field__label-wrap">
                <span class="field__label">Last name</span>
            </span>

        </label>
        <label class="field field_v1">
            <input class="field__input" type="date" name='date'>
            <span class="field__label-wrap">
                <span class="field__label">Birth Date</span>
            </span>

        </label>

        <input class="field__input" type="file" name="avatar">
        <button class="button-52" name="send">Send</button>
    </form>

    <?php if (!empty($_FILES)) : ?>
        <?php if (file_exists($uploadFile)) : ?>
            <?= "<a href='form.php?delete'>delete</a>"; ?>
            <?php endif; ?><?php endif; ?>
            <?php if (!empty($errors)) : ?>


                <h1><?php foreach ($errors as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </h1><?php endif; ?>

            <div class="permis"> <?php if (!empty($_FILES)) : ?>


                    <img src="uploads/<?= $file; ?> " alt=""> <?php endif; ?>
                <div class="liste">
                    <ul> <?php if (!empty($_POST)) : ?>


                            <li> Prenom : <?= $firstname; ?></li>
                            <li>Nom : <?= $lastname; ?></li>
                            <li>Date de naissance : <?= $birthday; ?></li> <?php endif; ?>
                    </ul>
                </div>
            </div>
</body>

</html>