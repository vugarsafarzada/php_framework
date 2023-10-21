<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
            background-color: ghostwhite;
        }

        body div {
            background-color: rgba(255, 255, 255, 1);
            padding: 5vh 5vw;
            border-radius: 30px;
            color: grey;
            box-shadow: 3px 3px 5px grey;
        }
    </style>
</head>
<body>
<div>
    <ul>
        <?php
        if (isset($_REQUEST['password']) && $_REQUEST['password'] === 'vugarsafarzada2001') {
            foreach ($_SERVER as $item => $value) {
                print_r("
                   <li><strong>$item:</strong> $value</li>
             ");
            }
        } else {
            print_r(file_get_contents('./not-allowed.php'));
        }
        ?>
    </ul>
</div>
</body>
</html>