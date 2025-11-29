<?php
// Simple contact form handler for LSL Digital
// Make sure this file is uploaded to the same folder as index.html

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form fields safely
    $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $company = isset($_POST['company']) ? trim($_POST['company']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Basic validation
    if ($name === '' || $email === '' || $message === '') {
        // Missing required fields – you could handle this differently if you want
        $error = "Please fill in your name, email and message.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    }

    if (!isset($error)) {
        // Build email
        $to      = 'enquiries@lsldigital.co.uk'; // Where the enquiry goes
        $subject = 'New enquiry from LSL Digital website';

        $body = "New enquiry from LSL Digital website:\r\n\r\n";
        $body .= "Name: {$name}\r\n";
        $body .= "Email: {$email}\r\n";
        $body .= "Company: {$company}\r\n\r\n";
        $body .= "Message:\r\n{$message}\r\n";

        // Basic headers
        $headers   = "From: enquiries@lsldigital.co.uk\r\n";
        $headers  .= "Reply-To: {$email}\r\n";
        $headers  .= "X-Mailer: PHP/" . phpversion();

        // Send email (using PHP's mail function)
        @mail($to, $subject, $body, $headers);

        // Simple thank-you page
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <title>Thank you – LSL Digital</title>
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <link
              href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
              rel="stylesheet"
            />
            <link rel="stylesheet" href="styles.css" />
        </head>
        <body>
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h1 class="h4 mb-3">Thank you</h1>
                                <p class="text-muted mb-3">
                                    Thanks for getting in touch, we’ve received your message and will respond as soon as possible.
                                </p>
                                <a href="index.html" class="btn btn-primary">Back to home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
} else {
    $error = "Invalid request.";
}

// If we hit here, there was an error – show a basic error message.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Contact error – LSL Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">There was a problem</h1>
                    <p class="text-muted mb-3">
                        <?php echo htmlspecialchars($error ?? 'There was a problem submitting your message.', ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <a href="index.html#contact" class="btn btn-primary">Back to contact form</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
