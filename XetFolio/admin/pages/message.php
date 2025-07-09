<?php
require_once __DIR__.'/../class.user.php';

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

$user = new USER();
$pdo = $user->getConnection();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$limit = 10;
$page  = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalStmt     = $pdo->query("SELECT COUNT(*) FROM message");
$totalMessages = $totalStmt->fetchColumn();
$totalPages    = ceil($totalMessages / $limit);

$stmt = $pdo->prepare("
    SELECT id, name, email, subject, message, created_at
    FROM message
    ORDER BY created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="col-10 content-area">
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Messages</h2>
      <button class="btn btn-success" data-toggle="modal" data-target="#composeModal">Compose</button>
    </div>

    <div class="input-group mb-3">
      <input type="text" id="searchInput" class="form-control" placeholder="Search messages...">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
      </div>
    </div>

    <div id="message-list">
      <?php if (count($messages) > 0): ?>
        <?php foreach ($messages as $row): ?>
          <div class="card mb-2 message-item"
               data-id="<?= $row['id'] ?>"
               data-name="<?= htmlspecialchars($row['name']) ?>"
               data-email="<?= htmlspecialchars($row['email']) ?>"
               data-subject="<?= htmlspecialchars($row['subject']) ?>"
               data-message="<?= htmlspecialchars($row['message']) ?>"
               data-date="<?= htmlspecialchars($row['created_at']) ?>">
            <div class="card-body">
              <div class="float-right">
                <button class="btn btn-sm btn-primary reply-message mr-2">Reply</button>
                <button class="btn btn-sm btn-danger delete-message">Delete</button>
              </div>
              <h5 class="card-title mb-1"><?= htmlspecialchars($row['subject']) ?></h5>
              <h6 class="card-subtitle mb-1 text-muted">
                From: <?= htmlspecialchars($row['name']) ?> &lt;<?= htmlspecialchars($row['email']) ?>&gt;
              </h6>
              <p class="card-text text-truncate mb-1">
                <?= htmlspecialchars(mb_strimwidth($row['message'], 0, 100, '...')) ?>
              </p>
              <small class="text-muted">
                <?= date('M d, Y h:i A', strtotime($row['created_at'])) ?>
              </small>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-info">No messages found.</div>
      <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <nav>
        <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
            </li>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
          <?php if ($page < $totalPages): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</div>

<!-- Message Detail Modal -->
<div class="modal fade" id="messageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Message Detail</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="mb-3"><strong>Name:</strong> <span id="modalName"></span></div>
        <div class="mb-3"><strong>Email:</strong> <span id="modalEmail"></span></div>
        <div class="mb-3"><strong>Subject:</strong> <span id="modalSubject"></span></div>
        <div class="mb-3"><strong>Date:</strong> <span id="modalDate"></span></div>
        <hr>
        <div class="mb-3">
          <strong>Message:</strong>
          <p id="modalMessage" class="mt-2 bg-light p-3 rounded"></p>
        </div>
      </div>
      <div class="modal-footer">
        <button id="replyBtn" class="btn btn-primary">Reply</button>
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Compose Modal -->
<div class="modal fade" id="composeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="composeForm" method="post" action="send_message.php">
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
        <div class="modal-header">
          <h5 class="modal-title">Compose Message</h5>
          <button class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="toEmail">To:</label>
            <input type="email" name="to" class="form-control" id="toEmail" required>
          </div>
          <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" class="form-control" id="subject" required>
          </div>
          <div class="form-group">
            <label for="messageContent">Message:</label>
            <textarea name="message" class="form-control" id="messageContent" rows="8" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Send Message</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // expose CSRF token to JS
  const csrfToken = '<?= $csrfToken ?>';
 $(document).ready(function() {
     $(function () {
    // Show detail modal
    $('.message-item').on('click', function (e) {
      if ($(e.target).is('.delete-message, .reply-message')) return;
      const item = $(this);
      $('#modalName').text(item.data('name'));
      $('#modalEmail').text(item.data('email'));
      $('#modalSubject').text(item.data('subject'));
      $('#modalDate').text(new Date(item.data('date')).toLocaleString());
      $('#modalMessage').text(item.data('message'));
      $('#messageModal').modal('show');
    });

    // SweetAlert delete
    $('.delete-message').on('click', function (e) {
      e.stopPropagation();
      const item = $(this).closest('.message-item');
      const id   = item.data('id');

      Swal.fire({
        title: 'Are you sure?',
        text:  "This cannot be undone.",
        icon:  'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post('pages/delete_message.php', { id: id, csrf_token: csrfToken })
           .done(function (response) {
             if (response.trim() === 'success') {
               item.fadeOut(300, () => item.remove());
               Swal.fire('Deleted!', 'Message removed.', 'success');
             } else {
               Swal.fire('Error!', response, 'error');
             }
           })
           .fail(() => {
             Swal.fire('Error!', 'Request failed.', 'error');
           });
        }
      });
    });

    // Reply from detail modal
    $('#replyBtn').on('click', function () {
      $('#messageModal').modal('hide');
      $('#toEmail').val($('#modalEmail').text());
      $('#subject').val('Re: ' + $('#modalSubject').text());
      $('#composeModal').modal('show');
    });

    // Reply from list
    $('.reply-message').on('click', function (e) {
      e.stopPropagation();
      const item = $(this).closest('.message-item');
      $('#toEmail').val(item.data('email'));
      $('#subject').val('Re: ' + item.data('subject'));
      $('#composeModal').modal('show');
    });

    // Search
    $('#searchButton').on('click', searchMessages);
    $('#searchInput').on('keyup', e => e.key === 'Enter' && searchMessages());

    function searchMessages() {
      const term = $('#searchInput').val().toLowerCase();
      $('.message-item').each(function () {
        $(this).toggle($(this).text().toLowerCase().includes(term));
      });
    }
  });
 });
 
</script>
