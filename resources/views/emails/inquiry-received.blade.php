<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New website enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; color: #071D4A; line-height: 1.5;">
    <h1 style="font-size: 20px;">New website enquiry</h1>
    <p>A contact form submission was saved in the Sahab Logistics dashboard.</p>
    <table cellpadding="6" style="border-collapse: collapse;">
        <tr><td><strong>Name</strong></td><td>{{ $inquiry->name }}</td></tr>
        <tr><td><strong>Company</strong></td><td>{{ $inquiry->company ?: '—' }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $inquiry->email }}</td></tr>
        <tr><td><strong>Phone</strong></td><td dir="ltr">{{ $inquiry->phone }}</td></tr>
        <tr><td><strong>Direction</strong></td><td>{{ $inquiry->directionLabel() }}</td></tr>
        <tr><td><strong>Locale</strong></td><td>{{ $inquiry->locale }}</td></tr>
        <tr><td valign="top"><strong>Message</strong></td><td>{{ $inquiry->message }}</td></tr>
    </table>
</body>
</html>
