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
if(isset($_GET['id'])){
    $id_utilisateur = $_GET['id'];
    $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_utilisateur' => $id_utilisateur]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$user){
        header('Location: users.php');
        exit();
    }
}
if(isset($_POST['update'])){
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $role = $_POST['role'];

    $sql = "UPDATE utilisateurs SET role = :role,nom_utilisateur = :nom_utilisateur WHERE id_utilisateur = :id_utilisateur";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['role' => $role, 'nom_utilisateur' => $nom_utilisateur , 'id_utilisateur' => $id_utilisateur]);

    header('Location: users.php');
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
            <!-- Edit User Form -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit User</h4>
                        </div>
                        <form action="edit_user.php" method="POST">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="nom_utilisateur">Username</label>
                                    <input type="text" name="nom_utilisateur" id="nom_utilisateur" class="form-control"
                                    value="<?=$user['nom_utilisateur'];?>" required>
                                    <label for="role">role</label>
                                    <select name="role" id="role" class="form-control" required value="<?=$user['nom_utilisateur'];?> ">
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                        <option value="freelancer">Freelancer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="update">Update User</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>