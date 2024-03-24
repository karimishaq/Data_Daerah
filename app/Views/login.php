<html>
    <head>
        <title>Coba</title>
        <link rel="stylesheet" href="<?=base_url('css/styleku.css')?>">
        <style>

            .formku{
                display:flex;
                flex-flow:row wrap;
                width:100vw;
                height:100vh;
                justify-content:center;
                align-items:center;
                background-image:url("<?=base_url('latar.jpg')?>");
                background-size:100% 100%;
            }

            .formku form{
                padding:4px;
                display:flex;
                flex-direction:column;
                width:30%;
                min-height:30%;
                box-shadow:4px 4px 4px;
                border-radius:8px;
                background-color:white;
            }

            .formku input{
                margin-bottom:2px;
            }
        </style>
    </head>
    <body>
        <div class="formku">
            <form action="<?=base_url('login')?>" method="post">
                <h2>Login</h2>
                <div>
                    <?php
                        if(isset($status_login))echo("<p>".$status_login."</p>");
                    ?>
                </div>
                <input type="text" name="nama" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Login">
            </form>
        </div>
    </body>
</html>