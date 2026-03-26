<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
   <h2>Tasks</h2>
   <a href="/tasks/create" class="btn btn-primary">+ New Task</a>
</div>

<div class="row">
   <div class="col-md-5"><?php if (!empty($tasks)): ?>
         <div class="mb-3">
            <div class="btn-group" role="group">
               <?php
                              $statuses = [
                                 'all' => 'All',
                                 'completed' => 'Completed',
                                 'in-progress' => 'In Progress',
                                 'pending' => 'Pending'
                              ];

                              $colors = [
                                 'all' => 'dark',
                                 'completed' => 'success',
                                 'in-progress' => 'warning',
                                 'pending' => 'secondary'
                              ];

                              foreach ($statuses as $key => $label):
                                 $isActive = $selectedStatus === $key;
                                 $color = $colors[$key];
               ?>
                  <a href="<?= base_url('tasks?status=' . $key) ?>"
                     class="btn <?= $isActive ? 'btn-' . $color : 'btn-outline-' . $color ?>">
                     <?= $label ?>
                  </a>
               <?php endforeach; ?>
            </div>
         </div>
         <table class="table table-striped">
            <thead>
               <tr>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Due Date</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($tasks as $task): ?>
                  <tr>
                     <td><?= esc($task['title']) ?></td>
                     <td>
                        <span class="badge bg-<?= match ($task['status']) {
                                                   'completed' => 'success',
                                                   'in-progress' => 'warning text-dark',
                                                   default => 'secondary',
                                                } ?>"><?= esc($task['status']) ?></span>
                     </td>
                     <td><?= $task['due_date'] ? date('M d, Y', strtotime($task['due_date'])) : '-' ?></td>
                     <td>
                        <a href="/tasks/show/<?= $task['id'] ?>"
                           class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                        <a href="/tasks/edit/<?= $task['id'] ?>"
                           class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <form action="/tasks/delete/<?= $task['id'] ?>" method="post"
                           class="d-inline" onsubmit="return confirm('Delete this task?')">
                           <?= csrf_field() ?>
                           <button type="submit"
                              class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>

         <div class="mt-4 d-flex justify-content-center">
            <div class="custom-pagination-wrapper">
               <?= $pager->links() ?>
            </div>
         </div>
      <?php else: ?>
         <div class="alert alert-info">
            No tasks yet. <a href="/tasks/create">Create your first task</a>.
         </div>
      <?php endif; ?>
   </div>
   <div class="col-md-7">
      <div id="calendar"></div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function() {
      // Get the current status from PHP
      var selectedStatus = '<?= $selectedStatus ?>';

      var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
         initialView: 'dayGridMonth',
         displayEventTime: false,
         themeSystem: 'bootstrap5',
         headerToolbar: {
            left: 'prev,next today',
            center: 'title',
         },

         // Fetch events from API with status filter
         events: function(fetchInfo, successCallback, failureCallback) {
            var url = '<?= base_url("api/tasks") ?>';
            if (selectedStatus && selectedStatus !== 'all') {
               url += '?status=' + selectedStatus;
            }

            fetch(url)
               .then(response => response.json())
               .then(events => {
                  successCallback(events);
               })
               .catch(error => {
                  console.error("Error fetching events:", error);
                  failureCallback(error);
               });
         },

         eventDidMount: function(info) {
            const typeColors = {
               'in-progress': 'bg-warning text-dark',
               'completed': 'bg-success text-dark',
               'pending': 'bg-secondary text-white'
            };

            let type = info.event.extendedProps.status;
            let classes = typeColors[type] || 'bg-primary text-white';
            info.el.classList.add(...classes.split(' '));
         },

         eventClick: function(info) {
            window.location.href = `/tasks/show/${info.event.id}`;
         }
      });

      calendar.render();
   });
</script>
<?= $this->endSection() ?>
