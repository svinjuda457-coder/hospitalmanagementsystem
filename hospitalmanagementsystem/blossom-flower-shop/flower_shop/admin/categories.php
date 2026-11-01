<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Categories';

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_category'])) {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $status = $_POST['status'] ?? 'active';
    $slug = slugify($name);
    $image = null;

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp'])) {
            $image = 'cat_' . time() . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . $image);
        }
    }

    if ($id) {
        if ($image) {
            $pdo->prepare("UPDATE categories SET name=?, slug=?, description=?, status=?, image=? WHERE id=?")
                ->execute([$name, $slug, $description, $status, $image, $id]);
        } else {
            $pdo->prepare("UPDATE categories SET name=?, slug=?, description=?, status=? WHERE id=?")
                ->execute([$name, $slug, $description, $status, $id]);
        }
        flash('success', 'Category updated.');
    } else {
        $pdo->prepare("INSERT INTO categories (name, slug, description, status, image) VALUES (?,?,?,?,?)")
            ->execute([$name, $slug, $description, $status, $image]);
        flash('success', 'Category added.');
    }
    redirect('admin/categories.php');
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM categories WHERE id=?")->execute([(int)$_GET['delete']]);
    flash('success', 'Category deleted.');
    redirect('admin/categories.php');
}

$categories = $pdo->query("SELECT c.*, COUNT(p.id) AS product_count FROM categories c LEFT JOIN products p ON p.category_id=c.id GROUP BY c.id ORDER BY c.id DESC")->fetchAll();

$edit_cat = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_cat = $stmt->fetch();
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="dash-card">
      <h6 class="mb-3"><?php echo $edit_cat ? 'Edit Category' : 'Add New Category'; ?></h6>
      <form method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo $edit_cat['id'] ?? ''; ?>">
        <div class="mb-3"><label class="form-label">Category Name</label><input type="text" name="name" class="form-control" required value="<?php echo e($edit_cat['name'] ?? ''); ?>"></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"><?php echo e($edit_cat['description'] ?? ''); ?></textarea></div>
        <div class="mb-3"><label class="form-label">Image</label><input type="file" name="image" class="form-control" accept="image/*"></div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="active" <?php echo ($edit_cat['status'] ?? '')=='active'?'selected':''; ?>>Active</option>
            <option value="inactive" <?php echo ($edit_cat['status'] ?? '')=='inactive'?'selected':''; ?>>Inactive</option>
          </select>
        </div>
        <button type="submit" name="save_category" class="btn btn-bloom w-100"><?php echo $edit_cat ? 'Update Category' : 'Add Category'; ?></button>
        <?php if ($edit_cat): ?><a href="<?php echo BASE_URL; ?>admin/categories.php" class="btn btn-light w-100 mt-2">Cancel Edit</a><?php endif; ?>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="dash-card">
      <h6 class="mb-3">All Categories (<?php echo count($categories); ?>)</h6>
      <div class="table-responsive">
        <table class="table table-bfs align-middle">
          <thead><tr><th>Name</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
          <?php foreach ($categories as $c): ?>
            <tr>
              <td><?php echo e($c['name']); ?></td>
              <td><?php echo $c['product_count']; ?></td>
              <td><span class="badge status-badge bg-<?php echo $c['status']=='active'?'success':'secondary'; ?>"><?php echo ucfirst($c['status']); ?></span></td>
              <td>
                <a href="?edit=<?php echo $c['id']; ?>" class="btn btn-sm btn-bloom-outline"><i class="fa-solid fa-pen"></i></a>
                <a href="?delete=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category? Products in it will also be removed.');"><i class="fa-solid fa-trash"></i></a>
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
