<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Test</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
  <h2>Login</h2>
  <form id="loginForm">
    <label for="mail">Email:</label>
    <input type="email" id="mail" name="mail" required><br><br>
    
    <label for="constraenia">Contraseña:</label>
    <input type="password" id="constraenia" name="constraenia" required><br><br>
    
    <button type="submit">Iniciar sesión</button>
  </form>

  <p id="response"></p>

  <script>
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const mail = document.getElementById('mail').value;
      const constraenia = document.getElementById('constraenia').value;

      try {
        const response = await axios.post('http://localhost/netflix/NetflixStatistics/backend/api/login.php', {
          mail,
          constraenia
        }, {
          headers: {
            'Content-Type': 'application/json'
          }
        });

        document.getElementById('response').textContent = response.data.message;
      } catch (error) {
        console.log('Error:', error);
        const msg = error.response?.data?.message || 'Error en la solicitud.';
        document.getElementById('response').textContent = msg;
      }
    });
  </script>
</body>
</html>
