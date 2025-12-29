<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Support Request</title> </head>
<body style="font-family: sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 20px; background-color: #f4f4f4;">
                <table align="center" cellpadding="0" cellspacing="0" border="0" style="width: 600px; background-color: #ffffff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center" style="padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                            <img src="{{ asset('custom-design/images/logo_tc.png')}}" alt="Trauma Club Logo" style="display: block; width: auto; height: 60px; margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 1.1em; margin-top: 0; margin-bottom: 20px; color: #333;"><strong>Hello Admin,</strong></p>
                            <p style="margin-top: 0; margin-bottom: 15px; color: #555;">A new support request has been submitted on your application.</p>
                            <hr style="border: 0; border-top: 1px solid #e0e0e0; margin: 20px 0;">
                            <p style="margin-top: 0; margin-bottom: 10px; color: #555;"><strong>Name:</strong> {{ $formData['name'] ?? 'N/A' }}</p>
                            <p style="margin-top: 0; margin-bottom: 10px; color: #555;"><strong>Email:</strong> {{ $formData['email'] ?? 'N/A' }}</p>
                            <p style="margin-top: 0; margin-bottom: 10px; color: #555;"><strong>Subject:</strong> {{ $formData['subject'] ?? 'N/A' }}</p>
                            <p style="margin-top: 0; margin-bottom: 10px; color: #555;"><strong>Message:</strong></p>
                            <p style="margin-top: 0; margin-bottom: 10px; color: #555;">{{ $formData['message'] ?? 'N/A' }}</p>

                            <p style="margin-top: 30px; margin-bottom: 15px; color: #555;">This message was sent via the support form.</p>
                            <p style="margin-top: 0; margin-bottom: 0; color: #777;">Regards,</p>
                            <p style="margin-top: 0; margin-bottom: 0; color: #777;">laravel 12</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #f9f9f9; border-top: 1px solid #e0e0e0; border-radius: 0 0 5px 5px; font-size: 0.8em; color: #777;">
                            &copy; {{ date('Y') }} satup laravel. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
