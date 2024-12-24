<?php
session_start();
require_once 'init.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user'])) {
   header('Location: login.php');
   exit();
} elseif ($_SESSION['user']['role'] != 'admin') {
   header('Location: dashboard.php');
   exit();
}

// Fetch users
$sql = "SELECT * from utilisateurs";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard - ITThink</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
   <style>
      :root {
         --header-height: 3rem;
         --nav-width: 68px;
         --nav-width-expanded: 200px;
         /* Added for expanded state */
         --first-color: #4723D9;
         --first-color-light: #AFA5D9;
         --white-color: #F7F6FB;
         --body-font: 'Nunito', sans-serif;
         --normal-font-size: 1rem;
         --z-fixed: 100;
      }

      .l-navbar {
         position: fixed;
         top: 0;
         left: 0;
         width: var(--nav-width);
         height: 100vh;
         background-color: var(--first-color);
         padding: 1.5rem 1rem;
         transition: .5s;
         z-index: var(--z-fixed);
      }

      .l-navbar:hover {
         width: var(--nav-width-expanded);
      }

      .nav_logo,
      .nav_link {
         display: flex;
         align-items: center;
         color: var(--white-color);
         text-decoration: none;
         padding: .5rem 1rem;
         margin-bottom: .5rem;
         border-radius: .5rem;
         transition: .3s;
      }

      .nav_logo:hover,
      .nav_link:hover {
         background-color: rgba(255, 255, 255, 0.1);
         color: var(--white-color);
      }

      .nav_icon {
         font-size: 1.5rem;
         margin-right: 1rem;
      }

      .nav_name {
         display: none;
      }

      .l-navbar:hover .nav_name {
         display: block;
      }

      .active {
         background-color: rgba(255, 255, 255, 0.1);
      }

      .welcome-section {
         background: white;
         border-radius: 10px;
         padding: 1.5rem;
         margin-bottom: 2rem;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .stats-card {
         background: white;
         border-radius: 10px;
         padding: 1.5rem;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         transition: transform 0.3s ease;
      }

      .stats-card:hover {
         transform: translateY(-5px);
      }

      main {
         margin-left: var(--nav-width);
         padding: 2rem;
      }
   </style>
</head>

<body>

   <!-- Sidebar -->
   <div class="l-navbar" id="nav-bar">
      <nav class="nav">
            <div>
               <a href="dashboard.php" class="nav_logo">
                  <i class='bx bx-layer nav_logo-icon'></i>
                  <span class="nav_logo-name">ITThink</span>
               </a>
               <div class="nav_list">
                  <a href="dashboard.php" class="nav_link active">
                     <i class='bx bx-grid-alt nav_icon'></i>
                     <span class="nav_name">Dashboard</span>
                  </a>
                  <a href="users.php" class="nav_link">
                     <i class='bx bx-user nav_icon'></i>
                     <span class="nav_name">Users</span>
                  </a>
                  <a href="projects.php" class="nav_link">
                     <i class='bx bx-folder nav_icon'></i>
                     <span class="nav_name">Projects</span>
                  </a>
                  <a href="freelancers.php" class="nav_link">
                     <i class='bx bx-code-alt nav_icon'></i>
                     <span class="nav_name">Freelancers</span>
                  </a>
               </div>
            </div>
         <a href="logout.php" class="nav_link">
            <i class='bx bx-log-out nav_icon'></i>
            <span class="nav_name">SignOut</span>
         </a>
      </nav>
   </div>

   <!-- Main content -->
   <main>
      <div class="container">
         <div class="welcome-section">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['nom_utilisateur']); ?>!</h2>
            <p>Here's your dashboard overview</p>
         </div>
         <!-- Users CRUD -->
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h5 class="card-title">Users</h5>
                  </div>
                  <div class="card-body">
                     <!-- Use DataTables here -->
                     <table id="users" class="table table-striped">
                        <thead>
                           <tr>
                              <th>username</th>
                              <th>email</th>
                              <th>role</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($users as $user) : ?>
                              <tr>
                                 <td><?php echo $user['nom_utilisateur']; ?></td>
                                 <td><?php echo $user['email']; ?></td>
                                 <td><?php
                                    if($user['role'] == "admin") :?>
                                        <span class="badge bg-primary">Admin</span>
                                    <?php elseif($user['role'] == "user") :?>
                                        <span class="badge bg-secondary">User</span>
                                    <?php else :?>
                                        <span class="badge bg-dark">Freelancer</span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <a href="edit_user.php?id=<?php echo $user['id_utilisateur']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="delete_user.php?id=<?php echo $user['id_utilisateur']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </main>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
   <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
   <script>
      $("#users").DataTable({
         "paging": true,
         "ordering": true,
      });
   </script>
</body>

</html>