<h1 class="nombre-pagina">Olvide mi Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación </p>

<?php
    include_once __DIR__ .  "/../templates/alertas.php";
?>

<form action="/olvide" method="POST" class="formulario">
  
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Ingresa tu email"
        />
    </div>
  
    <input type="submit" value="Reestablecer Password" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>