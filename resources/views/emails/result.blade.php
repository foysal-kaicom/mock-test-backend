<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JPTBD</title>
</head>
<body>
    <h1>Dear {{ $candidate->first_name }} {{ $candidate->last_name }},</h1>

    <p>Congratulations! Your results for the {{ $examName }} are now available.</p>

    <table border="1" cellpadding="10">
        <tr>
            <th>Listening Score</th>
            <th>Reading Score</th>
            <th>Total Score</th>
        </tr>
        <tr>
            <td>{{ $listeningScore }}</td>
            <td>{{ $readingScore }}</td>
            <td>{{ $totalScore }}</td>
        </tr>
    </table>

    <p>We hope this result helps you in your further studies and career.</p>

    <p>Best regards,</p>
    <p>The Exam Team</p>
</body>
</html>
