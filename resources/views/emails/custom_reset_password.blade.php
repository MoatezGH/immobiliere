<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <h1 style="color:#fc3131">{{ config('app.name') }}</h1>

    <h3>Bienvenu!</h3>

    <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation du mot de passe de votre compte</p>

    <a href="{{ $url }}" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none;">Réinitialiser le mot de passe</a>

    <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise</p>

    <p>Salutations,<br>{{ config('app.name') }}</p>

    <p>
        @lang(
            "Si vous avez des difficultés à cliquer sur le bouton \":actionText\", copiez et collez l'URL ci-dessous\n".
            'dans votre navigateur web :',
            [
                'actionText' => __('Réinitialiser le mot de passe'),
            ]
        ) <a href="{{ $url }}" style="word-break: break-all;">{{ $url }}</a>
    </p>
</body>
</html>