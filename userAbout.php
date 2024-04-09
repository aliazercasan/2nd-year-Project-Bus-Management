<?php
include("headerUser.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            color: white;
        }

        body {
            background: radial-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url(images/background2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
        }

        .first {
            width: 400px;
            height: 200px;
            padding: 20px;
            border: 1px solid white;
            border-radius: 10px;
            box-shadow: 2px 1px 5px orange inset, 2px 1px 5px orange;
            background: linear-gradient(135deg,rgba(225,225,225,0.1),rgba(225,225,225,0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

        }

        .second {
            width: 400px;
            height: 200px;
            padding: 20px;
            border: 1px solid white;
            border-radius: 10px;
            box-shadow: 2px 1px 5px orange inset, 2px 1px 5px orange;
            background: linear-gradient(135deg,rgba(225,225,225,0.1),rgba(225,225,225,0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .container {
            display: flex;
            justify-content: space-evenly;
        }

        .third {
            width: 400px;
            height: 200px;
            padding: 20px;
            border: 1px solid white;
            border-radius: 10px;
            box-shadow: 2px 1px 5px orange inset, 2px 1px 5px orange;
            background: linear-gradient(135deg,rgba(225,225,225,0.1),rgba(225,225,225,0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        h1{
            margin-top: 50px;
            font-size: 50px;
            letter-spacing: 2px;
            font-family: sans-serif;
            margin-bottom: 100px;
        }
    </style>
</head>

<body>
    <h1> About Us</h1>
    <div class="container">
        <div class="first">
            <p>UniRide is a pioneering company dedicated to revolutionizing bus management solutions. Specializing in streamlining bus terminal operations, UniRide implements cutting-edge logistical planning, innovative technology integration, and superior passenger services to optimize the efficiency and convenience of public transportation. With a commitment to safety, sustainability, and customer satisfaction, UniRide ensures seamless journeys for passengers while driving forward-thinking initiatives that propel the transportation industry into the future.</p><br><br><br>
        </div>
        <div class="second">
            <p>At UniRide, our approach to bus management revolves around efficiency, convenience, and customer satisfaction.
                We begin by meticulously analyzing transportation needs and patterns, allowing us to strategically plan bus routes and schedules that best serve our communities.
                With a focus on infrastructure development, we ensure that our terminals are modern, accessible, and equipped with cutting-edge technology to streamline operations and enhance the passenger experience.
                From automated ticketing systems to real-time tracking apps, we leverage innovation to simplify travel for our passengers.
            </p>
        </div>
        <div class="third">
            Safety is our top priority, and we uphold rigorous standards to protect both passengers and staff. Additionally, our commitment to sustainability drives us to implement eco-friendly practices, such as promoting alternative fuel buses and reducing our carbon footprint. Through efficient financial management and proactive community engagement, we strive to continuously improve our bus management services, making transportation reliable, affordable, and accessible for all.
        </div>
    </div>
</body>

</html>