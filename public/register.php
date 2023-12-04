<?php
include('../app/function.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {

            if (isUsernameExists($username)) {
                $error = 'Username already exists. Please choose another username.';
            } else {

                if (registerUser($username, $password)) {
                    header('Location: login.php');
                    exit;
                } else {
                    $error = 'Register failed. Please try again.';
                }
            }
        } else {
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
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-8 bg-white rounded-lg shadow-lg mt-16 max-w-md">

        <h2 class="text-2xl font-bold mb-8">Register</h2>

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
                <input type="password" name="password" id="password" required class="border rounded w-full py-2 px-3">
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                Submit
            </button>
        </form>

        <p class="mt-4">Already have an account? <a href="login.php" class="text-blue-500">Login</a></p>

    </div>

</body>

</html>