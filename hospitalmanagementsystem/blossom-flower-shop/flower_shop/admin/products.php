<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$page_title = 'Manage Flowers';

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM products WHERE id=?")->execute([(int)$_GET['delete']]);
    flash('success', 'Product deleted.');
    redirect('admin/products.php');
}
if (isset($_GET['toggle'])) {
    $pdo->prepare("UPDATE products SET status = IF(status='active','inactive','active') WHERE id=?")->execute([(int)$_GET['toggle']]);
    redirect('admin/products.php');
}

$search = trim($_GET['q'] ?? '');
$sql = "SELECT p.*, c.name AS cat_name FROM products p JOIN categories c ON p.category_id=c.id";
$params = [];
if ($search !== '') {
    $sql .= " WHERE p.name LIKE ?";
    $params[] = "%$search%";
}
$sql .= " ORDER BY p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

<div class="dash-card">
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form class="d-flex gap-2">
      <input type="text" name="q" class="form-control form-control-sm" placeholder="Search flowers..." value="<?php echo e($search); ?>">
      <button class="btn btn-sm btn-bloom-outline" type="submit">Search</button>
    </form>
    <a href="<?php echo BASE_URL; ?>admin/add-product.php" class="btn btn-bloom btn-sm"><i class="fa-solid fa-plus me-1"></i> Add Flower</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bfs align-middle">
      <thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><img src="<?php echo product_image_url($p['image']); ?>" style="width:46px;height:46px;object-fit:cover;border-radius:8px;"></td>
          <td><?php echo e($p['name']); ?><?php if($p['is_featured']): ?> <span class="badge bg-pink-light text-pink">Featured</span><?php endif; ?><?php if($p['is_bestseller']): ?> <span class="badge bg-warning text-dark">Bestseller</span><?php endif; ?></td>
          <td><?php echo e($p['cat_name']); ?></td>
          <td>
            <?php if ($p['discount_price']): ?>
              <span class="text-decoration-line-through text-muted small"><?php echo format_price($p['price']); ?></span><br>
              <?php echo format_price($p['discount_price']); ?>
            <?php else: echo format_price($p['price']); endif; ?>
          </td>
          <td><?php echo $p['stock']; ?></td>
          <td>
            <a href="?toggle=<?php echo $p['id']; ?>" class="badge status-badge bg-<?php echo $p['status']=='active'?'success':'secondary'; ?> text-decoration-none">
              <?php echo ucfirst($p['status']); ?>
            </a>
          </td>
          <td>
            <a href="<?php echo BASE_URL; ?>admin/add-product.php?edit=<?php echo $p['id']; ?>" class="btn btn-sm btn-bloom-outline"><i class="fa-solid fa-pen"></i></a>
            <a href="?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?');"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$products): ?><tr><td colspan="7" class="text-center text-muted py-4">No products found.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
