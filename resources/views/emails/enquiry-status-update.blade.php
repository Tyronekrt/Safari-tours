<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
            <h1 style="color: #2c3e50; margin: 0;">Safari Tours</h1>
        </div>
        
        <div style="background: white; padding: 30px; border-radius: 8px; margin-top: 20px; border: 1px solid #dee2e6;">
            <h2 style="color: #2c3e50;">Enquiry Status Update</h2>
            
            <p>Dear {{ $enquiry->full_name }},</p>
            
            <p>Your safari enquiry (#{{ $enquiry->id }}) status has been updated to:</p>
            
            <div style="background: {{ $status == 'confirmed' ? '#d4edda' : ($status == 'cancelled' ? '#f8d7da' : '#fff3cd') }}; padding: 15px; border-radius: 4px; margin: 20px 0;">
                <strong style="color: {{ $status == 'confirmed' ? '#155724' : ($status == 'cancelled' ? '#721c24' : '#856404') }}; font-size: 18px;">
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </strong>
            </div>
            
            @if($enquiry->package)
            <p><strong>Package:</strong> {{ $enquiry->package->title }}</p>
            @endif
            
            <p><strong>Travel Date:</strong> {{ $enquiry->travel_date ? $enquiry->travel_date->format('F d, Y') : 'Not specified' }}</p>
            
            @if($notes)
            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 20px 0;">
                <p style="margin: 0;"><strong>Notes:</strong></p>
                <p style="margin: 5px 0 0 0;">{{ $notes }}</p>
            </div>
            @endif
            
            @if($status == 'confirmed')
            <div style="background: #d4edda; padding: 15px; border-radius: 4px; margin: 20px 0; text-align: center;">
                <p style="margin: 0; color: #155724;"><strong>🎉 Congratulations! Your safari has been confirmed!</strong></p>
                <p style="margin: 10px 0 0 0; color: #155724;">Our team will contact you shortly with further details.</p>
            </div>
            @elseif($status == 'cancelled')
            <div style="background: #f8d7da; padding: 15px; border-radius: 4px; margin: 20px 0;">
                <p style="margin: 0; color: #721c24;">We apologize, but your enquiry could not be processed at this time.</p>
            </div>
            @endif
            
            <p style="margin-top: 30px;">If you have any questions, please don't hesitate to contact us.</p>
            
            <p style="margin-top: 30px;">Best regards,<br>Safari Tours Team</p>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: #6c757d; font-size: 12px;">
            <p>This is an automated email. Please do not reply directly to this message.</p>
        </div>
    </div>
</body>
</html>
