<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Choose Your Account Type</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0; /* Background color for the body */
        }
        
        .header {
            font-size: 24px; /* Font size of the header */
            margin-bottom: 20px; /* Margin bottom for spacing */
        }
        
        .roles {
            display: flex;
            flex-direction: row; /* Set flex direction to row */
            align-items: center;
        }
        
        .roles a {
            text-decoration: none;
            color: #333; /* Color for the text */
            margin: 20px; /* Adjust as needed */
            text-align: center;
        }
        
        .images {
            width: 500%; /* Set image width to 100% */
            height: auto; /* Maintain aspect ratio */
            max-width: 500px; /* Set a maximum width if needed */
        }
        
        @media screen and (max-width: 600px) {
            /* Adjustments for smaller screens */
            .roles {
                flex-direction: column; /* Change flex direction to column */
                align-items: center;
            }
            
            .roles a {
                margin: 10px; /* Adjust margin for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="header">Choose Your Account Type</div>
    <div class="roles">
        <a href="login.php">
            <img src="uploaded_files/Customer1.png" class="images">
            
        </a>
      
        <a href="admin/login.php">
            <img src="uploaded_files/Seller.png" class="images">
            
        </a>
    </div>
</body>
</html>
