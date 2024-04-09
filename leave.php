<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            display: flex;
            justify-content: center;
            margin-top: 100px;
            width: 300px;
            margin-left: 600px;
            border-radius: 10px;
            border: 1px solid red;
            background: linear-gradient(135deg, rgba(225, 225, 225, 0.1), rgba(225, 225, 225, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            text-align: center;
        }

        body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container input {
            margin-top: 10px;
            padding: 5px;
            border-radius: 5px;
            width: 100%;
            margin-left: -5px;
        }

        textarea {
            margin-top: 10px;
            border-radius: 5px;
            width: 200px;
            text-align: center;
            height: 100px;
        }
        h2{
            color: white;
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 25px;
        }
        .back{
            color: white;
            float: left;
            margin-bottom: 10px;
        }
        .back:hover{
            color: red;
        }
        .submit{
            margin-top: 10px;
            width: 35%;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: ease-in-out 0.2s;
        }
        .submit:hover{
            background-color: #80bfff;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="https://api.web3forms.com/submit" method="POST" class="contact-left">
                <h2>Send Message</h2>
            <input type="hidden" name="access_key" value="0d631f86-e406-4d07-aa72-b36f69e01b30">
            <input type="text" name="name" placeholder="Your Name" class="contact-inputs" required><br>
            <input type="email" name="email" placeholder="Your Email" class="contact-inputs" required><br>
            <textarea name="messsage" placeholder="Your message" class="contact-inputs" required></textarea><br>
            <button type="submit" class="submit">Submit</button><br>
            <a href="dashboard.php" class="back">Back</a>
        </form>
        
    </div>
</body>

</html>