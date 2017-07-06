<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
    <head>
            <title>WebShop</title>
            <style>
            body {margin:0;}

            .topnav {
              overflow: hidden;
              background-color: #333;
            }

            .topnav a {
              float: left;
              display: block;
              color: white;
              text-align: center;
              padding: 14px 16px;
              text-decoration: none;
              font-size: 17px;
            }

            .topnav a:hover {
              background-color: #ddd;
              color: black;
            }

            .topnav a.active {
                background-color: blueviolet;
                color: white;
            }
            .fatxt {
                font-family: futura;
                color: blanchedalmond;
            }
            </style>
    
    </head>
    
    <body style="background-color: black;">
        
        <h1 class="fatxt">Welcome to the WebShop adventurer!</h1>
        
        <div class="topnav">
        <a class="active" href="#home">Login</a>
        <a href="#register">Register</a>
        <a href="#shop">Shop</a>
        <a href="#about">About us</a>
        </div>

        
        <div>
            <h2>
                <b class="fatxt">Login</b>
            </h2>
            <form action="" method="POST">
                <input name="login" type="text" placeholder="Login"/><br>
                <input name="password" type="password" placeholder="Password"/><br>
                <input type="submit" name="zaloguj" value="LOGIN"/>
            </form>            
        </div>
