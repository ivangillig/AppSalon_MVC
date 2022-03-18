<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<?php
    include_once __DIR__ .  "/../templates/alertas.php";
?>

<!-- Si el token es incorrecto no muestra el formulario -->
<?php  if($error) return; ?> 

<form class="formulario" method="POST" >
    
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu password"
            name="password" 
        />

    </div>

    <input type="submit" class="boton" value="Reestablecer">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Iniciar sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>