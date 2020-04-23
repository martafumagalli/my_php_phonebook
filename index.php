<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MY PHP PHONEBOOK </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="file://localhost/Users/fumag/Downloads/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="file://localhost/Users/fumag/Downloads/favicon.ico" type="image/x-icon">
</head>
<body>
  
  <?php require_once "connect.php"; ?>  
  <?php include_once "process.php"; ?>

  <header>
    <div>
      <a href="index.php">My PHP PhoneBook<i class="fas fa-phone-alt px-3"></i></a>
    </div>
  </header>

  <div class="container mt-4">
    <div class="row justify-content-center">

      <div class="col">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th class="pl-5">Phone number</th>
              <th></th>
            </tr>
          </thead>
          <?php 
            foreach($records as $record): ?>
            <tr>
              <td><?php echo htmlspecialchars($record['name']); ?></td>
              <td><?php echo htmlspecialchars($record['phone']); ?></td>
              <td>
                <a href="index.php?edit=<?= $record['id']; ?>" class="btn btn-outline-info">Edit</a>
                <a href="process.php?delete=<?= $record['id']; ?>" class="btn btn-outline-primary">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>

      <div class="col">
        <form action="process.php" method="POST" class="form-group mx-4">
          <input type="hidden" name="id" value="<?= $id ?>"/>
          <label><strong>Name</strong></label>
            <input type="text" class="form-control mb-4" name="name" placeholder="Enter a name" value="<?= $name; ?>"/>
          <label><strong>Phone Number</strong></label>
            <input type="text" class="form-control mb-4"  name="phone" placeholder="Enter a phone number" value="<?= $phone; ?>"/>

            <?php 
              if(isset($_SESSION['message'])): ?>  
              <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
                <?php
                  echo $_SESSION['message'];
                  unset($_SESSION['message']);
                ?>
              </div>
            <?php endif ?>

          <?php
            if($updateBtn == true): ?>
              <button type="submit" name="update" class="btn btn-info">Update</button>
            <?php else: ?>  
              <button type="submit" name="add" class="btn btn-primary">Add</button>
          <?php endif ?>
        
        </form>

      </div>
    </div>
  </div>
  <footer>
    <div><i class="fas fa-star-of-life"></i> I am just a simple PHP CRUD application with MySQL and Bootstrap <i class="fas fa-star-of-life"></i></div>
  </footer>
</body>
</html>