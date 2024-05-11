<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<body>

<h3>{{ $mailData['user'] }} whose email: {{ $mailData['email'] }} sent feedback</h3>

<h3>Feedback Subject: {{ trim(substr($mailData['subject'], strpos($mailData['subject'], '>')+1)) }}</h3>

<p>{{ $mailData['message'] }}</p>

<hr/>

<p>--End of Mail --</p>

</body>

</html>
