Hello {{ $name2 }},<br>
Here`s your new Credential in our game and web-panel. You may use it on <a href="{{ url('/') }}" target="_blank">{{ url('/') }}</a> to update your account and characters.
<table>
    <tr>
        <th style="text-align: left">USERNAME</th>
        <th>:</th>
        <td>{{ $name2 }}</td>
    </tr>
    <tr>
        <th style="text-align: left">PASSWORD</th>
        <th>:</th>
        <td>{{ $password2 }}</td>
    </tr>
    <tr>
        <th style="text-align: left">PIN</th>
        <th>:</th>
        <td>{{ $pin }}</td>
    </tr>
    <tr>
        <th style="text-align: left">EMAIL</th>
        <th>:</th>
        <td>{{ $email }}</td>
    </tr>
    <tr>
        <th style="text-align: left">FIRST NAME</th>
        <th>:</th>
        <td>{{ $first_name }}</td>
    </tr>
    <tr>
        <th style="text-align: left">LAST NAME</th>
        <th>:</th>
        <td>{{ $last_name }}</td>
    </tr>
    <tr>
        <th style="text-align: left">SECRET QUESTION</th>
        <th>:</th>
                    @php
                    $sq = [
                        '1' => 'What is the first name of favorite uncle?',
                        '2' => 'Where did you meet spouse?',
                        '3' => 'What is oldest cousin&#39;s name?',
                        '4' => 'What is youngest child&#39;s nickname?',
                        '5' => 'What is oldest child&#39;s nickname?',
                        '6' => 'What is the first name of oldest niece?',
                        '7' => 'What is the first name of oldest nephew?',
                        '8' => 'What is the first name of favorite aunt?',
                        '9' => 'Where did you spend honeymoon?'
                    ];
                    @endphp
        <td>{{ $sq[$secret_question] }}</td>
    </tr>
    <tr>
        <th style="text-align: left">SECRET ANSWER</th>
        <th>:</th>
        <td>{{ $secret_answer }}</td>
    </tr>
</table>