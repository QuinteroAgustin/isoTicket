<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de votre mot de passe</title>
</head>
<div style="background-color: #F7FAFC; padding: 20px; font-family: Arial, sans-serif;">
    <div style="background-color: #FFFFFF; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: auto; max-width: 600px; padding: 20px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <img width="200" src="https://drive.isociel.fr/index.php/s/JjTgXmzkJADz5rD/download/Logo-couleur-Transparent.png" alt="ISOCIEL">
        </div>

        <div>
            <br>
            <br>
            <h1 style="margin: 0 0 15px; font-family: Arial, sans-serif;">Bonjour,</h1>
            <p style="margin: 0 0 15px; font-family: Arial, sans-serif;">Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
            <br>
            <a href="{{ url('/password/reset/' . $data['token']) }}">Réinitialiser le mot de passe</a>
            <br>
            <br>
            <p style="margin: 0 0 15px; font-family: Arial, sans-serif;">Cordialement,</p>
            <p style="margin: 0 0 15px; font-family: Arial, sans-serif;">L'équipe du support Isociel</p>
        </div>
    </div>
    <div style="text-align: center; font-size: 14px; color: #718096; margin-top: 20px; font-family: Arial, sans-serif;">
        &copy; {{ date('Y') }} Isociel. Tous droits réservés.
    </div>
</div>
</html>
