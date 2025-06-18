<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
  <h2>Registro de Usuario</h2>
  <form id="registroForm">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required><br><br>

    <label for="mail">Email:</label>
    <input type="email" id="mail" name="mail" required><br><br>

    <label for="constraenia">Contraseña:</label>
    <input type="password" id="constraenia" name="constraenia" required><br><br>

    <button type="submit">Registrarse</button>
  </form>

  <p id="response"></p>

  <script>
    document.getElementById('registroForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const data = {
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        mail: document.getElementById('mail').value,
        constraenia: document.getElementById('constraenia').value
      };

      try {
        const res = await axios.post('http://localhost/netflix/NetflixStatistics/backend/api/registro.php', data, {
          headers: {
            'Content-Type': 'application/json'
          }
        });

        document.getElementById('response').textContent = res.data.message;
      } catch (error) {
        console.error(error);
        const msg = error.response?.data?.message || 'Error en el registro.';
        document.getElementById('response').textContent = msg;
      }
    });
  </script>
</body>
</html>
