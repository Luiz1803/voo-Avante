<?php
$host = 'localhost';
$db = 'agencia_viagens';
$user = 'root'; // altere conforme necessário
$pass = ''; // altere conforme necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="login_process.php" method="POST">
                <div class="input-group">
                    <label for="username">Usuário</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Entrar</button>
                <p class="forgot-password"><a href="#">Esqueceu a senha?</a></p>
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        echo "Usuário ou senha incorretos.";
    }
} else {
    header("Location: login.php");
    exit();
}
?>php
Copiar código
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->query("SELECT p.package_id, p.name AS package_name, d.name AS destination_name, p.description, p.price, p.start_date, p.end_date, p.image_url FROM Packages p JOIN Destinations d ON p.destination_id = d.destination_id");
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacotes de Viagem - Agência de Viagens</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Pacotes de Viagem</h1>
        <?php foreach ($packages as $package): ?>
            <div class="package">
                <h2><?php echo htmlspecialchars($package['package_name']); ?></h2>
                <p>Destino: <?php echo htmlspecialchars($package['destination_name']); ?></p>
                <p><?php echo htmlspecialchars($package['description']); ?></p>
                <p>Preço: R$<?php echo number_format($package['price'], 2, ',', '.'); ?></p>
                <p>Data de Início: <?php echo htmlspecialchars($package['start_date']); ?></p>
                <p>Data de Término: <?php echo htmlspecialchars($package['end_date']); ?></p>
                <img src="<?php echo htmlspecialchars($package['image_url']); ?>" alt="<?php echo htmlspecialchars($package['package_name']); ?>">
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>