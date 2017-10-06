<html>
<head>
  <title>Registrierung</title>
</head>
<body>
  <h1>Registrierung<h1>
    <form name="registration" method="post">
      <select name="gender">
      <<option value="male">Herr</option>
      <<option value="female">Frau</option>
      </select>
      Vorname: <input type="text" name="firstname"/><br />
      Nachname: <input type="text" name="lastname"/><br />
      Addresse: <input type="text" name="address"/><br />
      PLZ: <input type="text" name="zipCode"/>
      Ort: <input type="text" name="city" /><br />
      Email: <input type="email" name="email" /><br />
      Passwort <input type="password" name="password" /><br />
      Passwort wiederholen: <input type="password" name="passwordCtrl" /><br />      
      <button type="submit">Registrieren</button>
  </form>
</body>
</html>
