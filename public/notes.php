<?php


include('../app/function.php');

if (!isUserLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_note'])) {
    $content = $_POST['content'];
    saveNotes($user_id, $content);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_note'])) {
    $noteId = $_POST['note_id'];
    $updatecontent = $_POST['update_content'];
    updateNote($noteId, $updatecontent);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_note'])) {

    $noteId = $_POST['note_id'];
    deleteNote($noteId);
}

$notes = getNotes($user_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note APP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-8 bg-white rounded-lg shadow-lg mt-16">

        <h2 class="text-2xl font-bold mb-4">NOTES</h2>

        <?php if (isUserLoggedIn()) : ?>
            <p class="text-gray-600 mb-4">Welcome, <?php echo getUsername(); ?>!</p>
        <?php endif; ?>

        <form action="" method="post" class="mb-4">
            <div class="mb-2">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                    Add Note:
                </label>
                <textarea name="content" rows="3" class="border rounded w-full py-2 px-3"></textarea>
            </div>
            <button type="submit" name="add_note" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                Save Note
            </button>
        </form>

        <hr class="my-6">

        <h3 class="text-xl font-bold mb-4">Your notes</h3>

        <?php if (!empty($notes)) : ?>
            <ul class="list-disc list-inside pl-6">
                <?php foreach ($notes as $note) : ?>
                    <li class="flex justify-between items-center mb-4 ">
                        <span class="text-gray-800"><?php echo $note['content']; ?></span>
                        <div class="flex">

                            <form action="" method="post" class="mr-4">
                                <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                                <input type="text" name="update_content" placeholder="Update notes" required class="border rounded w-40 py-1 px-2">
                                <button type="submit" name="update_note" class="bg-yellow-500 text-white py-1 px-2 rounded hover:bg-yellow-600 focus:outline-none focus:shadow-outline-yellow">
                                    Update
                                </button>
                            </form>

                            <form action="" method="post">
                                <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                                <button type="submit" name="delete_note" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600 focus:outline-none focus:shadow-outline-red">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="text-gray-600">No notes available.</p>
        <?php endif; ?>

        <a href="../app/logout.php" class="bg-gray-500 text-white py-2 px-4 rounded mt-6 hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray">
            Logout
        </a>

    </div>

</body>

</html>