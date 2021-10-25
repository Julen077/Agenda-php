<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <form method="POST" action="agenda_hidden.php">
            <label>Introduce tu nombre para la agenda_hidden</label>
            <input type="text" name="nombreusuario_hidden"/>
            <input type="submit"/>
        </form>
        <form method="POST" action="agenda_cookies.php">
            <label>Introduce tu nombre para la agenda_cookies</label>
            <input type="text" name="nombreusuario_cookies"/>
            <input type="submit"/>
        </form>
        <form method="POST" action="agenda_sessions.php">
            <label>Introduce tu nombre para la agenda_sessions</label>
            <input type="text" name="nombreusuario_sessions"/>
            <input type="submit"/>
        </form>
    </body>
</html>