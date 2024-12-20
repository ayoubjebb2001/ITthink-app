<?php
session_start();
require_once 'init.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
   header('Location: login.php');
   exit();
}

$today = Date('Y-m-d');
// Fetch statistics
$stats = [
   'users' => $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn(),
   'projects' => $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn(),
   'freelancers' => $pdo->query("SELECT COUNT(*) FROM freelances")->fetchColumn(),
   'pending_offers' => $pdo->query("SELECT COUNT(*) FROM offres WHERE delai < $today ")->fetchColumn()
];

$pending_offers = $pdo->query("SELECT nom_utilisateur as project_owner,titre_projet,montant,delai,nom_freelance FROM utilisateurs NATURAL JOIN projets NATURAL JOIN offres NATURAL JOIN freelances
                                 WHERE delai < $today")->fetchAll(PDO::FETCH_ASSOC);
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
            <a href="#" class="nav_logo">
               <i class='bx bx-layer nav_logo-icon'></i>
               <span class="nav_logo-name">ITThink</span>
            </a>
            <div class="nav_list">
               <a href="#" class="nav_link active">
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
         <!-- Statistics Cards -->
         <div class="row mb-4">
            <div class="col-md-3">
               <div class="stats-card">
                  <h3><?php echo $stats['users']; ?></h3>
                  <p>Total Users</p>
                  <i class='bx bx-user'></i>
               </div>
            </div>
            <div class="col-md-3">
               <div class="stats-card">
                  <h3><?php echo $stats['projects']; ?></h3>
                  <p>Active Projects</p>
                  <i class='bx bx-folder'></i>
               </div>
            </div>
            <div class="col-md-3">
               <div class="stats-card">
                  <h3><?php echo $stats['freelancers']; ?></h3>
                  <p>Freelancers</p>
                  <i class='bx bx-code-alt'></i>
               </div>
            </div>
            <div class="col-md-3">
               <div class="stats-card">
                  <h3><?php echo $stats['pending_offers']; ?></h3>
                  <p>Pending Offers</p>
                  <i class='bx bx-time'></i>
               </div>
            </div>
         </div>

         <!-- Recent Activity -->
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h5 class="card-title">Pending Offers</h5>
                  </div>
                  <div class="card-body">
                     <!-- Use DataTables here -->
                     <table id="offers" class="table table-striped">
                        <thead>
                           <tr>
                              <th>Project Owner</th>
                              <th>Project Title</th>
                              <th>Amount</th>
                              <th>Deadline</th>
                              <th>Freelancer</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($pending_offers as $offer) : ?>
                              <tr>
                                 <td><?php echo $offer['project_owner']; ?></td>
                                 <td><?php echo $offer['titre_projet']; ?></td>
                                 <td><?php echo $offer['montant']; ?></td>
                                 <td><?php echo $offer['delai']; ?></td>
                                 <td><?php echo $offer['nom_freelance']; ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     <!-- Add offers table here -->
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
      $("#offers").DataTable({
         "paging": true,
         "ordering": true,
         "info": true
      });
   </script>
</body>

</html>