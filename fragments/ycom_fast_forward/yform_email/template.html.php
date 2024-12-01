<?php
/** @var rex_fragment $this */
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Corbel, Arial, sans-serif;
            color: #333333;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #dddddd;
        }

        .header {
            background-color: #ff8800;
            padding: 20px;
            text-align: center;
        }

        .header img {
            max-width: 100px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            font-weight: bold;
            font-style: italic;
            color: #ff8800;
        }

        .content p {
            line-height: 1.6;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }

        a {
            color: #ff8800;
            text-decoration: none;
        }
        a.btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff8800;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/wcAAgMBAp1KAAA="
                alt="Logo">
        </div>
        <div class="content">
            <?= $this->subfragment('ycom_fast_forward/yform_email/' . $this->getVar('file', '')) ?>
        </div>
        <div class="footer">
            <p>Impressum: Ihre Firma, Adresse, Kontaktinformationen</p>
        </div>
    </div>
</body>

</html>
