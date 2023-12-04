<?php
include('../app/function.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (loginUser($username, $password)) {
            header('Location: notes.php');
            exit;
        } else {
            $error = 'Login failed. Please check your username and password.';
        }
    } else {
        $error = 'Both username and password are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-8 bg-white rounded-lg shadow-lg mt-16 max-w-md">

        <h2 class="text-2xl font-bold mb-8">Login</h2>

        <?php if (isset($error)) : ?>
            <div class=" text-red-500 mb-6 ">
                <div class="bg-red-100 border-l-4 border-red-500 pl-3">
                    <?php echo $error; ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                    Username:
                </label>
                <input type="text" name="username" id="username" required class="border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                    Password:
                </label>
                <input type="password" name="password" id="password" class="border rounded w-full py-2 px-3">
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                Login
            </button>
        </form>

        <p class="mt-4">Don't have an account? Click <a href="register.php" class="text-blue-500">register</a>
            to make an account</p>

    </div>

</body>

</html>