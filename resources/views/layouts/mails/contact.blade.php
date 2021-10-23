<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <style type="text/css">
        .lmailname {
            font-family: 'Roboto Condensed', sans-serif;
        }
    </style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" width="80%">
        <tr>
            <td width="225px">
                <img width="224px" src="{{ asset('storage/'.$contact['logo']) }}" alt="{{ config('app.name', 'Laravel') }}">
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">
                <h4 class="lmailname">Estimado(a): {{ $contact['name_to'] }}</h4>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="20px"></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="class="lmailname"">{!! $contact['message_text'] !!}</div>
            </td>
        </tr>
    </table>
</body>
</html>