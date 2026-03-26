<!DOCTYPE html>
<html lang="en">


<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= esc($title ?? 'Task Manager') ?></title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



   <style>
      .custom-pagination-wrapper .pagination {
         list-style: none;
         display: flex;
         justify-content: center;
         gap: 8px;
         padding: 0;
         margin: 20px 0;
      }

      .custom-pagination-wrapper .pagination li {
         display: inline-block;
      }

      .custom-pagination-wrapper .pagination a {
         display: block;
         padding: 8px 14px;
         text-decoration: none;
         border: 1px solid #ddd;
         border-radius: 6px;
         color: #333;
         font-size: 14px;
         transition: all 0.2s ease;
      }

      /* Hover */
      .custom-pagination-wrapper .pagination a:hover {
         background-color: #007bff;
         color: #fff;
         border-color: #007bff;
      }

      /* Active page */
      .custom-pagination-wrapper .pagination li.active a {
         background-color: #007bff;
         color: #fff;
         border-color: #007bff;
         font-weight: bold;
      }

      /* Optional: disabled (if you add prev/next later) */
      .custom-pagination-wrapper .pagination li.disabled a {
         color: #aaa;
         pointer-events: none;
         background-color: #f5f5f5;
      }
   </style>
</head>


<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container">
         <a class="navbar-brand" href="/">Task Manager</a>
         <div class="navbar-nav">
            <?php if (session()->get('logged_in')): ?>
               <a class="nav-link" href="/tasks">Tasks</a>
               <a class="nav-link" href="/tasks/create">New Task</a>
               <a class="nav-link" href="/logout">
                  Logout (<?= esc(session()->get('user_name')) ?>)
               </a>
            <?php else: ?>
               <a class="nav-link" href="/login">Login</a>
               <a class="nav-link" href="/register">Register</a>
            <?php endif; ?>
         </div>
      </div>
   </nav>
   <div class="container">
      <?php if (session()->getFlashdata('message')): ?>
         <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
         </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('errors')): ?>
         <div class="alert alert-danger">
            <ul class="mb-0">
               <?php foreach (session()->getFlashdata('errors') as $err): ?>
                  <li><?= esc($err) ?></li>
               <?php endforeach; ?>
            </ul>
         </div>
      <?php endif; ?>
      <?= $this->renderSection('content') ?>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js'></script>
</body>


</html>
