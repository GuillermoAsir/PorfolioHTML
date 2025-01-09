# Guardar las credenciales en un archivo XML
$email = Read-Host "Introduce tu correo electrónico"
$password = Read-Host "Introduce tu contraseña" -AsSecureString
$cred = New-Object PSCredential $email, $password
$cred | Export-Clixml -Path "C:\proyecto\PorfolioHTML\credenciales.xml"
