<?php ?>
<html>
<head>
    <title>Todo - Flightfox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Todo List</h1>
    </header>
    <div class="contents">
        <ul id="list">
            <!-- todos are dynamically loaded here -->
        </ul>
        <h5 id="loader">Loading Todos...</h5>
        <h5 id="empty-todos-state">Add a todo to get started.</h5>
        <form method="post" action="functions.php?method=new_item" onsubmit="return newItem(this);">
            <input name="item" type="text">
            <select name="priority">
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>
            <button>Add Item</button>
        </form>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>