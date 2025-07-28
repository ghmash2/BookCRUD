<head>
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <div class="form-container">
        <form action="index.php" method="post">
            <h2>Register</h2>
            <div class="form-group">
                <label for="name">User Name: </label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="text" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="image">Upload Image: </label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <button class="btn" style=" background-color: green;" type="submit" name="register"
                value=register>Register</button>

        </form>
    </div>

</body>