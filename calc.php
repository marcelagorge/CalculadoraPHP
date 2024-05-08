<?php
session_start();

class Calculadora {
    public static function calcular($num1, $num2, $operacao) {
        if (!is_numeric($num1) || !is_numeric($num2)) {
            throw new Exception("Entrada inválida. Por favor, insira apenas números.");
        }

        switch ($operacao) {
            case '+':
                return $num1 + $num2;
            case '-':
                return $num1 - $num2;
            case '*':
                return $num1 * $num2;
            case '/':
                if ($num2 != 0) {
                    return $num1 / $num2;
                } else {
                    throw new Exception("Erro: Divisão por zero");
                }
            case '^':
                return pow($num1, $num2);
            case '!':
                return self::fatorial($num1);
            default:
                throw new Exception("Operação inválida");
        }
    }

    public static function fatorial($num) {
        if ($num == 0) {
            return 1;
        } else {
            return $num * self::fatorial($num - 1);
        }
    }
}

if (!empty($_POST['num1']) && !empty($_POST['num2']) && !empty($_POST['operacao'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operacao = $_POST['operacao'];
    try {
        $resultado = Calculadora::calcular($num1, $num2, $operacao);
        $_SESSION['historico'][] = "$num1 $operacao $num2 = $resultado";
    } catch (Exception $e) {
        $resultado = $e->getMessage();
    }
} else {
    $resultado = '';
}

if (isset($_POST['memoria_salvar'])) {
    $_SESSION['memoria'] = array(
        'num1' => $_POST['num1'],
        'num2' => $_POST['num2'],
        'operacao' => $_POST['operacao']
    );
}

if (isset($_POST['memoria_recuperar']) && isset($_SESSION['memoria'])) {
    $num1 = $_SESSION['memoria']['num1'];
    $num2 = $_SESSION['memoria']['num2'];
    $operacao = $_SESSION['memoria']['operacao'];
}

if (isset($_POST['limpar_memoria'])) {
    unset($_SESSION['memoria']);
}

if (isset($_POST['limpar_historico'])) {
    unset($_SESSION['historico']);
    $resultado = ''; 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <style>
        .calculadora {
            width: 300px;
            margin: 50px auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="number"] {
            width: 100px;
        }
        button[type="submit"] {
            background-color: #ff0084;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="style.php">
</head>
<body>


    <div class="calculadora">
    <h1> Calculadora em PHP</h1>
        <form method="POST">
            <input type="number" name="num1" value="<?= isset($num1) ? $num1 : '' ?>" required>
            <select name="operacao">
                <option value="+" <?= isset($operacao) && $operacao == '+' ? 'selected' : '' ?>>+</option>
                <option value="-" <?= isset($operacao) && $operacao == '-' ? 'selected' : '' ?>>-</option>
                <option value="*" <?= isset($operacao) && $operacao == '*' ? 'selected' : '' ?>>*</option>
                <option value="/" <?= isset($operacao) && $operacao == '/' ? 'selected' : '' ?>>/</option>
                <option value="^" <?= isset($operacao) && $operacao == '^' ? 'selected' : '' ?>>^</option>
                <option value="!" <?= isset($operacao) && $operacao == '!' ? 'selected' : '' ?>>!</option>
            </select>
            <input type="number" name="num2" value="<?= isset($num2) ? $num2 : '' ?>" required>
            <button type="submit">Calcular</button>
            <br>
            <button type="submit" name="memoria_salvar">M</button>
            <button type="submit" name="memoria_recuperar">M+</button>
            <button type="submit" name="limpar_memoria">Limpar Memória</button>
            <button type="submit" name="limpar_historico">Limpar Histórico</button>
        </form>
        <br>
        <h3>Resultado: <?= $resultado ?></h3>
        <h3>Memória:</h3>
        <?php if (isset($_SESSION['memoria'])): ?>
            <p><?= $_SESSION['memoria']['num1'] . ' ' . $_SESSION['memoria']['operacao'] . ' ' . $_SESSION['memoria']['num2'] ?></p>
        <?php endif; ?>
        <h3>Histórico:</h3>
        <ul>
            <?php if (isset($_SESSION['historico'])): ?>
                <?php foreach ($_SESSION['historico'] as $operacao): ?>
                    <li><?= $operacao ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
