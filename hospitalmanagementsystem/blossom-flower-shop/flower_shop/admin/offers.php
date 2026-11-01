<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Offers / Discounts';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_offer'])) {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title']);
    $code = strtoupper(trim($_POST['code']));
    $discount_percent = (int)$_POST['discount_percent'];
    $valid_from = $_POST['valid_from'] ?: null;
    $valid_to = $_POST['valid_to'] ?: null;
    $status = $_POST['status'] ?? 'active';

    if ($id) {
        $pdo->prepare("UPDATE offers SET title=?, code=?, discount_percent=?, valid_from=?, valid_to=?, status=? WHERE id=?")
            ->execute([$title, $code, $discount_percent, $valid_from, $valid_to, $status, $id]);
        flash('success', 'Offer updated.');
    } else {
        $pdo->prepare("INSERT INTO offers (title, code, discount_percent, valid_from, valid_to, status) VALUES (?,?,?,?,?,?)")
            ->execute([$title, $code, $discount_percent, $valid_from, $valid_to, $status]);
        flash('success', 'Offer created.');
    }
    redirect('admin/offers.php');
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM offers WHERE id=?")->execute([(int)$_GET['delete']]);
    flash('success', 'Offer deleted.');
    redirect('admin/offers.php');
}

$edit_offer = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM offers WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_offer = $stmt->fetch();
}

$offers = $pdo->query("SELECT * FROM offers ORDER BY id DESC")->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="dash-card">
      <h6 class="mb-3"><?php echo $edit_offer ? 'Edit Offer' : 'Create New Offer'; ?></h6>
      <form method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo $edit_offer['id'] ?? ''; ?>">
        <div class="mb-3"><label class="form-label">Title</label><input type="text" name="title" class="form-control" required value="<?php echo e($edit_offer['title'] ?? ''); ?>"></div>
        <div class="mb-3"><label class="form-label">Promo Code</label><input type="text" name="code" class="form-control text-uppercase" required value="<?php echo e($edit_offer['code'] ?? ''); ?>"></div>
        <div class="mb-3"><label class="form-label">Discount %</label><input type="number" name="discount_percent" class="form-control" min="1" max="90" required value="<?php echo e($edit_offer['discount_percent'] ?? ''); ?>"></div>
        <div class="row">
          <div class="col-6 mb-3"><label class="form-label">Valid From</label><input type="date" name="valid_from" class="form-control" value="<?php echo e($edit_offer['valid_from'] ?? ''); ?>"></div>
          <div class="col-6 mb-3"><label class="form-label">Valid To</label><input type="date" name="valid_to" class="form-control" value="<?php echo e($edit_offer['valid_to'] ?? ''); ?>"></div>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="active" <?php echo ($edit_offer['status'] ?? '')=='active'?'selected':''; ?>>Active</option>
            <option value="inactive" <?php echo ($edit_offer['status'] ?? '')=='inactive'?'selected':''; ?>>Inactive</option>
          </select>
        </div>
        <button type="submit" name="save_offer" class="btn btn-bloom w-100"><?php echo $edit_offer ? 'Update Offer' : 'Create Offer'; ?></button>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="dash-card">
      <h6 class="mb-3">All Offers</h6>
      <div class="table-responsive">
        <table class="table table-bfs align-middle">
          <thead><tr><th>Title</th><th>Code</th><th>Discount</th><th>Valid Period</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
          <?php foreach ($offers as $o): ?>
            <tr>
              <td><?php echo e($o['title']); ?></td>
              <td><code><?php echo e($o['code']); ?></code></td>
              <td><?php echo $o['discount_percent']; ?>%</td>
              <td class="small"><?php echo e($o['valid_from']); ?> &ndash; <?php echo e($o['valid_to']); ?></td>
              <td><span class="badge status-badge bg-<?php echo $o['status']=='active'?'success':'secondary'; ?>"><?php echo ucfirst($o['status']); ?></span></td>
              <td>
                <a href="?edit=<?php echo $o['id']; ?>" class="btn btn-sm btn-bloom-outline"><i class="fa-solid fa-pen"></i></a>
                <a href="?delete=<?php echo $o['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this offer?');"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
