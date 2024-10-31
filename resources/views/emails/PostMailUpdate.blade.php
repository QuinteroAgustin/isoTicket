<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Avancement sur votre ticket</title>
</head>
<div style="background-color: #F7FAFC; padding: 20px; font-family: Arial, sans-serif;">
    <div style="background-color: #FFFFFF; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: auto; max-width: 600px; padding: 20px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <img width="200" src="https://drive.isociel.fr/index.php/s/JjTgXmzkJADz5rD/download/Logo-couleur-Transparent.png" alt="ISOCIEL">
        </div>

        <div>
            <br>
            <br>
            <h1 style="margin: 0 0 15px; font-family: Arial, sans-serif;">Cher client,</h1>
            <p style="margin: 0 0 15px; font-family: Arial, sans-serif;">Votre ticket a du mouvement !</p>
            <p style="margin: 0 0 15px; font-family: Arial, sans-serif;">Le ticket <strong>n°{{ $data['id'] }}</strong> du <strong>{{ $data['date'] }}</strong> à évolué.</p>

            <h2 style="margin: 0 0 15px; font-family: Arial, sans-serif;">{{ $data['titre'] }}</h2>

            <p style="margin: 0 0 15px; font-family: Arial, sans-serif;">
                <ul>
                    <li><strong>Statut:</strong> {{ $data['statut'] }}</li>
                    @if($data['t_nom'] != '')
                    <li><strong>Technicien:</strong> {{ $data['t_nom'] }} {{ $data['t_prenom'] }}</li>
                    @endif
                    <li><strong>Service:</strong> {{ $data['service'] }}</li>
                    <li><strong>Catégorie:</strong> {{ $data['categorie'] }}</li>
                    <li><strong>Fonction:</strong> {{ $data['fonction'] }}</li>
                </ul>
            </p>
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
