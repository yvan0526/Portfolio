<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Données du formulaire
$from = $_POST['email'];
$name = $_POST['name'];
$message = $_POST['message'];

// Email template
$template = file_get_contents('mail_template.html');
$variables = array('$from', '$name', '$message');
$values = array($from, $name, $message);
$htmlMessage = str_replace($variables, $values, $template);

// Envoie de l'email
$mail = new PHPMailer(true);

try {
    // Configuration STMP
    $mail->isSMTP();
    $mail->Host = '';
    $mail->SMTPAuth = true;
    $mail->Username = '';
    $mail->Password = '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Configuration de l'email
    $mail->CharSet = PHPMailer::CHARSET_UTF8;

    // Expéditeur / Destinataires
    $mail->Sender = $from;
    $mail->setFrom($from, $name);
    $mail->addAddress('yvan.giordano@etu.univ-grenoble-alpes.fr', 'Yvan Giordano');
    $mail->addCC($from, $name);

    // Contenu de l'email
    $mail->isHTML(true);
    $mail->Subject = "Portfolio - Yvan Giordano";
    $mail->Body = $htmlMessage;
    $mail->AltBody = $message;

    if (!$mail->send()) {
        $error = $mail->ErrorInfo;
    }
} catch (Exception $e) {
    $error = $mail->ErrorInfo;
}

if (!isset($error)) {
    header("refresh:5;url=contact.html");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset='utf-8'>
    <title>Yvan Giordano</title>
    <link rel='stylesheet' type='text/css' media='screen' href='css/style.css'>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
</head>

<body>
    <header>
        <!-- Barre latérale gauche -->
        <aside>
            <!-- Logo et nom -->
            <section>
                <a href="index.html"><img src="images/logo_contact.png" alt="logo"></a>
                <h2>Yvan Giordano</h2>
            </section>

            <hr>

            <!-- Réseaux sociaux et email -->
            <section>
                <ul>
                    <li><a href="https://www.linkedin.com/in/yvan-giordano-370298a9" target="_blank"><img src="images/social_networks/linked-in.webp" alt="LinkedIn" title="LinkedIn" class="icon">#YvanGiordano</a></li>
                    <li><a href="https://github.com/yvan0526?tab=repositories" target="_blank"><img src="images/social_networks/github.png" alt="Github" title="Github" class="icon">#yvan0526</a></li>
                </ul>

                <p class="email"><img src="images/social_networks/email.svg" alt="Email" title="Email" class="icon">yvan.giordano@etu.univ-grenoble-alpes.fr</p>
            </section>
        </aside>
    </header>

    <main>
        <!-- Menu de navigation -->
        <nav>
            <ul>
                <li><a class="menu-page title" href="index.html">Accueil</a></li>
                <li><a class="menu-page title" href="projects.html">Projets</a></li>
                <li><a class="menu-page active-page title">Contact</a></li>
            </ul>
        </nav>

        <section>
            <h1 class="title">Contactez-moi</h1>

            <section class="response">
                <?php if (isset($error)): ?>
                    <!-- Il y a eu une erreur lors de l'envoie de l'email -->
                    <h2 class="error">Erreur !</h2>
                    <p><?= $error ?></p>
                <?php else: ?>
                    <!-- L'email s'est bien envoyé -->
                    <h2>Message envoyé !</h2>
                    <p>Merci <?= $name ?>, je vous contacterais dès que possible.</p>
                <?php endif; ?>

                <div><a href="contact.html"><input class="button" type="button" value="Retour"></a></div>
            </section>
        </section>
    </main>
</body>

</html>