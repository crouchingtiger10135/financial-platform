<!DOCTYPE html>
<html>
<head>
    <title>Complete Your Onboarding</title>
</head>
<body>
    <h1>Complete Your Onboarding</h1>
    <p>Click the link below to complete your onboarding process:</p>
    <a href="{{ url('/invitations/' . $invitation->token) }}">Complete Onboarding</a>

    <p>Additionally, you need to complete the identity verification process:</p>
    <a href="{{ route('start-verification', ['client' => $invitation->id]) }}">Start Identity Verification</a>
</body>
</html>
